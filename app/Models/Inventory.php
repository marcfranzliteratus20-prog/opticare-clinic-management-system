<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Inventory extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'product_name',
        'sku',
        'category',
        'quantity',
        'unit',
        'reorder_level', // FIX: was missing -- low stock threshold couldn't be saved
        'expiry_date',
        'price',
        'supplier',
        'image',
    ];

    protected $casts = [
        'expiry_date' => 'date',
    ];

    public function logs()
    {
        return $this->hasMany(InventoryLog::class)->latest();
    }
}