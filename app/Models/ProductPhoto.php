<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

class ProductPhoto extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'photo',
        'product_id',
    ];

    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($productPhoto) {
            if ($productPhoto->photo) {
                Storage::delete($productPhoto->photo);
            }
        });

        static::updating(function ($productPhoto) {
            if ($productPhoto->isDirty('photo')) {
                Storage::delete($productPhoto->getOriginal('photo'));
            }
        });
    }
}
