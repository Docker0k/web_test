<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

/**
 * Class Subscription
 * @package App\Models
 *
 * @property int $id
 * @property string $name
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @method static \Illuminate\Database\Eloquent\Builder|Subscription whereId($value)
 */
class Subscription extends Model
{
    public $table = 'subscriptions';

    public $fillable = ['id', 'name', 'created_at', 'updated_at'];

    public static function getRows()
    {
        $result = DB::table('subscriptions')
            ->select(
                'subscriptions.*',
                DB::raw('COUNT(users_subscriptions.user_id) as count')
                )
            ->join('users_subscriptions', 'users_subscriptions.subscription_id', 'subscriptions.id')
            ->groupBy('subscriptions.id')
            ->get();

        return $result;
    }
}
