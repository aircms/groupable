<?php

namespace aircms\groupable\Models;

use Illuminate\Database\Eloquent\Model;

class GroupItems extends Model
{
    public function scopeGroup($query, $groupID)
    {
        $query->where('group_id', $groupID);
    }

    public function scopeType($query, $type)
    {
        $query->where('groupable_type', $type);
    }

    public function scopeItem($query, $itemID)
    {
        $query->where('groupable_id', $itemID);
    }
}
