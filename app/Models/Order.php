<?php

namespace App\Models;

use App\Jobs\OrderCompletedJob;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Collection;

/**
 * Class Order
 * @property int $id
 * @property int $status
 * @property string $client_email
 * @property int $partner_id
 * @property Partner $partner
 * @property Carbon $delivery_dt
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property Product[]|Collection $products
 */
class Order extends Model
{
    const STATUS_NEW = 0;
    const STATUS_CONFIRMED = 10;
    const STATUS_COMPLETED = 20;

    protected $fillable = [
        'client_email', 'partner_id', 'status'
    ];

    /**
     * @return array
     */
    public static function statuses(): array
    {
        return [
            self::STATUS_NEW => 'New',
            self::STATUS_CONFIRMED => 'Confirmed',
            self::STATUS_COMPLETED => 'Completed',
        ];
    }

    protected static function boot()
    {
        parent::boot();

        static::updated(static function (Order $order) {
            if ($order->status == self::STATUS_COMPLETED) {
                OrderCompletedJob::dispatch($order->id);
            }
        });
    }

    /**
     * @return HasOne
     */
    public function partner(): HasOne
    {
        return $this->hasOne(Partner::class, 'id', 'partner_id');
    }

    /**
     * @return HasMany
     */
    public function products(): HasMany
    {
        return $this->hasMany(OrderProduct::class, 'order_id', 'id');
    }

    /**
     * @return BelongsToMany
     */
    public function originalProducts(): BelongsToMany
    {
        return $this->belongsToMany(Product::class, 'order_products');
    }

    /**
     * @return mixed
     */
    public function getStatusNameAttribute()
    {
        return self::statuses()[$this->status] ?? '?';
    }

    /**
     * @return int
     */
    public function getCost(): int
    {
        return $this->products->sum(function (OrderProduct $orderProduct) {
            return $orderProduct->price * $orderProduct->quantity;
        });
    }
}