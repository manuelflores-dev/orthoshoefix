<?php

namespace Database\Seeders;

use App\Enums\OrderStatus;
use App\Enums\UserRole;
use App\Models\Order;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Notification;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Seeding walks orders through their statuses, so silence the customer emails.
        Notification::fake();

        $admin = User::firstOrCreate(
            ['email' => 'admin@orthoshoefix.com'],
            [
                'name' => 'Shop Admin',
                'phone' => '5551000001',
                'password' => 'password',
                'role' => UserRole::Admin,
                'email_verified_at' => now(),
            ],
        );

        $demoClient = User::firstOrCreate(
            ['email' => 'customer@example.com'],
            [
                'name' => 'Dana Whitmore',
                'phone' => '5552000001',
                'password' => 'password',
                'role' => UserRole::Client,
                'email_verified_at' => now(),
            ],
        );

        $clients = User::factory(8)->create()->push($demoClient);

        // A realistic mix of orders across every stage of the workshop pipeline.
        $distribution = [
            OrderStatus::Received->value => 6,
            OrderStatus::InProcess->value => 5,
            OrderStatus::Ready->value => 4,
            OrderStatus::Delivered->value => 9,
            OrderStatus::Cancelled->value => 1,
        ];

        foreach ($distribution as $status => $count) {
            Order::factory($count)
                ->recycle($clients)
                ->takenInBy($admin)
                ->create()
                ->each(fn (Order $order) => $this->walkTo($order, OrderStatus::from($status), $admin));
        }

        // Give the demo customer one order in progress and one ready for pickup.
        $this->walkTo(
            Order::factory()->for($demoClient, 'client')->takenInBy($admin)->create(),
            OrderStatus::InProcess,
            $admin,
        );

        $this->walkTo(
            Order::factory()->for($demoClient, 'client')->takenInBy($admin)->create(),
            OrderStatus::Ready,
            $admin,
        );
    }

    /**
     * Move an order through the pipeline and spread the history over its lifetime.
     */
    private function walkTo(Order $order, OrderStatus $target, User $admin): void
    {
        if ($target === OrderStatus::Cancelled) {
            $order->markAs($target, $admin, 'Customer decided to replace the shoes instead.');
        } else {
            foreach (OrderStatus::pipeline() as $status) {
                if ($status === OrderStatus::Received || $status->step() > $target->step()) {
                    continue;
                }

                $order->markAs($status, $admin, match ($status) {
                    OrderStatus::InProcess => 'On the workbench.',
                    OrderStatus::Ready => 'Finished, customer notified.',
                    OrderStatus::Delivered => 'Picked up at the counter.',
                    default => null,
                });
            }
        }

        $events = $order->statusEvents()->orderBy('id')->get();

        // Backdate the history so demo timelines read like real ones.
        $spanInMinutes = max(60, (int) $order->received_at->diffInMinutes(now()));
        $stepInMinutes = intdiv($spanInMinutes, max(1, $events->count()));

        $events->each(function ($event, int $index) use ($order, $stepInMinutes): void {
            $at = $order->received_at->addMinutes($stepInMinutes * $index);

            $event->forceFill(['created_at' => $at, 'updated_at' => $at])->save();
        });

        $order->forceFill([
            'ready_at' => $events->firstWhere('to_status', OrderStatus::Ready)?->created_at,
            'delivered_at' => $events->firstWhere('to_status', OrderStatus::Delivered)?->created_at,
        ])->save();
    }
}
