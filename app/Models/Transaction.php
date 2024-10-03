<?php

namespace App\Models;

use App\Casts\MoneyCast;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Transaction extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'name',
        'trx_id',
        'phone_number',
        'proof',
        'addres',
        'started_at',
        'duration',
        'ended_at',
        'is_paid',
        'delivery_type',
        'total_amount',
        'product_id',
        'store_id',
    ];

    protected $casts = [
        'total_amount' => MoneyCast::class,
        'started_at' => 'date',
        'ended_at' => 'date',
    ];

    public static function generateUniqueTrxId(){
        $prefix = 'SWBR';
        do {
            $randomString = $prefix . mt_rand(1000, 9999);
        } while (self::where('trx_id', $randomString)->exists());

        return $randomString;
    }

    public function Product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function Store(): BelongsTo
    {
        return $this->belongsTo(Store::class);
    }
}