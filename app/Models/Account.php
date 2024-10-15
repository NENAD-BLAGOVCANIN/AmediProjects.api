<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    protected $fillable = [
        'client_name',
        'project_name',
        'company',
        'city',
        'phone',
        'email',
        'created_by',
        'project_id',
    ];

    public function accountDetails()
    {
        return $this->hasMany(AccountDetail::class);
    }
}
