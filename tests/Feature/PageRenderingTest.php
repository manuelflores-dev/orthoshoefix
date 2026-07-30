<?php

use App\Models\Order;
use App\Models\User;

test('the public shop page renders', function () {
    $this->get(route('home'))->assertOk();
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
});
