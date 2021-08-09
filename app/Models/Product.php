<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        // Hanya name, karena pada table ini name saja yang input manual (tidak otomatis)
        'name',
        'price',
        'description',
        'tags',
        'categories_id',
    ];

    //Untuk Relasi Table (data product dan gallery)
    public function galleries()
    {
        // hasMany (Untuk definisi one-to-many)
        // Transaction::class, 'field relasi (FK)', 'id yang dimiliki (local id)'
        return $this->hasMany(ProductGallery::class, 'products_id', 'id');
    }

    //Untuk Relasi Table
    public function category()
    {
        // belongsTo (Untuk kebalikan relasi yang tadi)
        return $this->belongsTo(ProductGallery::class, 'categories_id', 'id');
    }


}
