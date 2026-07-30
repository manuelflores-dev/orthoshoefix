<?php

namespace App\Enums;

enum ServiceType: string
{
    case Repair = 'repair';
    case OrthopedicModification = 'orthopedic_modification';
    case Other = 'other';

    /**
     * Get the human readable label for the service type.
     */
    public function label(): string
    {
        return match ($this) {
            self::Repair => __('Repair'),
            self::OrthopedicModification => __('Orthopedic modification'),
            self::Other => __('Other service'),
        };
    }

    /**
     * Get a short explanation shown next to the option.
     */
    public function description(): string
    {
        return match ($this) {
            self::Repair => __('Soles, heels, stitching, zippers, general restoration.'),
            self::OrthopedicModification => __('Lifts, rocker soles, custom insoles, prescription adjustments.'),
            self::Other => __('Cleaning, dyeing, stretching or anything else.'),
        };
    }

    /**
     * Get the icon that represents the service type.
     */
    public function icon(): string
    {
        return match ($this) {
            self::Repair => 'wrench-screwdriver',
            self::OrthopedicModification => 'sparkles',
            self::Other => 'shopping-bag',
        };
    }

    /**
     * Get the service types as a value => label map.
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
