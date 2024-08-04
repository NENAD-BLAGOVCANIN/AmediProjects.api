<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SummaryPlanner extends Model
{
    use HasFactory;

    protected $fillable = [
        'project_name',
        'date',
        'worker_name',
        'bonuses',
    ];

    protected $casts = [
        'bonuses' => 'array',
    ];
}
