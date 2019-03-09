<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class UsersSubscription
 * @package App\Models
 *
 * @property int $id
 * @property int $user_id
 * @property int $subscription_id
 * @property Carbon $time
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @method static \Illuminate\Database\Eloquent\Builder|UsersSubscription whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UsersSubscription whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UsersSubscription whereSubscriptionId($value)
 */
class UsersSubscription extends Model
{
    public $table = 'users_subscriptions';

}
