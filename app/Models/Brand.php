<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Storage;

class Brand extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'name',
        'slug',
        'logo',
    ];

    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($brand) {
            if ($brand->logo) {
                Storage::delete($brand->logo);
            }
        });

        static::updating(function ($brand) {
            if ($brand->isDirty('logo')) {
                $oldLogo = $brand->getOriginal('logo');
                if ($oldLogo) {
                    Storage::delete($oldLogo);
                }
            }
        });
    }

    public function BrandCategories(): HasMany
    {
        return $this->hasMany(BrandCategory::class, 'brand_id');
    }

    public function Products(): HasMany
    {
        return $this->hasMany(Product::class);
    }

    
    public function setNameAttribute($value)
    {
        $this->attributes['name'] = $value;
        $this->attributes['slug'] = Str::slug($value);
    }
}
