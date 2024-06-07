<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;


class Profile extends Model
{
    use HasFactory;

    public static function getDetailByCondition($user_id){
        $sql = "
            SELECT
                *
            FROM
                profiles p
            JOIN users u
            ON u.id = p.user_id
            WHERE u.id = ?"; // Always true condition to ensure WHERE clause always begins correctly

        // SQLクエリを実行する
        $results = DB::select($sql, [$user_id]);

        return $results;
    }
}
