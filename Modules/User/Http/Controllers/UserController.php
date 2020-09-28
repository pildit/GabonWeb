<?php


namespace Modules\User\Http\Controllers;


use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Hash;
use Modules\User\Entities\Role;
use Modules\User\Entities\User;
use Illuminate\Http\Request;
use Modules\User\Http\Requests\CreateUserRequest;
use Modules\User\Http\Requests\UpdateUserRequest;
use Modules\User\Http\Requests\AssignRoleToUserRequest;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Modules\User\Services\User as UserService;
use Modules\User\Http\Requests\ForgotPasswordRequest;
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
                $user->status = $user->STATUS_PENDING;
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
            $user->status = $user->STATUS_ACTIVE;
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


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request,UserService $userService)
    {
        $userService->validateRequest($request);
        $userService->setPage($request->get('page'));
        $userService->setPerPage($request->get('per_page'));
        $userService->setSearch($request->get('search'));

        return response()->json($userService->getPaginator());
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {

        return response()->json($user, 200);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  User $user
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateUserRequest $request, User $user)
    {

        $data = $request->validated();

        $user->fill($data);
        $user->save($data);

        return response()->json([
             'message' => lang('Update successful')
        ], 200);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  User $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $user->destroy();

        return response()->json([
            'message' => lang('Delete succesful')
        ], 204);
    }


    /**
     * Assign role to user
     * @param string $role (in POST)
     * @param User $user (in URL)
     * @return
     **/

    public function assignRoleToUser(Request $request, User $user)
    {

        $data = $request->validate([
            'role' => 'required|exists:roles,name'
        ]);


        $user->assignRole($data['role']);

        return response()->json([
            'message' => lang('Assign role succesful')
        ], 200);


    }

}
