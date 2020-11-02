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

    public function register()
    {
        return view('auth.register');
    }
}
