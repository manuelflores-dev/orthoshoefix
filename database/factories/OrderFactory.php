<?php

namespace Database\Factories;

use App\Enums\OrderStatus;
use App\Enums\ServiceType;
use App\Enums\ShoeType;
use App\Models\Order;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Order>
 */
class OrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $receivedAt = fake()->dateTimeBetween('-3 months', 'now');

        return [
            'user_id' => User::factory(),
            'created_by' => null,
            'service_type' => fake()->randomElement(ServiceType::cases()),
            'shoe_type' => fake()->randomElement(ShoeType::cases()),
            'description' => fake()->randomElement([
                'Right heel is worn down and the stitching came loose on the side.',
                'Needs a 12 mm lift on the left sole per my podiatrist prescription.',
                'Custom insole feels flat, would like it rebuilt with more arch support.',
                'Sole is separating from the upper on both shoes.',
                'Requesting rocker sole modification to relieve forefoot pressure.',
                'Zipper broken on the inner side of the boot.',
            ]),
            'status' => OrderStatus::Received,
            'estimated_price' => fake()->randomElement([35, 45, 60, 75, 90, 120, 165]),
            'received_at' => $receivedAt,
            'estimated_delivery_at' => fake()->dateTimeBetween($receivedAt, '+2 weeks'),
            'internal_notes' => null,
        ];
    }

    /**
     * Configure the factory to inherit the contact details of the customer.
     */
    public function configure(): static
    {
        return $this->afterMaking(function (Order $order): void {
            $client = $order->client ?? User::find($order->user_id);

            $order->contact_name ??= $client?->name ?? fake()->name();
            $order->contact_phone ??= $client?->phone ?? fake()->numerify('##########');
            $order->contact_email ??= $client?->email ?? fake()->safeEmail();
        });
    }

    /**
     * Set the order status.
     */
    public function status(OrderStatus $status): static
    {
        return $this->state(fn (array $attributes): array => [
            'status' => $status,
            'ready_at' => in_array($status, [OrderStatus::Ready, OrderStatus::Delivered], strict: true)
                ? fake()->dateTimeBetween($attributes['received_at'], 'now')
                : null,
            'delivered_at' => $status === OrderStatus::Delivered
                ? fake()->dateTimeBetween($attributes['received_at'], 'now')
                : null,
        ]);
    }

    /**
     * Indicate that the order is waiting to be picked up.
     */
    public function readyForPickup(): static
    {
        return $this->status(OrderStatus::Ready);
    }

    /**
     * Indicate that the order has been delivered.
     */
    public function delivered(): static
    {
        return $this->status(OrderStatus::Delivered);
    }

    /**
     * Indicate that the order was taken in by the shop.
     */
    public function takenInBy(User $admin): static
    {
        return $this->state(fn (array $attributes): array => [
            'created_by' => $admin->id,
        ]);
    }
}
