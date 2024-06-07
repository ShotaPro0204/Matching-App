<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Match_History extends Model
{
    use HasFactory;

    public static function getListByCondition($condition)
    {
        $sql = "
            SELECT
                *
            FROM
                Mathing_histories mh
            WHERE 1=1"; // Always true condition to ensure WHERE clause always begins correctly

        // if (!empty($condition['user_id'])) {
        //     $user_id = $condition['user_id'];
        //     $sql .= " AND u.id = '$user_id'";
        // }
        if (!empty($condition['mh1'])) {
            $mh1 = $condition['mh1'];
            $sql .= " AND u.user_id = 'mh1'";
        }

        // SQLクエリを実行する
        $results = DB::select($sql);

        return $results;
    }
}
