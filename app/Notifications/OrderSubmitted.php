<?php

namespace App\Notifications;

use App\Models\Order;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class OrderSubmitted extends Notification
{
    /**
     * Create a new notification instance.
     */
    public function __construct(public Order $order) {}

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
        return (new MailMessage)
            ->subject(__('New service request — :order', ['order' => $this->order->order_number]))
            ->line(__(':name submitted a new :service request.', [
                'name' => $this->order->contact_name,
                'service' => $this->order->service_type->label(),
            ]))
            ->line(__('Shoe type: :type', ['type' => $this->order->shoe_type->label()]))
            ->line(str($this->order->description)->limit(200)->toString())
            ->action(__('Open the order'), route('admin.orders.show', $this->order));
    }
}
