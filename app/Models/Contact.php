<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'title',
        'city',
        'address',
        'description',
        'lead_source',
        'past_client',
        'phone',
        'organization',
    ];

}
