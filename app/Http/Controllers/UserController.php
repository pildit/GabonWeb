<?php


namespace App\Http\Controllers;


use Modules\User\Entities\User;

class UserController extends Controller
{
    /**
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('users.index');
    }

    public function edit(User $user)
    {
        return view('users.edit', ['user' => $user]);
    }
}
