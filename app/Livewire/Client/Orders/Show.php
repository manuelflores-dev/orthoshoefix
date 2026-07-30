<?php

namespace App\Livewire\Client\Orders;

use App\Enums\OrderStatus;
use App\Models\Order;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Carbon;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Locked;
use Livewire\Component;

class Show extends Component
{
    use AuthorizesRequests;

    #[Locked]
    public int $orderId;

    /**
     * Mount the component.
     */
    public function mount(Order $order): void
    {
        $this->authorize('view', $order);

        $this->orderId = $order->id;
    }

    /**
     * Get the order being tracked.
     */
    #[Computed]
    public function order(): Order
    {
        return Order::with(['photos', 'statusEvents'])->findOrFail($this->orderId);
    }

    /**
     * Get the statuses of the pipeline with their timestamps.
     *
     * @return array<int, array{status: OrderStatus, reached: bool, current: bool, at: ?Carbon}>
     */
    #[Computed]
    public function steps(): array
    {
        $order = $this->order;
        $events = $order->statusEvents->keyBy(fn ($event) => $event->to_status->value);

        return collect(OrderStatus::pipeline())
            ->map(fn (OrderStatus $status): array => [
                'status' => $status,
                'reached' => $order->status !== OrderStatus::Cancelled
                    && $status->step() <= $order->status->step(),
                'current' => $status === $order->status,
                'at' => $events->get($status->value)?->created_at,
            ])
            ->all();
    }

    /**
     * Refresh the tracker, used by the polling indicator.
     */
    public function refreshOrder(): void
    {
        unset($this->order, $this->steps);
    }

    /**
     * Render the component with a title based on the order number.
     */
    public function render(): View
    {
        return view('livewire.client.orders.show')
            ->title(__('Order :number', ['number' => $this->order->order_number]));
    }
}
