<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Project extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
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
