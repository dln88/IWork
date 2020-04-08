<?php

namespace App\Http\Controllers\Common;

use Carbon\Carbon;
use App\Utils\LogLoginUtil;
use App\Http\Requests\LoginRequest;
use App\Http\Controllers\Controller;
use App\Models\MstOperatorSpecialRole;
use Illuminate\Support\Facades\DB;

/**
 * Auth Class : Login/Logout
 * Class AuthController
 * @package App\Http\Controllers\Common
 */
class AuthController extends Controller
{
    /**
     * Show the form to the user login.
     * 
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showLogin(){
        return view('login');
    }

    /**
     * Login as normal user.
     * 
     * @param LoginRequest $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function doLogin(LoginRequest $request) {
        $credentials  = $request->only(['user_id', 'password']);
        if ($this->login($credentials['user_id'], $credentials['password'])) {
            // Log login when the user login successfully.
            LogLoginUtil::logLoginSuccess();
            return redirect(route('person.work.dates'));
        }
        return back()->withErrors(['msg', 'ログインID、またはパスワードが正しくありません。']);
    }

    /**
     * Login as administrator.
     * 
     * @param LoginRequest $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function doLoginAdmin(LoginRequest $request){
        $credentials = $request->only(['user_id', 'password']);
        if ($this->login($credentials['user_id'], $credentials['password'], 1)){
            // Log login when the user login successfully.
            LogLoginUtil::logLoginSuccess();
            return redirect(route('admin.work_dates'));
        }

        return back()->withErrors(['msg', 'ログインID、またはパスワードが正しくありません。']);
    }

    /**
     * Action login.
     * 
     * @param string $userId
     * @param string $password
     * @param int $admin
     * @return bool
     */
    private function login($userId, $password, $admin = 0) {
        $currentDate = Carbon::now()->format('Ymd');
        // only check if whether user_id has exists. 
        $user = DB::select("SELECT op.operator_cd, op.operator_last_name, op.operator_first_name, 
            op.user_id, op.password, op.admin_div, po.post_cd, po.post_name, op.emp_no
            FROM mst_operator op
            INNER JOIN mst_post po ON op.post_cd = po.post_cd and po.delete_flg = 0
            WHERE op.user_id = ?
            AND COALESCE(op.resigned_day, '20991231') >= ?
            AND op.delete_flg = 0", [$userId, $currentDate]);
        if (empty($user)) {
            // Log login fail when user does not exist.
            LogLoginUtil::logLoginFail(['user_id' => $userId]);
            return false;
        }

        if ($password !== $user[0]->password) {
            // Log login fail when user exists but password is not correct.
            LogLoginUtil::logLoginFail((array) $user[0]);
            return false;
        }

        // the user has admin role can access as normal user
        if ($user[0]->admin_div !== $admin) {
            if($user[0]->admin_div === config('define.admin_div.user')) {
                session()->flash('permission_error', '管理者権限がありません。');
                return false;
            }
        }
        
        if($this->isRole($user[0]->operator_cd)) {
            session(['user' => $user[0]]);
            return true;
        }

        return false;
    }

    /**
     * Check exist role of user function
     *
     * @param int $operatorCD
     * @return boolean
     */
    public function isRole(int $operatorCD)
    {
        $checkRole = DB::select('SELECT o_s_role.special_role_key
            FROM mst_operator_special_role o_s_role
            WHERE o_s_role.operator_cd = ?', [$operatorCD]);
        if (empty($checkRole)) {
            return false;
        }
        return true;
    }

    /**
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function logout() {
        session()->forget('user');
        return redirect(route('login'));
    }
}
