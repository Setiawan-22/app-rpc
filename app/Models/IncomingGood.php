<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Relations\HasMany;

class IncomingGood extends Model
{
    public $incrementing = false;
    protected $keyType = 'string';
    protected $primaryKey = 'ulid';

    protected $fillable = [
        'ulid',
        'reference_no',
        'vendor_id',
        'receipt_date',
        'payment_type',
        'due_date',
        'notes',
    ];

    protected $casts = [
        'receipt_date' => 'datetime',
        'due_date' => 'date',
    ];

    protected static function boot() 
    {
        parent::boot();

        static::creating(function ($model) {
            
            // --- Cek Properti ULID (Biasanya yang menyebabkan error jika model null) ---
            // Baris ini harus aman jika $model adalah instance
            $model->ulid = $model->ulid ?? Str::ulid();
            
            // --- Cek GRN Numbering ---
            if (empty($model->reference_no)) {
                // Pastikan fungsi generateNextGrnNumber TIDAK mencoba mengakses 
                // $latestGrn->something sebelum dicek apakah $latestGrn itu null.
                $model->reference_no = self::generateNextGrnNumber($model->receipt_date);
            }
        });
    }

    public static function generateNextGrnNumber($date)
    {
        // Ambil komponen tanggal
        $time = strtotime($date);
        $year = date('y', $time); // Tahun 2 digit
        $month = date('m', $time); // Bulan 2 digit
        $prefix = "GRN/{$year}{$month}/";
        
        // Cari GRN terakhir di bulan/tahun ini
        $latestGrn = self::where('reference_no', 'like', "{$prefix}%")
                            ->orderBy('reference_no', 'desc')
                            ->first();

        $counter = 1;
        
        if ($latestGrn) {
            // Ekstrak nomor urut dari GRN terakhir
            $lastCounter = (int) substr($latestGrn->reference_no, -4);
            $counter = $lastCounter + 1;
        }

        // Format nomor urut menjadi 4 digit (0001)
        $formattedCounter = str_pad($counter, 4, '0', STR_PAD_LEFT);

        return $prefix . $formattedCounter;
    }

    public function vendor(): BelongsTo
    {
        return $this->belongsTo(Vendor::class, 'vendor_id', 'ulid');
    }

    public function items(): HasMany
    {
        return $this->hasMany(IncomingGoodItem::class, 'incoming_good_id', 'ulid');
    }
}
