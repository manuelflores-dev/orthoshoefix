<?php

namespace App\Notifications;

use App\Models\ContactMessage;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ContactMessageReceived extends Notification
{
    /**
     * Create a new notification instance.
     */
    public function __construct(public ContactMessage $contactMessage) {}

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        $message = (new MailMessage)
            ->subject(__('Website inquiry from :name', ['name' => $this->contactMessage->name]))
            ->line(__('A visitor sent a message from the website contact form.'))
            ->line(__('Name: :name', ['name' => $this->contactMessage->name]))
            ->line(__('Email: :email', ['email' => $this->contactMessage->email]));

        if (filled($this->contactMessage->phone)) {
            $message->line(__('Phone: :phone', ['phone' => $this->contactMessage->phone]));
        }

        if (filled($this->contactMessage->service)) {
            $message->line(__('Interested in: :service', ['service' => $this->contactMessage->service]));
        }

        return $message
            ->line('---')
            ->line($this->contactMessage->message)
            ->action(__('Reply by email'), 'mailto:'.$this->contactMessage->email);
    }
}
