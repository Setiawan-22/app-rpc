<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUlids;


class Product extends Model
{
    use HasUlids;

    protected $fillable = [
        'product_id', 'kode_barang', 'nama_barang', 'deskripsi',
        'uoms', 'price', 'vendor_id',
    ];

    public function vendor()
    {
        return $this->belongsTo(Vendor::class);
    }

    public function stock()
    {
        return $this->hasOne(InventoryStock::class, 'product_id', 'ulid');
    }

    public function movements()
    {
        return $this->hasMany(StockMovement::class, 'product_id', 'ulid');
    }
}

