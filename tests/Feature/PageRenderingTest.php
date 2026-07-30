<?php

use App\Models\Order;
use App\Models\PortfolioItem;
use App\Models\User;

test('the public shop page renders', function () {
    $this->get(route('home'))
        ->assertOk()
        ->assertSee('Send us a Message');
});

test('the sole picker stays hidden until the shop enables it', function () {
    config()->set('features.sole_lab', false);

    $this->get(route('home'))
        ->assertOk()
        ->assertDontSee('Pick Your Sole and Color')
        ->assertDontSee('id="soles"', escape: false);
});

test('the sole picker shows up once enabled', function () {
    config()->set('features.sole_lab', true);

    $this->get(route('home'))
        ->assertOk()
        ->assertSee('Pick Your Sole and Color')
        ->assertSee('Dress shoe');
});

test('the public portfolio page renders', function () {
    PortfolioItem::factory()->withPhotos()->create();

    $this->get(route('portfolio'))->assertOk();
});

test('every customer page renders', function () {
    $customer = User::factory()->create();
    $order = Order::factory()->for($customer, 'client')->create();

    $this->actingAs($customer);

    $this->get(route('orders.index'))->assertOk()->assertSee($order->order_number);
    $this->get(route('orders.create'))->assertOk();
    $this->get(route('orders.show', $order))->assertOk()->assertSee($order->order_number);
});

test('every shop page renders', function () {
    $admin = User::factory()->admin()->create();
    $order = Order::factory()->for(User::factory()->create(), 'client')->create();

    $this->actingAs($admin);

    $this->get(route('admin.dashboard'))->assertOk();
    $this->get(route('admin.orders.index'))->assertOk()->assertSee($order->order_number);
    $this->get(route('admin.orders.create'))->assertOk();
    $this->get(route('admin.orders.show', $order))->assertOk()->assertSee($order->order_number);
    $this->get(route('admin.customers.index'))->assertOk();

    $case = PortfolioItem::factory()->withPhotos()->create();

    $this->get(route('admin.portfolio.index'))->assertOk()->assertSee($case->title);
    $this->get(route('admin.portfolio.create'))->assertOk();
    $this->get(route('admin.portfolio.edit', $case))->assertOk()->assertSee($case->title);
});
