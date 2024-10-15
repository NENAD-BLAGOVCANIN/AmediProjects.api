<?php
// ProductionItem.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductionItem extends Model
{
    use HasFactory;

    protected $fillable = ['production_id', 'name','type', 'price', 'performed_by', 'quantity','project_id', 'city', 'site_city' , 'note' , 'fileUpload'];

    public function production()
    {
        return $this->belongsTo(Production::class);
    }
    
}
