<?php


namespace Modules\User\Http\Controllers;


use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Hash;
use Modules\User\Entities\User;
use Modules\User\Http\Requests\CreateUserRequest;

class UserController extends Controller
{
    use ValidatesRequests;

    public function store(CreateUserRequest $request)
    {
        $data = $request->validated();

        $data['password'] = Hash::make($data['password']);
        User::create($data);

        return response()->json([
            'message' => '*Registration successful, for activation please verify in the registered Email*'
        ], 201);
    }


}
