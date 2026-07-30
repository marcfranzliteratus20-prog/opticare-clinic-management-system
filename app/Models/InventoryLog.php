<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InventoryLog extends Model
{
    protected $fillable = [
        'inventory_id',
        'change',
        'previous_quantity',
        'new_quantity',
        'reason',
        'user_name',
    ];

    public function inventory()
    {
        return $this->belongsTo(Inventory::class);
    }
}