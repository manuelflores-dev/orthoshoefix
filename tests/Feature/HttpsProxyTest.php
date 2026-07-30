<?php

use App\Models\Order;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

test('livewire urls stay on https behind a tls terminating proxy', function () {
    $this->actingAs(User::factory()->create());

    $html = $this->get(route('orders.create'), ['X-Forwarded-Proto' => 'https'])
        ->assertOk()
        ->getContent();

    // Livewire prints absolute URLs, so any http:// one is blocked as mixed content.
    expect($html)->toContain('data-update-uri="https://')
        ->and($html)->not->toContain('data-update-uri="http://');
});

test('order photos are served over https, whatever APP_URL says', function () {
    Storage::fake('public');

    // A stale APP_URL is exactly what broke the photos in production.
    config()->set('app.url', 'http://203.0.113.10');
    config()->set('filesystems.disks.public.url', 'http://203.0.113.10/storage');

    $customer = User::factory()->create();
    $order = Order::factory()->for($customer, 'client')->create();
    $order->photos()->create([
        'path' => UploadedFile::fake()->image('shoe.jpg')->store('order-photos', 'public'),
        'original_name' => 'shoe.jpg',
    ]);

    $this->actingAs($customer);

    $html = $this->get(route('orders.show', $order), ['X-Forwarded-Proto' => 'https'])
        ->assertOk()
        ->getContent();

    preg_match('/<img[^>]*src="([^"]*order-photos[^"]*)"/', $html, $matches);

    expect($matches[1] ?? null)->toStartWith('https://')
        ->and($html)->not->toContain('http://203.0.113.10');
});

test('the forwarded protocol is honoured for generated urls', function () {
    $this->get('/', ['X-Forwarded-Proto' => 'https'])->assertOk();

    expect(request()->isSecure())->toBeTrue()
        ->and(route('register'))->toStartWith('https://');
});
