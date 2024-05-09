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
        'due_date' => 'date:Y-m-d', // Format due_date as 'Y-m-d'
    ];
}
