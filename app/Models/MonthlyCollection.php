<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MonthlyCollection extends Model
{
    use HasFactory;
    
    public $timestamps = false;
    protected $fillable = ['project_id', 'month', 'year', 'amount_collected'];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }
}
