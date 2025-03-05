<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Timesheet extends Model
{
    protected $fillable = ['task_name', 'date', 'hours', 'user_id', 'project_id'];

    // Belongs to User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Belongs to Project
    public function project()
    {
        return $this->belongsTo(Project::class);
    }
}
