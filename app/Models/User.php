<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use PHPOpenSourceSaver\JWTAuth\Contracts\JWTSubject;
use App\Models\Role;

class User extends Authenticatable implements JWTSubject
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
    ];


    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }

    public function projects()
    {
        return $this->belongsToMany(Project::class, 'project_users');
    }

    public function project()
    {
        return $this->hasOne('App\Models\Project', 'id', 'currently_selected_project_id');
    }

    protected static function booted()
    {
        static::created(function ($user) {
            $project = new Project();
            $project->name = $user->name . "'s Project";
            $project->save();

            $user->currently_selected_project_id = $project->id;
            $user->save();
            $user->projects()->attach($project);

            $userRole = Role::where('name', 'user')->first();

            $user->role_id = $userRole->id;
            $user->save();
        });
    }

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

}