<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Task;

class Production extends Model
{
    use HasFactory;
   
    protected $fillable = ['company', 'project_id', 'site_city', 'item', 'status', 'performed_by', 'notes', 'is_archive', 'plan_id', 'due_date', 'urgency'];

    public function items()
    {
        return $this->hasMany(ProductionItem::class);
    }
    public function tasks()
    {
        return $this->morphMany(Task::class, 'taskable');
    }

    protected $attributes = [
        'status' => 'new',
    ];

    public function setStatusAttribute($value)
    {
        $allowedValues = ['new','planning', 'measuring', 'finished'];
        if (!in_array($value, $allowedValues)) {
            throw new \InvalidArgumentException("Invalid status value");
        }

        $this->attributes['status'] = $value;
    }

    public function project()
    {
        return $this->belongsTo(Project::class);
    }
}
