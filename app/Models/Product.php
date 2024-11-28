<?php

namespace App\Models;

use App\Casts\MoneyCast;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Storage;

class Product extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'name',
        'slug',
        'thumbnail',
        'about',
        'price',
        'category_id',
        'brand_id',
    ];

    protected $casts = [
        'price' => MoneyCast::class,
    ];

    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($product) {
            foreach ($product->photos as $photo) {
                Storage::delete($photo->photo);
                $photo->delete();
            }
        });

        static::updating(function ($product) {
            foreach ($product->photos as $photo) {
                Storage::delete($photo->photo);
                $photo->delete();
            }
        });
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function Brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class);
    }

    public function Photos(): HasMany
    {
        return $this->hasMany(ProductPhoto::class);
    }

    public function setNameAttribute($value)
    {
        $this->attributes['name'] = $value;
        $this->attributes['slug'] = Str::slug($value);
    }
}
