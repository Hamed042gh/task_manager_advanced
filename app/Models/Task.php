<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $table = 'tasks';

    use HasFactory;

    protected $fillable = [
        'title', 'description', 'start_date', 'due_date', 'priority', 'user_id', 'status',
    ];

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
