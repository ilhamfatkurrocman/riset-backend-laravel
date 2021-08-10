<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductCategory extends Model
{
    //Memanggil SoftDeletes karena pada table ini menggunakan delete_at
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        // Hanya name, karena pada table ini name saja yang input manual (tidak otomatis)
        'name',
    ];

    //Untuk Relasi Table
    public function products()
    {
        // hasMany (Untuk definisi one-to-many)
        // Transaction::class, 'field relasi (FK)', 'id yang dimiliki (local id)'
        return $this->hasMany(Product::class, 'categories_id', 'id'); // Menyambungkan table user dan transaction
    }

}
