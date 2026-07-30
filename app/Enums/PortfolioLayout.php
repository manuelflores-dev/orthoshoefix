<?php

namespace App\Enums;

enum PortfolioLayout: string
{
    case BeforeAfter = 'before_after';
    case Process = 'process';

    /**
     * Get the human readable label for the layout.
     */
    public function label(): string
    {
        return match ($this) {
            self::BeforeAfter => __('Before / after (2 photos)'),
            self::Process => __('Step by step process (up to 4 photos)'),
        };
    }

    /**
     * Get how many photos the layout is designed for.
     */
    public function photoLimit(): int
    {
        return match ($this) {
            self::BeforeAfter => 2,
            self::Process => 4,
        };
    }

    /**
     * Determine whether the case is rendered full width.
     */
    public function isWide(): bool
    {
        return $this === self::Process;
    }

    /**
     * Get the layouts as a value => label map.
     *
     * @return array<string, string>
     */
    public static function options(): array
    {
        return collect(self::cases())
            ->mapWithKeys(fn (self $layout): array => [$layout->value => $layout->label()])
            ->all();
    }
}
