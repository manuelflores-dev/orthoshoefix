<?php

namespace App\Livewire\Admin\Customers;

use App\Concerns\ProfileValidationRules;
use App\Enums\UserRole;
use App\Models\User;
use Flux\Flux;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Str;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Title;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

#[Title('Customers')]
class Index extends Component
{
    use ProfileValidationRules, WithPagination;

    #[Url(as: 'q', except: '')]
    public string $search = '';

    public string $name = '';

    public string $email = '';

    public ?string $phone = null;

    public string $password = '';

    public bool $generatePassword = true;

    /**
     * The password generated for the customer created last, shown once.
     */
    public ?string $temporaryPassword = null;

    /**
     * Reset pagination whenever the search changes.
     */
    public function updatedSearch(): void
    {
        $this->resetPage();
    }

    /**
     * Get the customers of the shop.
     *
     * @return LengthAwarePaginator<int, User>
     */
    #[Computed]
    public function customers(): LengthAwarePaginator
    {
        return User::query()
            ->clients()
            ->when($this->search !== '', function ($query): void {
                $term = "%{$this->search}%";

                $query->where(fn ($query) => $query
                    ->where('name', 'like', $term)
                    ->orWhere('email', 'like', $term)
                    ->orWhere('phone', 'like', $term));
            })
            ->withCount([
                'orders',
                'orders as open_orders_count' => fn ($query) => $query->open(),
                'orders as ready_orders_count' => fn ($query) => $query->readyForPickup(),
            ])
            ->orderBy('name')
            ->paginate(12);
    }

    /**
     * Register a walk-in customer from the shop panel.
     */
    public function createCustomer(): void
    {
        // Livewire keeps cleared inputs as empty strings, which the phone rules reject.
        $this->phone = blank($this->phone) ? null : $this->phone;

        $validated = $this->validate([
            'name' => $this->nameRules(),
            'email' => $this->emailRules(),
            'phone' => ['nullable', ...$this->phoneRules()],
            'password' => $this->generatePassword
                ? ['nullable']
                : ['required', 'string', 'min:8', 'max:255'],
        ]);

        $password = $this->generatePassword
            ? Str::password(10, symbols: false)
            : $validated['password'];

        $customer = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'password' => $password,
            'role' => UserRole::Client,
        ]);

        // Registered in person by the shop, so there is nothing to verify.
        $customer->forceFill(['email_verified_at' => now()])->save();

        $this->reset(['name', 'email', 'phone', 'password']);
        $this->temporaryPassword = $this->generatePassword ? $password : null;
        unset($this->customers);

        Flux::modal('create-customer')->close();

        Flux::toast(
            variant: 'success',
            text: __(':name was added as a customer.', ['name' => $customer->name]),
        );
    }

    /**
     * Forget the generated password shown in the panel.
     */
    public function dismissTemporaryPassword(): void
    {
        $this->temporaryPassword = null;
    }

    /**
     * Render the component.
     */
    public function render(): View
    {
        return view('livewire.admin.customers.index');
    }
}
