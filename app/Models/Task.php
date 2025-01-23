<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $table = 'tasks';

    use HasFactory;

    protected $fillable = [
        'title', 'description', 'start_date', 'due_date', 'priority', 'user_id', 'status',
    ];

    public function getDaysRemainingAttribute()
    {
        if (!$this->due_date) {
            return null;
        }

        $diffInMinutes = now()->diffInMinutes($this->due_date, false);

        if ($diffInMinutes < 0) {
            return "Deadline has passed";
        }

        $days = floor($diffInMinutes / (60 * 24));
        $hours = floor(($diffInMinutes % (60 * 24)) / 60);
        $minutes = $diffInMinutes % 60;

        if ($days > 0) {
            return "{$days} days, {$hours} hours, and {$minutes} minutes remaining";
        }

        if ($hours > 0) {
            return "{$hours} hours and {$minutes} minutes remaining";
        }

        return "{$minutes} minutes remaining";
    }
    

    public function user()
    {
        return $this->belongsTo(User::class);
        
    }

    public function scopeSearch($query, $search)
    {
        if ($search) {
            return $query->where('title', 'like', '%' . $search . '%');
        }
        return $query;
    }
    
}
