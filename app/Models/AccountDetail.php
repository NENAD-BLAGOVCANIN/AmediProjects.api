<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AccountDetail extends Model
{
    protected $fillable = [
        'account_id',
        'project_id',
        'product_name',
        'unit_of_measure',
        'quantity',
        'unit_price',
        'total',
    ];

    public function account()
    {
        return $this->belongsTo(Account::class);
    }
    public function project()
    {
        return $this->belongsTo(Project::class);
    }
}
