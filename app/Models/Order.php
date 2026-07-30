<?php

namespace App\Models;

use App\Enums\OrderStatus;
use App\Enums\ServiceType;
use App\Enums\ShoeType;
use App\Notifications\OrderReadyForPickup;
use App\Policies\OrderPolicy;
use Database\Factories\OrderFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Attributes\UsePolicy;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable([
    'user_id',
    'created_by',
    'service_type',
    'shoe_type',
    'description',
    'status',
    'estimated_price',
    'contact_name',
    'contact_phone',
    'contact_email',
    'received_at',
    'estimated_delivery_at',
    'internal_notes',
])]
#[UsePolicy(OrderPolicy::class)]
class Order extends Model
{
    /** @use HasFactory<OrderFactory> */
    use HasFactory;

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'service_type' => ServiceType::class,
            'shoe_type' => ShoeType::class,
            'status' => OrderStatus::class,
            'estimated_price' => 'decimal:2',
            'received_at' => 'date',
            'estimated_delivery_at' => 'date',
            'ready_at' => 'datetime',
            'delivered_at' => 'datetime',
        ];
    }

    /**
     * Register the model events.
     */
    protected static function booted(): void
    {
        static::creating(function (self $order): void {
            $order->order_number ??= self::nextOrderNumber();
            $order->status ??= OrderStatus::Received;
            $order->received_at ??= now()->startOfDay();
        });

        static::created(function (self $order): void {
            $order->statusEvents()->create([
                'to_status' => $order->status,
                'changed_by' => $order->created_by,
                'note' => __('Order intake registered.'),
            ]);
        });
    }

    /**
     * Get the customer the shoes belong to.
     *
     * @return BelongsTo<User, $this>
     */
    public function client(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Get the staff member that registered the order, if any.
     *
     * @return BelongsTo<User, $this>
     */
    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Get the photos attached to the order.
     *
     * @return HasMany<OrderPhoto, $this>
     */
    public function photos(): HasMany
    {
        return $this->hasMany(OrderPhoto::class);
    }

    /**
     * Get the status changes recorded for the order.
     *
     * @return HasMany<OrderStatusEvent, $this>
     */
    public function statusEvents(): HasMany
    {
        return $this->hasMany(OrderStatusEvent::class)->orderBy('created_at')->orderBy('id');
    }

    /**
     * Move the order to the given status, recording the change.
     */
    public function markAs(OrderStatus $status, ?User $actor = null, ?string $note = null): void
    {
        $previous = $this->status;

        if ($previous === $status && blank($note)) {
            return;
        }

        $this->status = $status;

        if ($status === OrderStatus::Ready) {
            $this->ready_at ??= now();
        }

        if ($status === OrderStatus::Delivered) {
            $this->ready_at ??= now();
            $this->delivered_at ??= now();
        }

        $this->save();

        $this->statusEvents()->create([
            'from_status' => $previous,
            'to_status' => $status,
            'changed_by' => $actor?->id,
            'note' => $note,
        ]);

        if ($status === OrderStatus::Ready && $previous !== OrderStatus::Ready) {
            $this->client->notify(new OrderReadyForPickup($this));
        }
    }

    /**
     * Determine whether the order is waiting to be picked up.
     */
    public function isReadyForPickup(): bool
    {
        return $this->status === OrderStatus::Ready;
    }

    /**
     * Get the completion percentage used by the customer facing tracker.
     */
    public function progress(): int
    {
        if ($this->status === OrderStatus::Cancelled) {
            return 0;
        }

        return (int) round($this->status->step() / count(OrderStatus::pipeline()) * 100);
    }

    /**
     * Determine whether the estimated delivery date has already passed.
     */
    public function isOverdue(): bool
    {
        return $this->status->isOpen()
            && $this->estimated_delivery_at !== null
            && $this->estimated_delivery_at->isPast();
    }

    /**
     * Generate the next sequential order number of the year.
     */
    public static function nextOrderNumber(): string
    {
        $prefix = 'OSF-'.now()->format('y');

        $sequence = self::query()
            ->where('order_number', 'like', $prefix.'-%')
            ->count() + 1;

        do {
            $number = $prefix.'-'.str_pad((string) $sequence, 4, '0', STR_PAD_LEFT);
            $sequence++;
        } while (self::query()->where('order_number', $number)->exists());

        return $number;
    }

    /**
     * Scope the query to orders the shop still owes work on.
     *
     * @param  Builder<$this>  $query
     */
    #[Scope]
    protected function open(Builder $query): void
    {
        $query->whereIn('status', OrderStatus::openValues());
    }

    /**
     * Scope the query to orders waiting to be picked up.
     *
     * @param  Builder<$this>  $query
     */
    #[Scope]
    protected function readyForPickup(Builder $query): void
    {
        $query->where('status', OrderStatus::Ready);
    }

    /**
     * Scope the query to the orders of a single customer.
     *
     * @param  Builder<$this>  $query
     */
    #[Scope]
    protected function forClient(Builder $query, User|int $client): void
    {
        $query->where('user_id', $client instanceof User ? $client->id : $client);
    }

    /**
     * Scope the query by order number, description or customer details.
     *
     * @param  Builder<$this>  $query
     */
    #[Scope]
    protected function search(Builder $query, ?string $term): void
    {
        $term = trim((string) $term);

        if ($term === '') {
            return;
        }

        $query->where(function (Builder $query) use ($term): void {
            $query->where('order_number', 'like', "%{$term}%")
                ->orWhere('description', 'like', "%{$term}%")
                ->orWhere('contact_name', 'like', "%{$term}%")
                ->orWhere('contact_phone', 'like', "%{$term}%")
                ->orWhereHas('client', function (Builder $query) use ($term): void {
                    $query->where('name', 'like', "%{$term}%")
                        ->orWhere('email', 'like', "%{$term}%")
                        ->orWhere('phone', 'like', "%{$term}%");
                });
        });
    }
}
