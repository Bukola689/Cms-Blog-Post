<?php

namespace App\Http\Controllers\V1\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Http\Resources\UserResource;
use App\Repositories\User\UserRepository;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public $user;

    public function __construct(UserRepository $user)
    {
        $this->user = $user;
    }

    public function index()
    {
        $users = $this->user->allUser();

        return UserResource::collection($users);
    }

    public function getTotalUser()
    {
         $users = User::count();

        return UserResource::collection($users);
    }

    public function store(Request $request)
    {

    $data = $request->all();

     $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'username' => 'required',
            'email' => 'required',
            'password' => 'required'     
           ]);

           $this->user->storeUser($data);

           return response()->json([
            'message' => 'User Saved Successfully !'
           ]);
    }

        public function show(User $user)
        {
            return $user;
        }

        public function update(Request $request, User $user)
        {
            $data = $request->all();

           $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'username' => 'required',
            'email' => 'required',
            'password' => 'required'     
           ]);

           $this->user->updateUser($user, $data);

           return response()->json([
            'message' => 'User updated Successfully !'
           ]);
        }

        public function destroy(User $user)
        {
           $user = $this->user->deleteUser($user);

            return response()->json([
                'message' => 'User deleted Sucessfully'
            ]);

        }
}
