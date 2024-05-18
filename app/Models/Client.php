<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;

    protected $fillable = [
        'contact_id',
    ];


    public function contact()
    {
        return $this->hasOne('App\Models\Contact', 'id', 'contact_id');
    }

}
