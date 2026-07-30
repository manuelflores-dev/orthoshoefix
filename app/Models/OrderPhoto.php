<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;

#[Fillable(['path', 'original_name', 'size'])]
class OrderPhoto extends Model
{
    /**
     * The disk the order photos are stored on.
     */
    public const DISK = 'public';

    /**
     * Register the model events.
     */
    protected static function booted(): void
    {
        static::deleted(function (self $photo): void {
            Storage::disk(self::DISK)->delete($photo->path);
        });
    }

    /**
     * Get the order the photo belongs to.
     *
     * @return BelongsTo<Order, $this>
     */
    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    /**
     * Get the publicly accessible URL of the photo.
     *
     * Built from the current request instead of the disk's configured URL, which
     * hangs off APP_URL: a stale APP_URL would serve images over http and the
     * browser blocks them as mixed content on an https page.
     */
    public function url(): string
    {
        return asset('storage/'.$this->path);
    }
}
