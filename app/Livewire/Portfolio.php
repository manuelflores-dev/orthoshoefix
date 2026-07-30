<?php

namespace App\Livewire;

use App\Models\PortfolioItem;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Attributes\Computed;
use Livewire\Component;

class Portfolio extends Component
{
    /**
     * Get the published cases.
     *
     * @return Collection<int, PortfolioItem>
     */
    #[Computed]
    public function items(): Collection
    {
        return PortfolioItem::query()
            ->published()
            ->ordered()
            ->with('photos')
            ->get();
    }

    /**
     * Get the full width cases.
     *
     * @return Collection<int, PortfolioItem>
     */
    #[Computed]
    public function wideItems(): Collection
    {
        return $this->items->filter(fn (PortfolioItem $item): bool => $item->layout->isWide());
    }

    /**
     * Get the cases rendered in the two column grid.
     *
     * @return Collection<int, PortfolioItem>
     */
    #[Computed]
    public function gridItems(): Collection
    {
        return $this->items->filter(fn (PortfolioItem $item): bool => ! $item->layout->isWide());
    }

    /**
     * Render the component.
     */
    public function render(): View
    {
        return view('livewire.portfolio')->layout('layouts.public');
    }
}
