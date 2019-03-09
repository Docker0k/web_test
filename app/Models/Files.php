<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

/**
 * Class Files
 * @package App\Models
 *
 * @property int $id
 * @property string $file_name
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @method static \Illuminate\Database\Eloquent\Builder|Files whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Files whereFileName($value)
 */
class Files extends Model
{
    public $table = 'files';

    public static function getRows()
    {
        $result = DB::table('files')
            ->select(
                'files.*',
                DB::raw('COUNT(profiles.id) as count')
            )
            ->join('profiles', 'profiles.file_id', 'files.id')
            ->groupBy('files.id')
            ->get();

        return $result;
    }

    public static function getRowsLimited( int $limit )
    {
        $result = DB::table('files')
            ->select(
                'files.*',
                DB::raw('COUNT(profiles.id) as count')
            )
            ->join('profiles', 'profiles.file_id', 'files.id')
            ->groupBy('files.id')
            ->having('count', '>=', $limit)
            ->get();

        return $result;
    }
}
