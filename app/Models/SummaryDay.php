<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SummaryDay extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'title', 'body', 'collected_today', 'future_collection', 'problems', 'is_archive'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}