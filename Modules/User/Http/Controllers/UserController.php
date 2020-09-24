<?php


namespace Modules\User\Http\Controllers;


use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Hash;
use Modules\User\Entities\Role;
use Modules\User\Entities\User;
use Modules\User\Http\Requests\CreateUserRequest;
use Modules\User\Http\Requests\ForgotPasswordRequest;
use Illuminate\Http\Request;
use Mail;
use Str;
use Auth;

class UserController extends Controller
{
    use ValidatesRequests;

    public function store(CreateUserRequest $request)
    {
        $data = $request->validated();

        $data['password'] = Hash::make($data['password']);
        $data['activationcode'] = Str::random(20);
        $user = User::create($data);

        Mail::send('user::emails.welcome_email', $data, function($message) use ($data)
        {
            $message->subject(lang("welcome_title"));
            $message->to($data['email']);
        });

        return response()->json([
            'message' => lang("registraton_successfully")
        ], 201);
    }

    public function verify(Request $request) {
        if($request->get('code') != ''){
            $user = User::where('activationcode', '=', $request->get('code'))->first();
            if ($user !== null) {
                $user->activationcode = null;
                /**
                 * TODO: Gpetrescu - create global status variables
                 */
                $user->status = 1;
                $user->save();
                return response()->json([
                    'message' => lang("verify_success")
                ], 201);
            }
        }
        return response()->json([
            'message' => lang("verify_error")
        ], 200);
    }

    public function approve(User $user) {
        if ($user !== null) {
            /**
             * TODO: Gpetrescu - create global status variables
             */
            $user->status = 2;
            $user->save();

            $email_data['email'] = $user->email;
            Mail::send('user::emails.success_email', $email_data, function($message) use ($email_data)
            {
                $message->subject(lang("welcome_title"));
                $message->to($email_data['email']);
            });

            return response()->json([
                'message' => lang("approve_success")
            ], 200);
        }

        return response()->json([
            'message' => lang("approve_error")
        ], 200);

    }

    public function forgotPassword(User $user){
        if ($user !== null) {
            $user->activationcode = Str::random(20);
            $email_data['email'] = $user->email;
            $email_data['activationcode'] = $user->activationcode;
            $email_data['firstname'] = $user->firstname;

            Mail::send('user::emails.forgot_password', $email_data, function ($message) use ($email_data) {
                $message->subject(lang("forgot_password_title"));
                $message->to($email_data['email']);
            });

            $user->save();

            return response()->json([
                'message' => lang("forgotpassword_success")
            ], 200);
        }

        return response()->json([
            'message' => lang("forgotpassword_error")
        ], 200);
    }

    public function changePassword(ForgotPasswordRequest $request){
        $data = $request->validated();
        $user = User::where('activationcode', '=', $data['code'])->first();
        if ($user !== null) {
            $user->activationcode = null;
            $user->password = Hash::make($data['password']);
            $user->save();
            return response()->json([
                'message' => lang("change_password_success")
            ], 200);
        }

        return response()->json([
            'message' => lang("change_password_error")
        ], 200);
    }

    public function resendConfirmation(User $user) {
        if ($user !== null) {
            if($user->activationcode != ''){
                $email_data['email'] = $user->email;
                $email_data['activationcode'] = $user->activationcode;
                $email_data['firstname'] = $user->firstname;

                Mail::send('user::emails.resend_confirmation', $email_data, function ($message) use ($email_data) {
                    $message->subject(lang("forgot_password_title"));
                    $message->to($email_data['email']);
                });
                return response()->json([
                    'message' => lang("resend_confirmation_success")
                ], 200);
            }
        }

        return response()->json([
            'message' => lang("resend_confirmation_error")
        ], 200);

    }

    public function createAccount(CreateUserRequest $request){
        $data = $request->validated();

        $data['password'] = Hash::make($data['password']);
        $data['activationcode'] = Str::random(20);
        $user = User::create($data);

        Mail::send('user::emails.create_account', $data, function($message) use ($data)
        {
            $message->subject(lang("welcome_title"));
            $message->to($data['email']);
        });

        return response()->json([
            'message' => lang("registraton_successfully")
        ], 201);
    }
}
