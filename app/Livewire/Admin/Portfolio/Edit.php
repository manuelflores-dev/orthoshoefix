<?php

namespace App\Livewire\Admin\Portfolio;

use App\Enums\PortfolioLayout;
use App\Models\PortfolioItem;
use App\Models\PortfolioPhoto;
use Flux\Flux;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Locked;
use Livewire\Component;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;
use Livewire\WithFileUploads;

class Edit extends Component
{
    use WithFileUploads;

    #[Locked]
    public ?int $itemId = null;

    public string $title = '';

    public ?string $summary = null;

    public string $layout = PortfolioLayout::BeforeAfter->value;

    public ?string $badge = null;

    public string $tagList = '';

    public bool $is_published = false;

    /**
     * Photos waiting to be attached.
     *
     * @var array<int, TemporaryUploadedFile>
     */
    public array $uploads = [];

    /**
     * Labels and captions of the photos already attached, keyed by photo id.
     *
     * @var array<int, array{label: ?string, caption: ?string}>
     */
    public array $photoDetails = [];

    /**
     * Mount the component for a new or an existing case.
     */
    public function mount(?PortfolioItem $item = null): void
    {
        if (! $item?->exists) {
            return;
        }

        $this->itemId = $item->id;
        $this->title = $item->title;
        $this->summary = $item->summary;
        $this->layout = $item->layout->value;
        $this->badge = $item->badge;
        $this->tagList = implode(', ', $item->tags ?? []);
        $this->is_published = $item->is_published;

        $this->syncPhotoDetails();
    }

    /**
     * Get the case being edited, if it was already saved.
     */
    #[Computed]
    public function item(): ?PortfolioItem
    {
        return $this->itemId === null
            ? null
            : PortfolioItem::with('photos')->find($this->itemId);
    }

    /**
     * Get the layout options.
     *
     * @return array<string, string>
     */
    #[Computed]
    public function layoutOptions(): array
    {
        return PortfolioLayout::options();
    }

    /**
     * Get how many photos this layout is designed for.
     */
    #[Computed]
    public function photoLimit(): int
    {
        return PortfolioLayout::from($this->layout)->photoLimit();
    }

    /**
     * Get the validation rules.
     *
     * @return array<string, array<int, mixed>>
     */
    protected function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'summary' => ['nullable', 'string', 'max:1000'],
            'layout' => ['required', 'string', 'in:'.implode(',', array_keys(PortfolioLayout::options()))],
            'badge' => ['nullable', 'string', 'max:40'],
            'tagList' => ['nullable', 'string', 'max:255'],
            'uploads' => ['array', 'max:'.$this->photoLimit],
            'uploads.*' => ['image', 'max:5120'],
        ];
    }

    /**
     * Get the validation messages.
     *
     * @return array<string, string>
     */
    protected function messages(): array
    {
        return [
            'uploads.*.image' => __('Only image files can be attached.'),
            'uploads.*.max' => __('Each photo must be smaller than 5 MB.'),
        ];
    }

    /**
     * Save the case, attaching any new photos.
     */
    public function save(): void
    {
        $validated = $this->validate();

        $tags = collect(explode(',', (string) $this->tagList))
            ->map(fn (string $tag): string => trim($tag))
            ->filter()
            ->take(6)
            ->values()
            ->all();

        $item = $this->item ?? new PortfolioItem(['created_by' => Auth::id()]);

        $item->fill([
            'title' => $validated['title'],
            'summary' => $validated['summary'],
            'layout' => $validated['layout'],
            'badge' => $validated['badge'],
            'tags' => $tags,
        ]);

        if ($item->sort_order === null || $item->sort_order === 0) {
            $item->sort_order = (int) PortfolioItem::max('sort_order') + 1;
        }

        $item->save();

        $position = (int) $item->photos()->max('sort_order');

        foreach ($this->uploads as $upload) {
            $item->photos()->create([
                'path' => $upload->store('portfolio', PortfolioPhoto::DISK),
                'sort_order' => ++$position,
            ]);
        }

        // A case is only worth showing once it has a photo.
        $item->update([
            'is_published' => $this->is_published && $item->photos()->exists(),
        ]);

        $this->reset('uploads');
        $this->itemId = $item->id;
        unset($this->item);
        $this->syncPhotoDetails();

        if ($this->is_published && ! $item->is_published) {
            $this->is_published = false;

            Flux::toast(variant: 'warning', text: __('Saved as a draft: add a photo before publishing.'));

            return;
        }

        Flux::toast(variant: 'success', text: __('Case saved.'));
    }

    /**
     * Store the label and caption typed for an attached photo.
     */
    public function savePhotoDetails(int $photoId): void
    {
        $photo = $this->item?->photos->firstWhere('id', $photoId);

        if ($photo === null) {
            return;
        }

        $photo->update([
            'label' => $this->photoDetails[$photoId]['label'] ?? null,
            'caption' => $this->photoDetails[$photoId]['caption'] ?? null,
        ]);

        unset($this->item);

        Flux::toast(variant: 'success', text: __('Photo caption updated.'));
    }

    /**
     * Detach a photo from the case.
     */
    public function deletePhoto(int $photoId): void
    {
        $photo = $this->item?->photos->firstWhere('id', $photoId);

        if ($photo === null) {
            return;
        }

        $photo->delete();

        unset($this->item);
        $this->syncPhotoDetails();

        Flux::toast(variant: 'success', text: __('Photo removed.'));
    }

    /**
     * Move a photo one position up or down.
     */
    public function movePhoto(int $photoId, string $direction): void
    {
        $photos = $this->item?->photos->values();

        if ($photos === null) {
            return;
        }

        $index = $photos->search(fn (PortfolioPhoto $photo): bool => $photo->id === $photoId);

        if ($index === false) {
            return;
        }

        $target = $direction === 'up' ? $index - 1 : $index + 1;

        if ($target < 0 || $target >= $photos->count()) {
            return;
        }

        $reordered = $photos->all();
        [$reordered[$index], $reordered[$target]] = [$reordered[$target], $reordered[$index]];

        foreach ($reordered as $position => $photo) {
            $photo->update(['sort_order' => $position + 1]);
        }

        unset($this->item);
        $this->syncPhotoDetails();
    }

    /**
     * Remove one of the photos picked but not saved yet.
     */
    public function removeUpload(int $index): void
    {
        unset($this->uploads[$index]);

        $this->uploads = array_values($this->uploads);
    }

    /**
     * Load the labels and captions of the attached photos into the form.
     */
    private function syncPhotoDetails(): void
    {
        $this->photoDetails = ($this->item?->photos ?? collect())
            ->mapWithKeys(fn (PortfolioPhoto $photo): array => [
                $photo->id => ['label' => $photo->label, 'caption' => $photo->caption],
            ])
            ->all();
    }

    /**
     * Render the component.
     */
    public function render(): View
    {
        return view('livewire.admin.portfolio.edit')
            ->title($this->itemId === null ? __('New case') : __('Edit case'));
    }
}
