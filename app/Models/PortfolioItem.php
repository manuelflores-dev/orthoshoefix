<?php

namespace App\Models;

use App\Enums\PortfolioLayout;
use Database\Factories\PortfolioItemFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable(['title', 'summary', 'layout', 'badge', 'tags', 'is_published', 'sort_order', 'created_by'])]
class PortfolioItem extends Model
{
    /** @use HasFactory<PortfolioItemFactory> */
    use HasFactory;

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'layout' => PortfolioLayout::class,
            'tags' => 'array',
            'is_published' => 'boolean',
        ];
    }

    /**
     * Get the photos of the case, in display order.
     *
     * @return HasMany<PortfolioPhoto, $this>
     */
    public function photos(): HasMany
    {
        return $this->hasMany(PortfolioPhoto::class)->orderBy('sort_order')->orderBy('id');
    }

    /**
     * Get the staff member that published the case.
     *
     * @return BelongsTo<User, $this>
     */
    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Determine whether the case can be shown on the website.
     */
    public function isShowable(): bool
    {
        return $this->is_published && $this->photos->isNotEmpty();
    }

    /**
     * Scope the query to the cases visible on the website.
     *
     * @param  Builder<$this>  $query
     */
    #[Scope]
    protected function published(Builder $query): void
    {
        $query->where('is_published', true)->has('photos');
    }

    /**
     * Scope the query to the display order used on the website.
     *
     * @param  Builder<$this>  $query
     */
    #[Scope]
    protected function ordered(Builder $query): void
    {
        $query->orderBy('sort_order')->orderBy('id');
    }
}
