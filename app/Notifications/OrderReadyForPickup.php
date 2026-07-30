<?php

namespace App\Notifications;

use App\Models\Order;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class OrderReadyForPickup extends Notification
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
            ->subject(__('Your shoes are ready for pickup — :order', ['order' => $this->order->order_number]))
            ->greeting(__('Good news, :name!', ['name' => $notifiable->name]))
            ->line(__('Order :order (:service) is finished and waiting for you at the shop.', [
                'order' => $this->order->order_number,
                'service' => $this->order->service_type->label(),
            ]))
            ->when($this->order->estimated_price !== null, fn (MailMessage $message): MailMessage => $message->line(
                __('Estimated total: :price', ['price' => '$'.number_format((float) $this->order->estimated_price, 2)]),
            ))
            ->action(__('View my order'), route('orders.show', $this->order))
            ->line(__('Thank you for trusting OrthoShoeFix with your shoes.'));
    }
}
