<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OptionValue extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
    ];

    public function option(){
        return $this->belongsTo(Option::class);
    }

    public function sku_values(){
        return $this->hasMany(SkuValue::class);
    }
}
