<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Vendor extends Model
{
    // Menonaktifkan incrementing karena menggunakan ULID sebagai primary key
    public $incrementing = false;
    protected $keyType = 'string';

    // Menentukan nama primary key
    protected $primaryKey = 'ulid';

    // Menggunakan timestamps standar Laravel
    
    protected $fillable = [
        'ulid',
        'vendor_code',
        'vendor_name',
        'address',
        'contact_person',
        'phone',
        'email',
    ];


    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            // Hasilkan ULID jika belum disetel
            $model->ulid = $model->ulid ?? Str::ulid();
        });
    }
    /**
     * Relasi ke Products (satu vendor bisa mensuplai banyak produk)
     */
    public function products(): HasMany
    {
        return $this->hasMany(Product::class, 'vendor_id', 'ulid');
    }
}
