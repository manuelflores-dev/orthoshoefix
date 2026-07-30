<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;

#[Fillable(['path', 'label', 'caption', 'sort_order'])]
class PortfolioPhoto extends Model
{
    /**
     * The disk uploaded portfolio photos live on.
     */
    public const DISK = 'public';

    /**
     * Register the model events.
     */
    protected static function booted(): void
    {
        static::deleted(function (self $photo): void {
            // Photos shipped with the site under public/ are not ours to delete.
            if (! $photo->isStaticAsset()) {
                Storage::disk(self::DISK)->delete($photo->path);
            }
        });
    }

    /**
     * Get the case the photo belongs to.
     *
     * @return BelongsTo<PortfolioItem, $this>
     */
    public function item(): BelongsTo
    {
        return $this->belongsTo(PortfolioItem::class, 'portfolio_item_id');
    }

    /**
     * Determine whether the photo is a file shipped under public/.
     */
    public function isStaticAsset(): bool
    {
        return str_starts_with($this->path, 'images/');
    }

    /**
     * Get the URL used to display the photo.
     */
    public function url(): string
    {
        return $this->isStaticAsset()
            ? asset($this->path)
            : Storage::disk(self::DISK)->url($this->path);
    }
}
