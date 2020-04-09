<?php

namespace App\Repositories;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use App\Repositories\Interfaces\AuthRepositoryInterface;

class AuthRepository implements AuthRepositoryInterface
{
    /**
     * Get user function
     *
     * @param string $userId
     * @return collection
     */
    public function getUser(string $userId)
    {
        $query = "SELECT op.operator_cd, op.operator_last_name, op.operator_first_name, 
        op.user_id, op.password, op.admin_div, po.post_cd, po.post_name, op.emp_no
        FROM mst_operator op
        INNER JOIN mst_post po ON op.post_cd = po.post_cd and po.delete_flg = 0
        WHERE op.user_id = ?
        AND COALESCE(op.resigned_day, '20991231') >= ?
        AND op.delete_flg = 0";

        $currentDate = Carbon::now()->format('Ymd');
        return DB::select($query, [$userId, $currentDate]);
    }

    /**
     * Check role of user function
     *
     * @param int $operatorCD
     * @return collection
     */
    public function checkRole(int $operatorCD)
    {
        $query = "SELECT o_s_role.special_role_key
        FROM mst_operator_special_role o_s_role
        WHERE o_s_role.operator_cd = ?";

        return DB::select($query,  [$operatorCD]);
    }
}
