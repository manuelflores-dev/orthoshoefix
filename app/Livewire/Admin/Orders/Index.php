<?php

namespace App\Livewire\Admin\Orders;

use App\Enums\OrderStatus;
use App\Enums\ServiceType;
use App\Models\Order;
use Flux\Flux;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Title;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

#[Title('Orders')]
class Index extends Component
{
    use AuthorizesRequests, WithPagination;

    #[Url(as: 'q', except: '')]
    public string $search = '';

    #[Url(except: '')]
    public string $status = '';

    #[Url(except: '')]
    public string $service = '';

    #[Url(except: '')]
    public string $from = '';

    #[Url(except: '')]
    public string $to = '';

    /**
     * Reset pagination whenever a filter changes.
     */
    public function updated(string $property): void
    {
        if ($property !== 'page') {
            $this->resetPage();
        }
    }

    /**
     * Get the filtered orders.
     *
     * @return LengthAwarePaginator<int, Order>
     */
    #[Computed]
    public function orders(): LengthAwarePaginator
    {
        return Order::query()
            ->with('client')
            ->search($this->search)
            ->when($this->status !== '', fn ($query) => $query->where('status', $this->status))
            ->when($this->service !== '', fn ($query) => $query->where('service_type', $this->service))
            ->when($this->from !== '', fn ($query) => $query->whereDate('received_at', '>=', $this->from))
            ->when($this->to !== '', fn ($query) => $query->whereDate('received_at', '<=', $this->to))
            ->latest('received_at')
            ->latest('id')
            ->paginate(12);
    }

    /**
     * Get the status options for the filter bar.
     *
     * @return array<string, string>
     */
    #[Computed]
    public function statusOptions(): array
    {
        return OrderStatus::options();
    }

    /**
     * Get the service type options for the filter bar.
     *
     * @return array<string, string>
     */
    #[Computed]
    public function serviceOptions(): array
    {
        return ServiceType::options();
    }

    /**
     * Determine whether any filter is currently applied.
     */
    #[Computed]
    public function hasFilters(): bool
    {
        return $this->search !== ''
            || $this->status !== ''
            || $this->service !== ''
            || $this->from !== ''
            || $this->to !== '';
    }

    /**
     * Clear every filter.
     */
    public function clearFilters(): void
    {
        $this->reset(['search', 'status', 'service', 'from', 'to']);
        $this->resetPage();
    }

    /**
     * Move an order to the given status straight from the list.
     */
    public function markAs(int $orderId, string $status): void
    {
        $order = Order::findOrFail($orderId);

        $this->authorize('update', $order);

        $order->markAs(OrderStatus::from($status), Auth::user());

        unset($this->orders);

        Flux::toast(
            variant: 'success',
            text: __(':order is now :status.', [
                'order' => $order->order_number,
                'status' => $order->status->label(),
            ]),
        );
    }

    /**
     * Render the component.
     */
    public function render(): View
    {
        return view('livewire.admin.orders.index');
    }
}
