<?php

namespace Database\Factories;

use App\Enums\PortfolioLayout;
use App\Models\PortfolioItem;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<PortfolioItem>
 */
class PortfolioItemFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => fake()->unique()->randomElement([
                'New Balance — Sole Lift',
                'Medical Clogs — Arch Relief',
                'Leather Boots — Rocker Sole',
                'Dress Shoes — Heel Rebuild',
                'Sandals — Custom Footbed',
            ]),
            'summary' => fake()->sentence(12),
            'layout' => PortfolioLayout::BeforeAfter,
            'badge' => null,
            'tags' => ['Leg Length', 'Rx Required'],
            'is_published' => true,
            'sort_order' => 0,
        ];
    }

    /**
     * Indicate that the case is not shown on the website.
     */
    public function draft(): static
    {
        return $this->state(fn (array $attributes): array => [
            'is_published' => false,
        ]);
    }

    /**
     * Attach a before and after photo to the case.
     */
    public function withPhotos(int $count = 2): static
    {
        return $this->afterCreating(function (PortfolioItem $item) use ($count): void {
            foreach (range(1, $count) as $position) {
                $item->photos()->create([
                    'path' => "images/shoes/process-{$position}.jpg",
                    'label' => $position === 1 ? 'BEFORE' : 'AFTER',
                    'sort_order' => $position,
                ]);
            }
        });
    }
}
