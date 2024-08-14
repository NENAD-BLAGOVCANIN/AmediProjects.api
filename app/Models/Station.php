<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Station extends Model
{
    use HasFactory;
    protected $fillable = [
        'project_id', 
        'station_id', 
        'entry_time', 
        'due_date',
        // Add other attributes here if needed
    ];
    public function projects()
    {
        return $this->belongsToMany(Project::class, 'project_station')
                    ->withPivot('entry_time', 'due_date')
                    ->withTimestamps();
    }
}
