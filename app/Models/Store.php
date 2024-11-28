<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Storage;

class Store extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'name',
        'slug',
        'thumbnail',
        'addres',
        'is_open',
    ];


    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($store) {
            if ($store->thumbnail) {
                Storage::delete($store->thumbnail);
            }
        });

        static::updating(function ($store) {
            if ($store->isDirty('thumbnail')) {
                $oldThumbnail = $store->getOriginal('thumbnail');
                if ($oldThumbnail) {
                    Storage::delete($oldThumbnail);
                }
            }
        });
    }
    public function setNameAttribute($value)
    {
        $this->attributes['name'] = $value;
        $this->attributes['slug'] = Str::slug($value);
    }
}
