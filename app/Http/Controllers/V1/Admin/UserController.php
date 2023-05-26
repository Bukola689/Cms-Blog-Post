<?php

namespace App\Http\Controllers\V1\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Http\Resources\UserResource;
use App\Repositories\User\UserRepository;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class UserController extends Controller
{
    public $user;

    public function __construct(UserRepository $user)
    {
        $this->user = $user;
    }

    public function index()
    {

        $users = Cache::remember('users', 60, function () {
            return  $this->user->allUser();
        });

        return UserResource::collection($users);
    }

    public function store(Request $request)
    {

    $data = $request->all();

     $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'username' => 'required|string|min:3|max:8|unique:users,name',
            'gebnder' => 'required',
            'occupation' => 'required|string',
            'country' => 'required|string',
            'state' => 'required|string',
            'city' => 'required|string',
            'phone_number' => 'required|int|min:11|max:11',
            'address' => 'required',
            'email' => 'required',
            'password' => 'required'     
           ]);

           $this->user->storeUser($data);

           Cache::put('user', $data);

           return response()->json([
            'message' => 'User Saved Successfully !'
           ]);
    }

        public function show(User $user)
        {
            $userId = Cache::remember('user:'. $user->id, 60, function () use ($user) {
                return $this->user->getSingleUser($user);  
            });
           
            return response()->json($userId);
        }

        public function update(Request $request, User $user)
        {
            $data = $request->all();

           $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'username' => 'required|string|min:3|max:8|unique:users,name',
            'gebnder' => 'required',
            'occupation' => 'required|string',
            'country' => 'required|string',
            'state' => 'required|string',
            'city' => 'required|string',
            'phone_number' => 'required|int|min:11|max:11',
            'address' => 'required', 
           ]);

           $this->user->updateUser($user, $data);

           Cache::put('user', $data);

           return response()->json([
            'message' => 'User updated Successfully !'
           ]);
        }

        public function destroy(User $user)
        {
           $this->user->deleteUser($user);

           Cache::pull('user');

            return response()->json([
                'message' => 'User deleted Sucessfully'
            ]);

        }

        public function suspend($id)
        {
           $user = User::find($id);
   
           if(! $user) {
               throw new NotFoundHttpException('user not found');
            }
   
            $user->active = false;
            $user->save();
   
            return response()->json([
               'message' => 'User Suspended Successfully'
            ]);
        }
   
        public function active($id)
        {
   
           $user = User::find($id);
   
           if(! $user) {
               throw new NotFoundHttpException('user not found');
            }
   
            $user->active = true;
            $user->save();
   
            return response()->json([
               'message' => 'User Been Active Successfully'
            ]);

        }
}
