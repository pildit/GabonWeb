<?php


namespace Modules\User\Http\Controllers;


use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Hash;
use Modules\User\Entities\User;
use Illuminate\Http\Request;
use Modules\User\Http\Requests\CreateUserRequest;
use Modules\User\Http\Requests\UpdateUserRequest;
use Modules\User\Http\Requests\AssignRoleToUserRequest;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Modules\User\Services\User as UserService;

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
