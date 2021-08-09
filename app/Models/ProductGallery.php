<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductGallery extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'products_id',
        'url',

    ];

    // Mutasi agar urlnya Full (https://ilham.com/namagambar.jpg)
    public function getUrlAttribute($url)
    {
        return config('app.url') . Storage::url($url);
    }
}
