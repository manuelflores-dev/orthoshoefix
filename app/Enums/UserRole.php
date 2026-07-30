<?php

namespace App\Enums;

enum UserRole: string
{
    case Admin = 'admin';
    case Client = 'client';

    /**
     * Get the human readable label for the role.
     */
    public function label(): string
    {
        return match ($this) {
            self::Admin => __('Administrator'),
            self::Client => __('Customer'),
        };
    }

    /**
     * Get the roles as a value => label map.
     *
     * @return array<string, string>
     */
    public static function options(): array
    {
        return collect(self::cases())
            ->mapWithKeys(fn (self $role): array => [$role->value => $role->label()])
            ->all();
    }
}
