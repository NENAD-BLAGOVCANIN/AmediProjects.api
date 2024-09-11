<?php
// ProductionItem.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductionItem extends Model
{
    use HasFactory;

    protected $fillable = ['production_id', 'type', 'quantity'];

    public function production()
    {
        return $this->belongsTo(Production::class);
    }
}
