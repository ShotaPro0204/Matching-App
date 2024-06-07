<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;
use Laravel\Cashier\Billable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;
    use Billable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public static function getListByCondition($condition)
    {
        $sql = "
            SELECT
                *
            FROM
                users u
            LEFT OUTER JOIN profiles p
            ON u.id = p.user_id
            WHERE 1=1"; // Always true condition to ensure WHERE clause always begins correctly

        // if (!empty($condition['user_id'])) {
        //     $user_id = $condition['user_id'];
        //     $sql .= " AND u.id = '$user_id'";
        // }
        if (!empty($condition['gender'])) {
            $gender = $condition['gender'];
            $sql .= " AND u.gender = '$gender'";
        }
        if (!empty($condition['name'])) {
            $name = $condition['name'];
            $sql .= " AND u.name LIKE '%$name%'";
        }

        // SQLクエリを実行する
        $results = DB::select($sql);

        return $results;
    }

    public static function getDetailByCondition($user_id){
        $sql = "
            SELECT
                *
            FROM
                users u
            LEFT OUTER JOIN profiles p
            ON u.id = p.user_id
            WHERE u.id = ?"; // Always true condition to ensure WHERE clause always begins correctly

        // SQLクエリを実行する
        $results = DB::select($sql, [$user_id]);

        return $results;
    }


}
