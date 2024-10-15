<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PriceOffers extends Model
{
    use HasFactory;
    protected $fillable = ['user_id', 'status', 'company', 'projectName' , 'clientName' , 'phone' ];

}
