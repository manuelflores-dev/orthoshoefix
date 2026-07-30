<?php

use App\Enums\OrderStatus;
use App\Livewire\Admin\Dashboard;
use App\Livewire\Admin\Orders\Create;
use App\Livewire\Admin\Orders\Index;
use App\Livewire\Admin\Orders\Show;
use App\Models\Order;
use App\Models\User;
use App\Notifications\OrderReadyForPickup;
use Illuminate\Support\Facades\Notification;
use Livewire\Livewire;

test('customers cannot reach the shop area', function () {
    $this->actingAs(User::factory()->create());

    $this->get(route('admin.dashboard'))->assertForbidden();
    $this->get(route('admin.orders.index'))->assertForbidden();
    $this->get(route('admin.customers.index'))->assertForbidden();
});

test('administrators can reach the shop area', function () {
    $this->actingAs(User::factory()->admin()->create());

    $this->get(route('admin.dashboard'))->assertOk();
    $this->get(route('admin.orders.index'))->assertOk();
    $this->get(route('admin.customers.index'))->assertOk();
});

test('the dashboard reports the metrics of the shop', function () {
    Notification::fake();

    $admin = User::factory()->admin()->create();
    $customer = User::factory()->create();

    Order::factory(2)->for($customer, 'client')->create();
    Order::factory()->for($customer, 'client')->status(OrderStatus::InProcess)->create();
    Order::factory(2)->for($customer, 'client')->readyForPickup()->create();

    Order::factory(3)->for($customer, 'client')->create([
        'estimated_price' => 50,
        'delivered_at' => now(),
        'status' => OrderStatus::Delivered,
    ]);

    // Delivered last month, so it must not count towards this month.
    Order::factory()->for($customer, 'client')->create([
        'estimated_price' => 500,
        'delivered_at' => now()->subMonthNoOverflow()->startOfMonth(),
        'status' => OrderStatus::Delivered,
    ]);

    $this->actingAs($admin);

    $metrics = Livewire::test(Dashboard::class)->get('metrics');

    expect($metrics['active'])->toBe(3)
        ->and($metrics['ready'])->toBe(2)
        ->and($metrics['delivered_this_month'])->toBe(3)
        ->and($metrics['revenue_this_month'])->toBe(150.0)
        ->and($metrics['customers'])->toBe(1);
});

test('an administrator can filter orders by status, customer and date', function () {
    $admin = User::factory()->admin()->create();
    $ada = User::factory()->create(['name' => 'Ada Kowalski']);
    $ben = User::factory()->create(['name' => 'Ben Ortiz']);

    $ready = Order::factory()->for($ada, 'client')->readyForPickup()->create(['received_at' => '2026-07-10']);
    $open = Order::factory()->for($ben, 'client')->create(['received_at' => '2026-01-05']);

    $this->actingAs($admin);

    Livewire::test(Index::class)
        ->set('status', OrderStatus::Ready->value)
        ->assertSee($ready->order_number)
        ->assertDontSee($open->order_number)
        ->set('status', '')
        ->set('search', 'Kowalski')
        ->assertSee($ready->order_number)
        ->assertDontSee($open->order_number)
        ->set('search', '')
        ->set('from', '2026-07-01')
        ->assertSee($ready->order_number)
        ->assertDontSee($open->order_number)
        ->call('clearFilters')
        ->assertSee($open->order_number);
});

test('an administrator can advance an order from the list', function () {
    Notification::fake();

    $admin = User::factory()->admin()->create();
    $order = Order::factory()->for(User::factory()->create(), 'client')->create();

    $this->actingAs($admin);

    Livewire::test(Index::class)
        ->call('markAs', $order->id, OrderStatus::InProcess->value);

    expect($order->refresh()->status)->toBe(OrderStatus::InProcess);
});

