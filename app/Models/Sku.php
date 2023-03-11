<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sku extends Model
{
    use HasFactory;

    protected $fillable = [
        'is_default',
        'image',
        'price',
        'compare_at_price',
        'quantity',
        'sku',
        'barcode',
        'weight',
    ];

    protected $casts = [
        'is_default' => 'boolean',
    ];

    public function product(){
        return $this->belongsTo(Product::class);
    }

    public function sku_values(){
        return $this->hasMany(SkuValue::class);
    }
}
