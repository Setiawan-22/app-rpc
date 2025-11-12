<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class IncomingGoodItem extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'incoming_good_id',
        'product_id',
        'received_qty',
        'price_per_unit',
    ];

    public function incomingGood(): BelongsTo
    {
        return $this->belongsTo(IncomingGood::class, 'incoming_good_id', 'ulid');
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'product_id', 'ulid');
    }
}
