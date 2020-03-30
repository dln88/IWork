<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * Auth Class : Login/Logout
 * Class AuthController
 * @package App\Http\Controllers
 */
class AuthController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showLogin(){
        return view('login');
    }

    /**
     * @param LoginRequest $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function doLogin(LoginRequest $request){
        $email = $request->get('email');
        $password = $request->get('password');
       if ($this->login($email, $password, 2)){
           return redirect(route('staff.work.dates'));
       }
       else {
           return back()->with('error', 'Login failed!')
               ->with('email', $email)
               ->with('password', $password)
               ;
       }

    }

    /**
     * @param LoginRequest $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function doLoginAdmin(LoginRequest $request){
        $email = $request->get('email');
        $password = $request->get('password');
        if ($this->login($email, $password)){
            return redirect(route('admin.work_dates'));
        }
        else {
            return back()->with('error', 'Login failed!')
                ->with('email', $email)
                ->with('password', $password)
                ;
        }

    }

    /**
     * @param $email
     * @param $password
     * @param int $role_id
     * @return bool
     */
    private function login($email, $password, $role_id = 1) {
        $data = array(
            'email'     => $email,
            'password'  => $password,
            'role_id'   => $role_id
        );
        if (!Auth::attempt($data) ){
            return false;
        }
        return  true;
    }

    /**
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function logout(){
        Auth::logout();
        return redirect(route('login'));
    }
}
