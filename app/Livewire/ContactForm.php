<?php

namespace App\Livewire;

use App\Models\ContactMessage;
use App\Models\User;
use App\Notifications\ContactMessageReceived;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\RateLimiter;
use Livewire\Attributes\On;
use Livewire\Component;

class ContactForm extends Component
{
    /**
     * How many messages a single visitor may send per hour.
     */
    public const MAX_PER_HOUR = 5;

    public string $name = '';

    public string $email = '';

    public ?string $phone = null;

    public string $service = '';

    public string $message = '';

    public bool $sent = false;

    /**
     * The services a visitor can ask about.
     *
     * @return array<int, string>
     */
    public function services(): array
    {
        // Kept free of ampersands and quotes so they travel safely in HTML attributes.
        return [
            'Sole lifts and leg length correction',
            'Custom orthotics and insoles',
            'Premium shoe restoration',
            'Something else',
        ];
    }

    /**
     * Get the validation rules.
     *
     * @return array<string, array<int, mixed>>
     */
    protected function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'phone' => ['nullable', 'string', 'max:30'],
            'service' => ['nullable', 'string', 'in:'.implode(',', $this->services())],
            'message' => ['required', 'string', 'min:10', 'max:2000'],
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
            'message.min' => __('Please tell us a little more so we can help.'),
        ];
    }

    /**
     * Preselect a service when a visitor arrives from a service card.
     */
    #[On('contact-service-selected')]
    public function selectService(string $service): void
    {
        if (in_array($service, $this->services(), strict: true)) {
            $this->service = $service;
        }
    }

    /**
     * Store the inquiry and notify the shop.
     */
    public function send(): void
    {
        $validated = $this->validate();

        // Keep a public form from being used as a mail cannon.
        $key = 'contact-form:'.request()->ip();

        if (RateLimiter::tooManyAttempts($key, self::MAX_PER_HOUR)) {
            $this->addError('message', __('You have sent several messages already. Please call us at (800) 555-0199.'));

            return;
        }

        RateLimiter::hit($key, 3600);

        $contactMessage = ContactMessage::create([
            ...$validated,
            'ip_address' => request()->ip(),
        ]);

        // Stored first, so an unreachable mail server never loses an inquiry.
        Notification::send(User::query()->admins()->get(), new ContactMessageReceived($contactMessage));

        $this->reset(['name', 'email', 'phone', 'service', 'message']);
        $this->sent = true;
    }

    /**
     * Let the visitor send another message.
     */
    public function sendAnother(): void
    {
        $this->sent = false;
    }

    /**
     * Render the component.
     */
    public function render(): View
    {
        return view('livewire.contact-form');
    }
}
