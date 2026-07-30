<?php

namespace App\Enums;

enum ShoeType: string
{
    case DressShoe = 'dress_shoe';
    case Sneaker = 'sneaker';
    case Boot = 'boot';
    case Sandal = 'sandal';
    case Heels = 'heels';
    case OrthopedicShoe = 'orthopedic_shoe';
    case Other = 'other';

    /**
     * Get the human readable label for the shoe type.
     */
    public function label(): string
    {
        return match ($this) {
            self::DressShoe => __('Dress shoe'),
            self::Sneaker => __('Sneaker'),
            self::Boot => __('Boot'),
            self::Sandal => __('Sandal'),
            self::Heels => __('Heels'),
            self::OrthopedicShoe => __('Orthopedic shoe'),
            self::Other => __('Other'),
        };
    }

    /**
     * Get the shoe types as a value => label map.
     *
     * @return array<string, string>
     */
    public static function options(): array
    {
        return collect(self::cases())
            ->mapWithKeys(fn (self $type): array => [$type->value => $type->label()])
            ->all();
    }
}
