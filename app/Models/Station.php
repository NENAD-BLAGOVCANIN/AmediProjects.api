<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Station extends Model
{
    use HasFactory;

    public function projects()
    {
        return $this->belongsToMany(Project::class, 'project_station')
                    ->withPivot('entry_time', 'due_date')
                    ->withTimestamps();
    }
}
