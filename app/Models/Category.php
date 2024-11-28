<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Storage;

class Category extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'name',
        'icon',
    ];

    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($category) {
            if ($category->icon) {
                Storage::delete($category->icon);
            }
        });

        static::updating(function ($category) {
            if ($category->isDirty('icon')) {
                $oldIcon = $category->getOriginal('icon');
                if ($oldIcon) {
                    Storage::delete($oldIcon);
                }
            }
        });
    }

    public function BrandCategories (): HasMany
    {
        return $this->hasMany(BrandCategory::class, 'category_id');
    }

    public function Products (): HasMany
    {
        return $this->hasMany(Product::class);
    }
    
    public function setNameAttribute($value)
    {
        $this->attributes['name'] = $value;
        $this->attributes['slug'] = Str::slug($value);
    }
}
