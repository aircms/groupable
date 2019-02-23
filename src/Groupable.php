<?php

namespace aircms\groupable;

use aircms\groupable\Models\Group;
use aircms\groupable\Models\GroupItems;

trait Groupable
{
    public function group()
    {
        $groupItem = GroupItems::withitem($this->id)
            ->withType($this->getTable())
            ->first();

        if (!$groupItem) {
            return null;
        }

        return $groupItem->lingGroup;
    }

    public function groupItems()
    {
        return GroupItems::with('group')
            ->withType($this->getTable())
            ->get();
    }

    public function linkGroupAlias($groupAlias): bool
    {
        $groupModel = Group::alias($groupAlias)->first();
        if (!$groupModel) {
            InvalidException::GroupNotExist();
        }

        return $this->linkGroup($groupModel);
    }

    public function linkGroupID($groupID): bool
    {
        $groupModel = Group::find($groupID);
        if (!$groupModel) {
            InvalidException::GroupNotExist();
        }

        return $this->linkGroup($groupModel);
    }

    public function linkGroup(Group $groupModel)
    {
        $groupItemModel = GroupItems::withGroup($groupModel->id)
            ->withItem($this->id)
            ->withType($this->getTable())
            ->count();
        if ($groupItemModel > 0) {
            return true;
        }

        $model = new GroupItems();
        $model->group_id = $groupModel->id;
        $model->groupable_id = $this->id;
        $model->groupable_type = $this->getTable();

        return $model->save();
    }
}
