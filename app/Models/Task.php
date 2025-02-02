<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'status',
        'project_id'
    ];

    public function project()
    {
        return $this->belongsTo(Project::class);//una tarea pertenece a un solo proyecto
    }
}
