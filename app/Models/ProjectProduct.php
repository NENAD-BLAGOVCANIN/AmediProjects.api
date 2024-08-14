<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectProduct extends Model
{
    use HasFactory;

    protected $fillable = [
        'project_id',
        'product_name',
        'price',
    ];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }
}
