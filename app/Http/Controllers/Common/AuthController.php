<?php

namespace App\Http\Controllers\Common;

use App\Utils\LogLoginUtil;
use App\Models\MstOperator;
use App\Http\Requests\LoginRequest;
use App\Http\Controllers\Controller;
use App\Models\MstOperatorSpecialRole;

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
        // only check if whether user_id has exists. 
        $user = MstOperator::join('mst_post', function ($join) {
            $join->on('mst_post.post_cd', '=', 'mst_operator.post_cd');
            $join->where('mst_post.delete_flg', 0);
            })
            ->where('mst_operator.user_id', $userId)
            ->where('mst_operator.delete_flg', 0)
            ->select([
                'mst_operator.operator_cd',
                'mst_operator.operator_last_name',
                'mst_operator.operator_first_name',
                'mst_operator.user_id',
                'mst_operator.password',
                'mst_operator.admin_div',
                'mst_post.post_cd',
                'mst_post.post_name',
                'mst_operator.emp_no'
            ])->first();
        if (is_null($user)) {
            // Log login fail when user does not exist.
            LogLoginUtil::logLoginFail(['user_id' => $userId]);
            return false;
        }

        if ($password !== $user->password) {
            // Log login fail when user exists but password is not correct.
            LogLoginUtil::logLoginFail($user->toArray());
            return false;
        }

        // the user has admin role can access as normal user
        if ($user->admin_div !== $admin) {
            if($user->admin_div === config('define.admin_div.user')) {
                session()->flash('permission_error', '管理者権限がありません。');
                return false;
            }
        }
        
        if($this->isRole($user['operator_cd'])) {
            session(['user' => $user]);
            return true;
        }

        return false;
    }

    /**
     * Check exist role of user function
     *
     * @param int $operatorCD
     * @return void
     */
    public function isRole(int $operatorCD)
    {
        if(!MstOperatorSpecialRole::where('operator_cd', $operatorCD)->exists()) {
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
