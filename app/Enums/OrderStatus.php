<?php

namespace App\Enums;

enum OrderStatus: string
{
    case Received = 'received';
    case InProcess = 'in_process';
    case Ready = 'ready';
    case Delivered = 'delivered';
    case Cancelled = 'cancelled';

    /**
     * Get the human readable label for the status.
     */
    public function label(): string
    {
        return match ($this) {
            self::Received => __('Received'),
            self::InProcess => __('In process'),
            self::Ready => __('Ready for pickup'),
            self::Delivered => __('Delivered'),
            self::Cancelled => __('Cancelled'),
        };
    }

    /**
     * Get a customer facing explanation of the status.
     */
    public function description(): string
    {
        return match ($this) {
            self::Received => __('We have your shoes and they are in line for the workbench.'),
            self::InProcess => __('Our cobbler is working on your shoes right now.'),
            self::Ready => __('Your shoes are finished and waiting for you at the shop.'),
            self::Delivered => __('Your shoes have been picked up. Thank you!'),
            self::Cancelled => __('This order was cancelled. Contact the shop if you have questions.'),
        };
    }

    /**
     * Get the Flux color used for badges and accents.
     */
    public function color(): string
    {
        return match ($this) {
            self::Received => 'sky',
            self::InProcess => 'amber',
            self::Ready => 'green',
            self::Delivered => 'zinc',
            self::Cancelled => 'red',
        };
    }

    /**
     * Get the icon that represents the status.
     */
    public function icon(): string
    {
        return match ($this) {
            self::Received => 'inbox-arrow-down',
            self::InProcess => 'wrench-screwdriver',
            self::Ready => 'check-badge',
            self::Delivered => 'truck',
            self::Cancelled => 'x-circle',
        };
    }

    /**
     * Get the position of the status inside the fulfillment pipeline.
     */
    public function step(): int
    {
        return match ($this) {
            self::Received => 1,
            self::InProcess => 2,
            self::Ready => 3,
            self::Delivered => 4,
            self::Cancelled => 0,
        };
    }

    /**
     * Determine whether the order is still being worked on.
     */
    public function isOpen(): bool
    {
        return in_array($this, [self::Received, self::InProcess], strict: true);
    }

    /**
     * Determine whether the status closes the order.
     */
    public function isFinal(): bool
    {
        return in_array($this, [self::Delivered, self::Cancelled], strict: true);
    }

    /**
     * Get the next status of the fulfillment pipeline, if any.
     */
    public function next(): ?self
    {
        return match ($this) {
            self::Received => self::InProcess,
            self::InProcess => self::Ready,
            self::Ready => self::Delivered,
            self::Delivered, self::Cancelled => null,
        };
    }

    /**
     * Get the statuses that make up the happy path of an order.
     *
     * @return array<int, self>
     */
    public static function pipeline(): array
    {
        return [self::Received, self::InProcess, self::Ready, self::Delivered];
    }

    /**
     * Get the statuses that mean the shop still owes work to the customer.
     *
     * @return array<int, string>
     */
    public static function openValues(): array
    {
        return [self::Received->value, self::InProcess->value];
    }

    /**
     * Get the statuses as a value => label map.
     *
     * @return array<string, string>
     */
    public static function options(): array
    {
        return collect(self::cases())
            ->mapWithKeys(fn (self $status): array => [$status->value => $status->label()])
            ->all();
    }
}