test('an administrator can update an order and record the change', function () {
    Notification::fake();

    $admin = User::factory()->admin()->create();
    $order = Order::factory()->for(User::factory()->create(), 'client')->create([
        'estimated_price' => null,
    ]);

    $this->actingAs($admin);

    Livewire::test(Show::class, ['order' => $order])
        ->set('status', OrderStatus::InProcess->value)
        ->set('estimated_price', '89.50')
        ->set('estimated_delivery_at', '2026-08-15')
        ->set('internal_notes', 'Used 8 mm crepe wedge.')
        ->set('statusNote', 'Started the lift build up.')
        ->call('save')
        ->assertHasNoErrors();

    $order->refresh();

    expect($order->status)->toBe(OrderStatus::InProcess)
        ->and((float) $order->estimated_price)->toBe(89.5)
        ->and($order->estimated_delivery_at->toDateString())->toBe('2026-08-15')
        ->and($order->internal_notes)->toBe('Used 8 mm crepe wedge.')
        ->and($order->statusEvents)->toHaveCount(2);

    $change = $order->statusEvents->last();

    expect($change->from_status)->toBe(OrderStatus::Received)
        ->and($change->to_status)->toBe(OrderStatus::InProcess)
        ->and($change->changed_by)->toBe($admin->id)
        ->and($change->note)->toBe('Started the lift build up.');
});

test('marking an order ready stamps the date and notifies the customer', function () {
    Notification::fake();

    $admin = User::factory()->admin()->create();
    $customer = User::factory()->create();
    $order = Order::factory()->for($customer, 'client')->status(OrderStatus::InProcess)->create();

    $this->actingAs($admin);

    Livewire::test(Show::class, ['order' => $order])->call('advance');

    $order->refresh();

    expect($order->status)->toBe(OrderStatus::Ready)
        ->and($order->ready_at)->not->toBeNull();

    Notification::assertSentTo($customer, OrderReadyForPickup::class);

    // Delivering the order must not notify the customer a second time.
    Livewire::test(Show::class, ['order' => $order])->call('advance');

    expect($order->refresh()->status)->toBe(OrderStatus::Delivered)
        ->and($order->delivered_at)->not->toBeNull();

    Notification::assertSentToTimes($customer, OrderReadyForPickup::class, 1);
});

test('an administrator can cancel an order', function () {
    Notification::fake();

    $admin = User::factory()->admin()->create();
    $order = Order::factory()->for(User::factory()->create(), 'client')->create();

    $this->actingAs($admin);

    Livewire::test(Show::class, ['order' => $order])
        ->set('statusNote', 'Customer bought new shoes.')
        ->call('cancel');

    expect($order->refresh()->status)->toBe(OrderStatus::Cancelled);
});

test('an administrator can register an order for a customer', function () {
    $admin = User::factory()->admin()->create();
    $customer = User::factory()->create();

    $this->actingAs($admin);

    Livewire::test(Create::class)
        ->set('user_id', $customer->id)
        ->set('description', 'Rebuild the right heel and replace both soles.')
        ->set('estimated_price', '120')
        ->set('estimated_delivery_at', today()->addDays(5)->toDateString())
        ->call('save')
        ->assertHasNoErrors()
        ->assertRedirect();

    $order = Order::sole();

    expect($order->user_id)->toBe($customer->id)
        ->and($order->created_by)->toBe($admin->id)
        ->and($order->contact_name)->toBe($customer->name)
        ->and($order->status)->toBe(OrderStatus::Received);
});

test('only the shop can update orders', function () {
    $admin = User::factory()->admin()->create();
    $customer = User::factory()->create();
    $stranger = User::factory()->create();
    $order = Order::factory()->for($customer, 'client')->create();

    expect($customer->can('view', $order))->toBeTrue()
        ->and($customer->can('update', $order))->toBeFalse()
        ->and($stranger->can('view', $order))->toBeFalse()
        ->and($admin->can('view', $order))->toBeTrue()
        ->and($admin->can('update', $order))->toBeTrue();
});
