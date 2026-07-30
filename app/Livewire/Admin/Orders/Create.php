<?php

namespace App\Livewire\Admin\Orders;

use App\Enums\ServiceType;
use App\Enums\ShoeType;
use App\Models\Order;
use App\Models\User;
use Flux\Flux;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Title;
use Livewire\Attributes\Url;
use Livewire\Component;

#[Title('New intake')]
class Create extends Component
{
    use AuthorizesRequests;

    #[Url(as: 'customer', except: null)]
    public ?int $user_id = null;

    public string $clientSearch = '';

    public string $service_type = ServiceType::Repair->value;

    public string $shoe_type = ShoeType::DressShoe->value;

    public string $description = '';

    public ?string $estimated_price = null;

    public string $received_at = '';

    public ?string $estimated_delivery_at = null;

    public ?string $internal_notes = null;

    /**
     * Mount the component.
     */
    public function mount(): void
    {
        $this->received_at = today()->toDateString();
        $this->estimated_delivery_at = today()->addWeek()->toDateString();
    }

    /**
     * Get the customers matching the current search.
     *
     * @return Collection<int, User>
     */
    #[Computed]
    public function clients(): Collection
    {
        return User::query()
            ->clients()
            ->when($this->clientSearch !== '', function ($query): void {
                $term = "%{$this->clientSearch}%";

                $query->where(fn ($query) => $query
                    ->where('name', 'like', $term)
                    ->orWhere('email', 'like', $term)
                    ->orWhere('phone', 'like', $term));
            })
            ->orderBy('name')
            ->limit(50)
            ->get();
    }

    /**
     * Register the order.
     */
    public function save(): void
    {
        $this->authorize('create', Order::class);

        $validated = $this->validate([
            'user_id' => ['required', 'integer', 'exists:users,id'],
            'service_type' => ['required', 'string', 'in:'.implode(',', array_keys(ServiceType::options()))],
            'shoe_type' => ['required', 'string', 'in:'.implode(',', array_keys(ShoeType::options()))],
            'description' => ['required', 'string', 'min:10', 'max:2000'],
            'estimated_price' => ['nullable', 'numeric', 'min:0', 'max:99999.99'],
            'received_at' => ['required', 'date'],
            'estimated_delivery_at' => ['nullable', 'date', 'after_or_equal:received_at'],
            'internal_notes' => ['nullable', 'string', 'max:2000'],
        ], attributes: [
            'user_id' => __('customer'),
        ]);

        $client = User::query()->clients()->findOrFail($validated['user_id']);

        $order = Order::create([
            ...$validated,
            'created_by' => Auth::id(),
            'contact_name' => $client->name,
            'contact_phone' => $client->phone,
            'contact_email' => $client->email,
        ]);

        Flux::toast(
            variant: 'success',
            text: __('Order :number registered for :name.', [
                'number' => $order->order_number,
                'name' => $client->name,
            ]),
        );

        $this->redirectRoute('admin.orders.show', $order, navigate: true);
    }

    /**
     * Get the service type options.
     *
     * @return array<string, string>
     */
    #[Computed]
    public function serviceOptions(): array
    {
        return ServiceType::options();
    }

    /**
     * Get the shoe type options.
     *
     * @return array<string, string>
     */
    #[Computed]
    public function shoeOptions(): array
    {
        return ShoeType::options();
    }
}
