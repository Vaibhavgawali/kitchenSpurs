<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'description', 'due_date', 'status'];

    protected $dates = ['due_date'];

    protected $casts = [
        'due_date' => 'date:Y-m-d',
    ];

    public function users()
    {
        return $this->belongsToMany(User::class, 'task_user')->withTimestamps();
    }
}
