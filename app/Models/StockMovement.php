<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StockMovement extends Model
{
    // Menonaktifkan incrementing karena menggunakan ULID sebagai primary key
    public $incrementing = false;
    protected $keyType = 'string';

    // Menentukan nama primary key
    protected $primaryKey = 'ulid';

    // Jika Anda tidak menggunakan kolom timestamps (created_at, updated_at)
    public $timestamps = false; 
    // Jika Anda ingin menggunakan timestamps, hapus baris di atas.

    protected $fillable = [
        'ulid',
        'product_id',
        'movement_type',
        'transaction_id',
        'qty',
        'before_qty',
        'after_qty',
        'movement_date',
        'remarks',
    ];

    protected $casts = [
        'movement_type' => StockMovementType::class, // Asumsi Anda menggunakan Enum
        'movement_date' => 'datetime',
    ];

    /**
     * Relasi ke Product
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'product_id', 'ulid');
    }

    // Catatan: Anda mungkin ingin menggunakan Trait untuk ULID di sini.
    // Misalnya: use App\Traits\GeneratesUlid;
    // use GeneratesUlid;
}
