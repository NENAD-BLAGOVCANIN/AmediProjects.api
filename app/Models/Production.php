<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Task;

class Production extends Model
{
    use HasFactory;

    protected $fillable = [
        'company', 'site_city', 'item', 'status', 'performed_by', 'notes',
    ];
    public function tasks()
    {
        return $this->morphMany(Task::class, 'taskable');
    }
    protected $attributes = [
        'status' => 'measuring',
    ];
    public function setStatusAttribute($value)
    {
        $allowedValues = ['planning', 'measuring', 'finished'];
        if (!in_array($value, $allowedValues)) {
            throw new \InvalidArgumentException("Invalid status value");
        }

        $this->attributes['status'] = $value;
    }
}
