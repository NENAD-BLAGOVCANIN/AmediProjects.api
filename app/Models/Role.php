<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    const CEO = 'CEO';
    const PROJECT_MANAGER = 'project_manager';
    const SALES_MANAGER = 'sales_manager';
    const PRODUCTION_MANAGER = 'production_manager';
    const IT_MANAGER = 'it_manager';
    const SYSTEM_INSTALLER = 'system_installer';
    const CLIENT = 'client';
    const USER = 'user';
 
    public function users()
    {
        return $this->hasMany(User::class);
    }

}
