<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AttributeValue extends Model
{
    protected $fillable = ['attribute_id', 'entity_id', 'value'];

    // Belongs to Attribute
    public function attribute()
    {
        return $this->belongsTo(Attribute::class);
    }

    // Belongs to Project (entity)
    public function project()
    {
        return $this->belongsTo(Project::class, 'entity_id');
    }
}
