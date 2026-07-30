<?php

namespace App\Livewire\Client\Orders;

use App\Enums\ServiceType;
use App\Enums\ShoeType;
use App\Models\Order;
use App\Models\User;
use App\Notifications\OrderSubmitted;
use Flux\Flux;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;
use Livewire\WithFileUploads;

#[Title('Request a service')]
class Create extends Component
{
    use AuthorizesRequests, WithFileUploads;

    /**
     * The maximum amount of reference photos per order.
     */
    public const MAX_PHOTOS = 5;

    public string $service_type = ServiceType::Repair->value;

    public string $shoe_type = ShoeType::DressShoe->value;

    public string $description = '';

    /**
     * @var array<int, TemporaryUploadedFile>
     */
    public array $photos = [];

    public string $contact_name = '';

    public ?string $contact_phone = null;

    public ?string $contact_email = null;

    /**
     * Mount the component.
     */
    public function mount(): void
    {
        $user = Auth::user();

        $this->contact_name = $user->name;
        $this->contact_phone = $user->phone;
        $this->contact_email = $user->email;
    }

    /**
     * Get the validation rules.
     *
     * @return array<string, array<int, mixed>>
     */
    protected function rules(): array
    {
        return [
            'service_type' => ['required', 'string', 'in:'.implode(',', array_keys(ServiceType::options()))],
            'shoe_type' => ['required', 'string', 'in:'.implode(',', array_keys(ShoeType::options()))],
            'description' => ['required', 'string', 'min:10', 'max:2000'],
            'photos' => ['array', 'max:'.self::MAX_PHOTOS],
            'photos.*' => ['image', 'max:5120'],
            'contact_name' => ['required', 'string', 'max:255'],
            'contact_phone' => ['required', 'numeric', 'digits:10'],
            'contact_email' => ['nullable', 'email', 'max:255'],
        ];
    }

    /**
     * Get the validation messages.
     *
     * @return array<string, string>
     */
    protected function messages(): array
    {
        return [
            'description.min' => __('Please describe the problem with a bit more detail.'),
            'photos.*.image' => __('Only image files can be attached.'),
            'photos.*.max' => __('Each photo must be smaller than 5 MB.'),
            'contact_phone.digits' => __('Enter a 10 digit phone number so we can call you.'),
        ];
    }

    /**
     * Validate every photo as soon as it is attached.
     */
    public function updatedPhotos(): void
    {
        $this->validateOnly('photos');
        $this->validateOnly('photos.*');
    }

    /**
     * Remove a photo before submitting the request.
     */
    public function removePhoto(int $index): void
    {
        unset($this->photos[$index]);

        $this->photos = array_values($this->photos);
    }

    /**
     * Submit the service request.
     */
    public function save(): void
    {
        $this->authorize('create', Order::class);

        $validated = $this->validate();

        $order = Order::create([
            'user_id' => Auth::id(),
            'service_type' => $validated['service_type'],
            'shoe_type' => $validated['shoe_type'],
            'description' => $validated['description'],
            'contact_name' => $validated['contact_name'],
            'contact_phone' => $validated['contact_phone'],
            'contact_email' => $validated['contact_email'],
            'received_at' => today(),
        ]);

        foreach ($this->photos as $photo) {
            $order->photos()->create([
                'path' => $photo->store('order-photos', 'public'),
                'original_name' => $photo->getClientOriginalName(),
                'size' => $photo->getSize(),
            ]);
        }

        Notification::send(User::query()->admins()->get(), new OrderSubmitted($order));

        Flux::toast(
            variant: 'success',
            text: __('Request :number sent. We will keep you posted here.', ['number' => $order->order_number]),
        );

        $this->redirectRoute('orders.show', $order, navigate: true);
    }

    /**
     * Get the service types offered by the shop.
     *
     * @return array<int, ServiceType>
     */
    #[Computed]
    public function serviceTypes(): array
    {
        return ServiceType::cases();
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
