<?php

namespace aircms\groupable\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;

class GroupItems extends Model
{
    public function scopeWithGroup($query, $groupID)
    {
        $query->where('group_id', $groupID);
    }

    public function scopeWithType($query, $type)
    {
        $query->where('groupable_type', $type);
    }

    public function scopeWithItem($query, $itemID)
    {
        $query->where('groupable_id', $itemID);
    }

    public function group()
    {
        return $this->belongsTo(Group::class);
    }

    public function getGroupAlias()
    {
        return $this->group->alias;
    }

    public function groupableItem()
    {
        $groupableModel = Relation::getMorphedModel($this->groupable_type);
        return $this->belongsTo($groupableModel, 'groupable_id');
    }

}
