<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $fillable = ['name', 'status'];

    // Many-to-Many relationship with User
    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    // One-to-Many relationship with Timesheet
    public function timesheets()
    {
        return $this->hasMany(Timesheet::class);
    }

    // One-to-Many relationship with AttributeValue
    public function attributeValues()
    {
        return $this->hasMany(AttributeValue::class, 'entity_id');
    }
}
