<?php


namespace Modules\User\Http\Controllers;


use App\Services\PageResults;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Modules\Admin\Entities\Role;
use Modules\User\Entities\EmployeeType;
use Modules\User\Entities\User;
use Illuminate\Http\Request;
use Modules\User\Http\Requests\CreateUserRequest;
use Modules\User\Http\Requests\UpdateUserRequest;
use Modules\User\Http\Requests\ForgotPasswordRequest;

class UserController extends Controller
{
    use ValidatesRequests;


    public function __construct()
    {
        $this->middleware('permission:users.view')->only('index', 'show', 'listTypes');

        $this->middleware('permission:users.add')->only('store');

        $this->middleware('permission:users.edit')->only('update');

        $this->middleware('permission:users.approve')->only('approve');

//        $this->middleware('role:admin')->only('delete', 'assignRoleToUser');

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request, PageResults $pageResults)
    {
        return response()->json($pageResults->getPaginator($request, User::class, ['email']));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(User $user)
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
        return response()->json(['data' => $data]);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  User $user
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateUserRequest $request, User $user)
    {

        $data = $request->validated();

        if(isset($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        }

        $user->fill($data);
        $user->save($data);
        if(isset($data['role_name'])) {
            $role = Role::create(['name' => $data['role_name']]);
            $role->syncPermissions($data['permissions']);
            $data['roles'][] = $role->id;
        }

        if(isset($data['roles'])) {
            $user->syncRoles($data['roles']);
        }


        return response()->json([
            'message' => lang('Update successful')
        ], 200);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  User $user
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(User $user)
    {
        $user->delete();

        return response()->json([
            'message' => lang('Delete succesful')
        ], 204);
    }


    /**
     * Create user
     * @param string $role (in POST)
     * @param User $user (in URL)
     * @return
     **/

    public function store(CreateUserRequest $request)
    {
        $data = $request->validated();

        $data['password'] = Hash::make($data['password']);
        $data['activationcode'] = Str::random(20);
        $data['status'] = User::STATUS_DISABLED;
        User::create($data);

        Mail::send('user::emails.welcome_email', $data, function($message) use ($data)
        {
            $message->subject(lang("welcome_title"));
            $message->to($data['email']);
        });

        return response()->json([
            'message' => lang("registraton_successfully")
        ], 201);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */

    public function verify(Request $request) {
        if($request->get('code') != ''){
            $user = User::where('activationcode', '=', $request->get('code'))->first();
            if ($user !== null) {
                $user->activationcode = null;
                $user->status = User::STATUS_PENDING;
                $user->save();
                return response()->json([
                    'message' => lang("verify_success")
                ], 201);
            }
            return response()->json([
                'message' => lang("verify_error_no_user_foud")
            ], 404);
        }
        return response()->json([
            'message' => lang("verify_error")
        ], 404);
    }

    /**
     * @param User $user
     * @return \Illuminate\Http\JsonResponse
     */

    public function approve(User $user) {
        if ($user !== null) {
            $user->status = User::STATUS_ACTIVE;
            $user->save();

            $email_data['email'] = $user->email;
            Mail::send('user::emails.success_email', $email_data, function($message) use ($email_data)
            {
                $message->subject(lang("welcome_title"));
                $message->to($email_data['email']);
            });

            return response()->json([
                'message' => lang("approve_success")
            ], 201);
        }

        return response()->json([
            'message' => lang("approve_error")
        ], 200);

    }

    /**
     * @param User $user
     * @return \Illuminate\Http\JsonResponse
     */

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
            ], 201);
        }

        return response()->json([
            'message' => lang("forgotpassword_error")
        ], 200);
    }

    /**
     * @param ForgotPasswordRequest $request
     * @return \Illuminate\Http\JsonResponse
     */

    public function changePassword(ForgotPasswordRequest $request){
        $data = $request->validated();
        $user = User::where('activationcode', '=', $data['code'])->first();
        if ($user !== null) {
            $user->activationcode = null;
            $user->password = Hash::make($data['password']);
            $user->save();
            return response()->json([
                'message' => lang("change_password_success")
            ], 201);
        }

        return response()->json([
            'message' => lang("change_password_error")
        ], 200);
    }

    /**
     * @param User $user
     * @return \Illuminate\Http\JsonResponse
     */

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
                ], 201);
            }
        }

        return response()->json([
            'message' => lang("resend_confirmation_error")
        ], 200);

    }

    /**
     * @param CreateUserRequest $request
     * @return \Illuminate\Http\JsonResponse
     */

    public function createAccount(CreateUserRequest $request){
        $data = $request->validated();

        $data['password'] = Hash::make($data['password']);
        $data['activationcode'] = Str::random(20);
        $data['status'] = User::STATUS_PENDING;
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
     * @param Request $request
     * @param User $user
     * @return \Illuminate\Http\JsonResponse
     */

    public function assignRoleToUser(Request $request, User $user)
    {
        $data = $request->validate([
            'role' => 'required|exists:Modules\Admin\Entities\Role,name'
        ]);

        $user->assignRole($data['role']);

        return response()->json([
            'message' => lang('Assign role succesful')
        ], 200);
    }

    public function listTypes()
    {
        return response()->json(['data' => EmployeeType::all()]);
    }
}
