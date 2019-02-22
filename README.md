# aircms/groupable

```php
class PendingGroupModel extends Model{
    use \aircms\groupable\Groupable;

    protected $groupDataField ='group'; // get data from this field
    protected $groupTableField = 'group_id'; // set group data to this table field
}
```
