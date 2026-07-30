<?php

namespace App\Livewire\Admin\Orders;

use App\Enums\OrderStatus;
use App\Models\Order;
use Flux\Flux;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Locked;
use Livewire\Component;

class Show extends Component
{
    use AuthorizesRequests;

    #[Locked]
    public int $orderId;

    public string $status = '';

    public ?string $estimated_price = null;

    public ?string $estimated_delivery_at = null;

    public ?string $internal_notes = null;

    public string $statusNote = '';

    /**
     * Mount the component.
     */
    public function mount(Order $order): void
    {
        $this->authorize('update', $order);

        $this->orderId = $order->id;
        $this->status = $order->status->value;
        $this->estimated_price = $order->estimated_price;
        $this->estimated_delivery_at = $order->estimated_delivery_at?->toDateString();
        $this->internal_notes = $order->internal_notes;
    }

    /**
     * Get the order being managed.
     */
    #[Computed]
    public function order(): Order
    {
        return Order::with(['client', 'createdBy', 'photos', 'statusEvents.changedBy'])
            ->findOrFail($this->orderId);
    }

    /**
     * Render the component with a title based on the order number.
     */
    public function render(): View
    {
        return view('livewire.admin.orders.show')
            ->title(__('Order :number', ['number' => $this->order->order_number]));
    }

    /**
     * Persist the workshop details of the order.
     */
    public function save(): void
    {
        $order = $this->order;

        $this->authorize('update', $order);

        $validated = $this->validate([
            'status' => ['required', 'string', 'in:'.implode(',', array_keys(OrderStatus::options()))],
            'estimated_price' => ['nullable', 'numeric', 'min:0', 'max:99999.99'],
            'estimated_delivery_at' => ['nullable', 'date'],
            'internal_notes' => ['nullable', 'string', 'max:2000'],
            'statusNote' => ['nullable', 'string', 'max:500'],
        ]);

        $order->fill([
            'estimated_price' => $validated['estimated_price'],
            'estimated_delivery_at' => $validated['estimated_delivery_at'],
            'internal_notes' => $validated['internal_notes'],
        ])->save();

        $order->markAs(
            OrderStatus::from($validated['status']),
            Auth::user(),
            $validated['statusNote'] ?: null,
        );

        $this->statusNote = '';
        unset($this->order);

        Flux::toast(variant: 'success', text: __('Order updated.'));
    }

    /**
     * Advance the order to the next status of the pipeline.
     */
    public function advance(): void
    {
        $order = $this->order;

        $this->authorize('update', $order);

        $next = $order->status->next();

        if ($next === null) {
            Flux::toast(variant: 'warning', text: __('This order is already closed.'));

            return;
        }

        $order->markAs($next, Auth::user());

        $this->status = $next->value;
        unset($this->order);

        Flux::toast(
            variant: 'success',
            text: __('Order moved to :status.', ['status' => $next->label()]),
        );
    }

    /**
     * Cancel the order.
     */
    public function cancel(): void
    {
        $order = $this->order;

        $this->authorize('update', $order);

        $order->markAs(OrderStatus::Cancelled, Auth::user(), $this->statusNote ?: null);

        $this->status = OrderStatus::Cancelled->value;
        $this->statusNote = '';
        unset($this->order);

        Flux::toast(variant: 'danger', text: __('Order cancelled.'));
    }

    /**
     * Get the selectable statuses.
     *
     * @return array<string, string>
     */
    #[Computed]
    public function statusOptions(): array
    {
        return OrderStatus::options();
    }
}
