<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Like extends Model
{
    use HasFactory;

    public static function getListByCondition($condition)
    {
        $sql = "
            SELECT
                *,
                u.id my_user_id
            FROM
                likes l
            JOIN
                users u
            ON
                l.user_id = u.id
            LEFT OUTER JOIN
                profiles p
            ON
                u.id = p.user_id
            LEFT OUTER JOIN
                match__histories mh
            ON
                mh.user_id1 = u.id
            WHERE 1=1"; // Always true condition to ensure WHERE clause always begins correctly

        // if (!empty($condition['user_id'])) {
        //     $user_id = $condition['user_id'];
        //     $sql .= " AND u.id = '$user_id'";
        // }
        if (!empty($condition['target_user_id'])) {
            $target_user_id = $condition['target_user_id'];
            $sql .= " AND l.target_user_id = '$target_user_id'";
        }
   
        // SQLクエリを実行する
        $results = DB::select($sql);

        return $results;
    }

    public static function getDetailByCondition($user_id, $target_user_id){
        $sql = "
            SELECT
                *
            FROM
                likes l
            WHERE l.user_id = ?
            AND l.target_user_id = ?";

        // SQLクエリを実行する
        $results = DB::select($sql, [$user_id, $target_user_id]);

        return $results;
    }
}
