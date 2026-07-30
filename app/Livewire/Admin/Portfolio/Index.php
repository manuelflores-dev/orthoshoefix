<?php

namespace App\Livewire\Admin\Portfolio;

use App\Models\PortfolioItem;
use Flux\Flux;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Portfolio')]
class Index extends Component
{
    /**
     * Get every case, published or not, in display order.
     *
     * @return Collection<int, PortfolioItem>
     */
    #[Computed]
    public function items(): Collection
    {
        return PortfolioItem::query()
            ->with('photos')
            ->ordered()
            ->get();
    }

    /**
     * Show or hide a case on the website.
     */
    public function togglePublished(int $itemId): void
    {
        $item = PortfolioItem::with('photos')->findOrFail($itemId);

        if (! $item->is_published && $item->photos->isEmpty()) {
            Flux::toast(variant: 'warning', text: __('Add at least one photo before publishing.'));

            return;
        }

        $item->update(['is_published' => ! $item->is_published]);

        unset($this->items);

        Flux::toast(
            variant: 'success',
            text: $item->is_published
                ? __('":title" is now visible on the website.', ['title' => $item->title])
                : __('":title" is hidden from the website.', ['title' => $item->title]),
        );
    }

    /**
     * Move a case one position up or down in the website order.
     */
    public function move(int $itemId, string $direction): void
    {
        $items = $this->items->values();
        $index = $items->search(fn (PortfolioItem $item): bool => $item->id === $itemId);

        if ($index === false) {
            return;
        }

        $target = $direction === 'up' ? $index - 1 : $index + 1;

        if ($target < 0 || $target >= $items->count()) {
            return;
        }

        // Rewrite the whole column so the order stays consistent whatever it was before.
        $reordered = $items->all();
        [$reordered[$index], $reordered[$target]] = [$reordered[$target], $reordered[$index]];

        foreach ($reordered as $position => $item) {
            $item->update(['sort_order' => $position + 1]);
        }

        unset($this->items);
    }

    /**
     * Delete a case and its photos.
     */
    public function delete(int $itemId): void
    {
        $item = PortfolioItem::with('photos')->findOrFail($itemId);

        // Deleting through the models so the files get cleaned up too.
        $item->photos->each->delete();
        $item->delete();

        unset($this->items);

        Flux::toast(variant: 'success', text: __('Case deleted.'));
    }

    /**
     * Render the component.
     */
    public function render(): View
    {
        return view('livewire.admin.portfolio.index');
    }
}
