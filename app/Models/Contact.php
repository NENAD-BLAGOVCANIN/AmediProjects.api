<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Task;

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
        'status',
        'lead_source',
        'past_client',
        'phone',
        'organization',
    ];
    public function tasks()
    {
        return $this->morphMany(Task::class, 'taskable');
    }
}
