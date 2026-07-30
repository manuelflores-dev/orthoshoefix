<?php

namespace App\Livewire\Admin;

use App\Enums\OrderStatus;
use App\Models\Order;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Workshop dashboard')]
class Dashboard extends Component
{
    /**
     * Get the headline metrics of the shop.
     *
     * @return array<string, int|float>
     */
    #[Computed]
    public function metrics(): array
    {
        $startOfMonth = now()->startOfMonth();

        return [
            'active' => Order::query()->open()->count(),
            'ready' => Order::query()->readyForPickup()->count(),
            'delivered_this_month' => Order::query()
                ->where('status', OrderStatus::Delivered)
                ->where('delivered_at', '>=', $startOfMonth)
                ->count(),
            'revenue_this_month' => (float) Order::query()
                ->where('status', OrderStatus::Delivered)
                ->where('delivered_at', '>=', $startOfMonth)
                ->sum('estimated_price'),
            'overdue' => Order::query()
                ->open()
                ->whereNotNull('estimated_delivery_at')
                ->whereDate('estimated_delivery_at', '<', today())
                ->count(),
            'customers' => User::query()->clients()->count(),
        ];
    }

    /**
     * Get the orders waiting to be picked up.
     *
     * @return Collection<int, Order>
     */
    #[Computed]
    public function readyOrders(): Collection
    {
        return Order::query()
            ->readyForPickup()
            ->with('client')
            ->orderBy('ready_at')
            ->limit(6)
            ->get();
    }

    /**
     * Get the latest intake, whatever its status.
     *
     * @return Collection<int, Order>
     */
    #[Computed]
    public function recentOrders(): Collection
    {
        return Order::query()
            ->with('client')
            ->latest('created_at')
            ->limit(8)
            ->get();
    }

    /**
     * Get the number of open orders grouped by status.
     *
     * @return array<string, int>
     */
    #[Computed]
    public function pipeline(): array
    {
        $counts = Order::query()
            ->selectRaw('status, count(*) as aggregate')
            ->groupBy('status')
            ->pluck('aggregate', 'status')
            ->all();

        return collect(OrderStatus::pipeline())
            ->mapWithKeys(fn (OrderStatus $status): array => [
                $status->value => (int) ($counts[$status->value] ?? 0),
            ])
            ->all();
    }
}
