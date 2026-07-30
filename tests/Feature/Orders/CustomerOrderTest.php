<?php

use App\Enums\OrderStatus;
use App\Enums\ServiceType;
use App\Enums\ShoeType;
use App\Livewire\Client\Orders\Create;
use App\Livewire\Client\Orders\Index;
use App\Livewire\Client\Orders\Show;
use App\Models\Order;
use App\Models\User;
use App\Notifications\OrderSubmitted;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Storage;
use Livewire\Livewire;

test('guests cannot reach the customer area', function () {
    $this->get(route('orders.index'))->assertRedirect(route('login'));
    $this->get(route('orders.create'))->assertRedirect(route('login'));
});

test('a customer can submit a service request', function () {
    Notification::fake();

    $admin = User::factory()->admin()->create();
    $customer = User::factory()->create(['phone' => '3135550123']);

    $this->actingAs($customer);

    Livewire::test(Create::class)
        ->assertSet('contact_name', $customer->name)
        ->assertSet('contact_phone', $customer->phone)
        ->set('service_type', ServiceType::OrthopedicModification->value)
        ->set('shoe_type', ShoeType::Boot->value)
        ->set('description', 'Please add a 12 mm lift to the left sole as prescribed.')
        ->call('save')
        ->assertHasNoErrors();

    $order = Order::sole();

    expect($order->user_id)->toBe($customer->id)
        ->and($order->created_by)->toBeNull()
        ->and($order->status)->toBe(OrderStatus::Received)
        ->and($order->service_type)->toBe(ServiceType::OrthopedicModification)
        ->and($order->order_number)->toStartWith('OSF-')
        ->and($order->contact_phone)->toBe('3135550123')
        ->and($order->received_at->isToday())->toBeTrue();

    // The intake is always the first entry of the history.
    expect($order->statusEvents)->toHaveCount(1)
        ->and($order->statusEvents->first()->to_status)->toBe(OrderStatus::Received);

    Notification::assertSentTo($admin, OrderSubmitted::class);
});

test('a service request requires a description and a phone number', function () {
    $this->actingAs(User::factory()->create());

    Livewire::test(Create::class)
        ->set('description', 'too short')
        ->set('contact_phone', '123')
        ->call('save')
        ->assertHasErrors(['description', 'contact_phone']);

    expect(Order::count())->toBe(0);
});

test('a customer can attach photos to a request', function () {
    Storage::fake('public');
    Notification::fake();

    $this->actingAs(User::factory()->create(['phone' => '3135550124']));

    Livewire::test(Create::class)
        ->set('description', 'The sole is separating from the upper on both shoes.')
        ->set('photos', [UploadedFile::fake()->image('left.jpg'), UploadedFile::fake()->image('right.jpg')])
        ->call('save')
        ->assertHasNoErrors();

    $order = Order::sole();

    expect($order->photos)->toHaveCount(2);

    Storage::disk('public')->assertExists($order->photos->first()->path);
});

test('a customer only sees their own orders', function () {
    $customer = User::factory()->create();
    $other = User::factory()->create();

    $own = Order::factory()->for($customer, 'client')->create();
    $foreign = Order::factory()->for($other, 'client')->create();

    $this->actingAs($customer);

    Livewire::test(Index::class)
        ->assertSee($own->order_number)
        ->assertDontSee($foreign->order_number);
});

test('a customer cannot open the order of another customer', function () {
    $customer = User::factory()->create();
    $foreign = Order::factory()->for(User::factory()->create(), 'client')->create();

    $this->actingAs($customer);

    $this->get(route('orders.show', $foreign))->assertForbidden();
});

test('the tracker shows a timestamp for every stage reached', function () {
    $admin = User::factory()->admin()->create();
    $customer = User::factory()->create();
    $order = Order::factory()->for($customer, 'client')->create();

    $order->markAs(OrderStatus::InProcess, $admin);
    $order->markAs(OrderStatus::Ready, $admin);

    $this->actingAs($customer);

    $steps = collect(Livewire::test(Show::class, ['order' => $order])
        ->assertSee('Ready for pickup')
        ->get('steps'));

    expect($steps->firstWhere('status', OrderStatus::Ready)['at'])->not->toBeNull()
        ->and($steps->firstWhere('status', OrderStatus::Ready)['current'])->toBeTrue()
        ->and($steps->firstWhere('status', OrderStatus::Delivered)['at'])->toBeNull()
        ->and($steps->firstWhere('status', OrderStatus::Delivered)['reached'])->toBeFalse();
});
