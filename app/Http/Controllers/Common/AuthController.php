<?php

namespace App\Http\Controllers\Common;

use App\Utils\LogLoginUtil;
use App\Http\Requests\LoginRequest;
use App\Http\Controllers\Controller;
use App\Repositories\Interfaces\AuthRepositoryInterface;

/**
 * Auth Class : Login/Logout
 * Class AuthController
 * @package App\Http\Controllers\Common
 */
class AuthController extends Controller
{
    protected $authRepository;

    /**
     * Create a new controller instance function.
     *
     * @param AuthRepositoryInterface $authRepository
     * @return void
     */
    public function __construct(AuthRepositoryInterface $authRepository)
    {
        $this->authRepository = $authRepository;
    }

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
        return back()->withErrors('ログインID、またはパスワードが正しくありません。')
            ->withInput();
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

        return back()->withErrors('ログインID、またはパスワードが正しくありません。')
            ->withInput();
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
        $user = $this->authRepository->getUser($userId);
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
        if (empty($this->authRepository->checkRole($operatorCD))) {
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
