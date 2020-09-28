<?php

namespace Modules\User\Http\Controllers;

use GenTux\Jwt\JwtToken;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller;
use Modules\User\Entities\User;
use Modules\User\Http\Requests\AuthRequest;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class AuthController extends Controller
{
    use ValidatesRequests;

    public function login(AuthRequest $request, JwtToken $jwtToken)
    {
        $data = $request->validated();

        $user = User::where('email', $data['email'])->first();

        throw_if(!$user, new NotFoundHttpException(lang('user_not_found')));

        throw_if(
            !app('hash')->check($data['password'], $user->password),
            new HttpException(401,lang('invalid_credentials')));


        $token = $jwtToken->createToken($user);
        return response()->json([
            "message" => lang("successful_login"),
            "jwt" => $token
        ]);
    }
}
