<?php

namespace aircms\groupable\Models;

use Collect;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;

class Group extends Model
{
    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('groupSort', function ($query) {
            return $query->orderBy('order', 'asc');
        });
    }

    public function items()
    {
        $items = GroupItems::group($this->id);
        if ($items->count() == 0) {
            return Collection::make([]);
        }

        $type = Arr::get($items->first(), "groupable_type");
        $className = Relation::$morphMap[$type];

        return $this->hasManyThrough($className, GroupItems::class, 'group_id', 'id', 'id', 'groupable_id');
    }

    // todo: relations
    public function scopeType($query, $type)
    {
        $query->where('groupable_type', $type);
    }

    public function scopeAlias($query, $alias)
    {
        $query->where('alias', $alias);
    }

    public function idMap()
    {
        return $this->mapBy('id');

    }

    public function aliasMap()
    {
        return $this->mapBy('alias');
    }

    private function mapBy($field)
    {
        return $this->all()
            ->each(function ($item) use ($field) {
                return [$item->{$field} => $item->name];
            })->flatMap(function ($item) {
                return $item;
            })->all();
    }
}
