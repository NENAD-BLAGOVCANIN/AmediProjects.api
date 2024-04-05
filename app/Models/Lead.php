<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lead extends Model
{
    use HasFactory;

    protected $fillable = [
        'contact_id',
        'description',
        'lead_source',
    ];


    public function contact()
    {
        return $this->hasOne('App\Models\Contact', 'id', 'contact_id');
    }

}
