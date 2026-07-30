<?php

namespace App\Livewire;

use App\Models\PortfolioItem;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Attributes\Computed;
use Livewire\Component;

class Home extends Component
{
    /**
     * How many cases the landing page shows before sending visitors to /portfolio.
     */
    public const FEATURED_CASES = 3;

    /**
     * Get the cases featured on the landing page.
     *
     * @return Collection<int, PortfolioItem>
     */
    #[Computed]
    public function portfolioItems(): Collection
    {
        return PortfolioItem::query()
            ->published()
            ->ordered()
            ->with('photos')
            ->limit(self::FEATURED_CASES)
            ->get();
    }

    /**
     * Get the featured cases rendered full width.
     *
     * @return Collection<int, PortfolioItem>
     */
    #[Computed]
    public function portfolioWideItems(): Collection
    {
        return $this->portfolioItems->filter(fn (PortfolioItem $item): bool => $item->layout->isWide());
    }

    /**
     * Get the featured cases rendered in the two column grid.
     *
     * @return Collection<int, PortfolioItem>
     */
    #[Computed]
    public function portfolioGridItems(): Collection
    {
        return $this->portfolioItems
            ->filter(fn (PortfolioItem $item): bool => ! $item->layout->isWide())
            ->values();
    }

    public function render()
    {
        return view('livewire.home')
            ->layout('layouts.public');
    }
}
