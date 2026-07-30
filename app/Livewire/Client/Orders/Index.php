<?php

namespace App\Livewire\Client\Orders;

use App\Models\Order;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('My orders')]
class Index extends Component
{
    /**
     * Get the orders of the signed in customer.
     *
     * @return Collection<int, Order>
     */
    #[Computed]
    public function orders(): Collection
    {
        return Order::query()
            ->forClient(Auth::id())
            ->latest('received_at')
            ->latest('id')
            ->get();
    }

    /**
     * Get the orders that can already be picked up.
     *
     * @return Collection<int, Order>
     */
    #[Computed]
    public function readyOrders(): Collection
    {
        return $this->orders->filter->isReadyForPickup();
    }

    /**
     * Refresh the list, used by the polling indicator.
     */
    public function refreshOrders(): void
    {
        unset($this->orders, $this->readyOrders);
    }

    /**
     * Render the component.
     */
    public function render(): View
    {
        return view('livewire.client.orders.index');
    }
}
