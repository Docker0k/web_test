<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class UsersGeo
 * @package App\Models
 *
 * @property int $id
 * @property int $user_id
 * @property string name
 * @property integer $view_count
 * @property int $parent_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @method static \Illuminate\Database\Eloquent\Builder|UsersGeo whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UsersGeo whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UsersGeo whereParentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UsersGeo whereName($value)
 */
class UsersGeo extends Model
{
    public $table = 'users_geo';
    public static $parentId = 0;
    public static $fullArray = [];

    public static function saveItem($arr, $userId)
    {
        foreach ($arr as $item) {

            if (!isset($item->name)){
                break;
            }
            $geo = UsersGeo::whereUserId($userId)->whereParentId(static::$parentId)->whereName($item->name)->first();
            if(isset($geo)){
                continue;
            }
            $geo = new UsersGeo();
            $geo->name = $item->name;
            $geo->view_count = $item->view_count;
            $geo->parent_id = static::$parentId;
            $geo->user_id = $userId;
            $id = $geo->save();
            if (isset($item->states) || isset($item->cities)){
                static::$parentId = $id;
                $newArr = (isset($item->states))? $item->states : $item->cities;
                static::saveItem($newArr, $userId);
            }
        }
        return true;
    }
}
