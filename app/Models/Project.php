<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Project extends Model
{
    use HasFactory;

    const STATUS_SETTING_UP = 'setting up';
    const STATUS_MEASUREMENT = 'measurement';
    const STATUS_WRITING_A_PROGRAM = 'writing a program';
    const STATUS_PRODUCTION = 'production';
    const STATUS_GALVANIZATION = 'galvanization';
    const STATUS_INSTALLATION = 'installation';
    const STATUS_REJECTS = 'rejects';
    const STATUS_DELIVERY = 'delivery';
    const STATUS_COLLECTION = 'collection';

    protected $fillable = [
        'name',
        'description',
        'status'
    ];

    public function users()
    {
        return $this->belongsToMany(User::class, 'project_users');
    }

    protected static function booted()
    {
        static::creating(function ($project) {
            $project->invite_code = Str::random(8);
        });
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }
    
}
