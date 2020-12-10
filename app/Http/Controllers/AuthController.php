<?php


namespace App\Http\Controllers;



class AuthController extends Controller
{
    /**
     * Login page
     *
     * @return \Illuminate\View\View
     */
    public function login()
    {
        return view('auth.login');
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function logout()
    {
        setcookie('jwt', null, -1, '/' );
        return redirect()->to('/');
    }

    /**
     * @return \Illuminate\View\View
     */
    public function register()
    {
        return view('auth.register');
    }

    /**
     * @return \Illuminate\View\View
     */
    public function emailConfirmation($token)
    {
        return view('auth.confirmation', ['token' => $token]);
    }

    /**
     * @return \Illuminate\View\View
     */
    public function forgotPassword () {

        return view('auth.forgot_password');
    }

    public function verify () {
        $code = request()->get('code');

        return view('auth.reset_password')->with([
            'code'  => $code
        ]);

    }

}
