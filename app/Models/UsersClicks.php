<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class UsersClicks
 * @package App\Models
 *
 * @property int $id
 * @property int $user_id
 * @property int $campaign_id
 * @property string $url
 * @property Carbon $time
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @method static \Illuminate\Database\Eloquent\Builder|UsersClicks whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UsersClicks whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UsersClicks whereCampaignId($value)
 */
class UsersClicks extends Model
{
    public $table = 'users_clicks';

}
