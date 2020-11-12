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
        $permissions = $user->getAllPermissions()->map(function ($item) {
            return [
                'id' => $item->id,
                'name' => $item->name
            ];
        });
        $data = $user->toArray();
        $data['roles'] = $user->roles->map(function ($item) {
            return [
                'id' => $item->id,
                'name' => $item->name
            ];
        });
        $data['permissions'] = $permissions->toArray();
        return view('users.edit', ['user' => json_encode($data)]);
    }
}
