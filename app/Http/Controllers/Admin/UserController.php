<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        // $users = User::all();

        if(! $users = User::with('roles')->get()) {

            return response()->json(['message' => 'User not found']);
            
        }

       // return $users;

        return UserResource::collection($users);
    }

    public function getTotalUser()
    {
         $users = User::count();

        return UserResource::collection($users);
    }

    public function store(Request $request)
    {

        //dd($request->all());

        $data = Validator::make($request->all(),[
            'first_name' => 'required',
            'last_name' => 'required',
            'username' => 'required',
            // 'avatar' => 'required',
             'gender' => 'required',
            // 'occupation' => 'required',
            // 'country' => 'required',
            // 'state' => 'required',
            // 'city' => 'required',
            // 'phone_number' => 'required',
            // 'address' => 'required',
            'email' => 'required',        ]);

  
        if($data->fails()) {
            return response()->json([
                'message'=> 'please check your credentials and try again'
            ]);
        }
    
        $avatar = $request->avatar;
      
        $originalName = $avatar->getClientOriginalName();
    
        $image_new_name = 'avatar-' .time() .  '-' .$originalName;
    
        $avatar->move('users/avatar', $image_new_name);
    
             $user = new User;
             $user->first_name = $request->input('first_name');
             $user->last_name = $request->input('last_name');
             $user->username = $request->input('username');
             $user->avatar = 'users/avatar/' . $image_new_name;
             $user->gender = $request->input('gender');
             $user->occupation = $request->input('occupation');
             $user->country = $request->input('country');
             $user->state = $request->input('state');
             $user->city = $request->input('city');
             $user->phone_number = $request->input('phone_number');
             $user->address = $request->input('address');
             $user->email = $request->input('email');
             $user->password = Hash::make($request->password);
             $user->save();

             dd($user->save());
    
             return new UserResource($user);
    }

        public function show(User $user)
        {
            return new UserResource($user);
        }

        public function update(Request $request, User $user)
        {

           $data = $request->validate([
                'first_name' => 'required',
                'last_name' => 'required',
                'username' => 'required',
                'avatar' => 'required',
                'gender' => 'required',
                'occupation' => 'required',
                'country' => 'required',
                'state' => 'required',
                'city' => 'required',
                'phone_number' => 'required',
                'address' => 'required',
            ]);
    
            //dd($data);
            // $data = Validator::make($request->all(),[
            //   'first_name' => 'required',
            //   'last_name' => 'required',
            //    'username' => 'required',
            //   'avatar' => 'required',
            //   'gender' => 'required',
            //   'occupation' => 'required',
            //   'country' => 'required',
            //   'state' => 'required',
            //   'city' => 'required',
            //   'phone_number' => 'required',
            //   'address' => 'required',
            //   //'email' => 'required',
            // ]);
      
            // if($data->fails()) {
            //     return response()->json([
            //         'message'=> 'please check your credentials and try again'
            //     ]);
            // }
    
            //$user = $request->user();
    
            if ($request->hasFile('avatar')) {
      
                $avatar = $request->avatar;

                dd($avatar);
      
                $originalName = $avatar->getClientOriginalName();
        
                $avatar_new_name = 'avatar-' .time() .  '-' .$originalName;
        
                $avatar->move('users/profile', $avatar_new_name);
      
                $user->avatar = 'users/profile/' . $avatar_new_name;
          }

    
          $user->first_name = $request->input('first_name');
          $user->last_name = $request->input('last_name');
          $user->username = $request->input('username');
          $user->gender = $request->input('gender');
         // $user->avatar = $request->input('avatar');
          $user->occupation = $request->input('occupation');
          $user->country = $request->input('country');
          $user->state = $request->input('state');
          $user->city = $request->input('city');
          $user->phone_number = $request->input('phone_number');
          $user->address = $request->input('address');
         // $user->email = $request->input('email');
          $user->update();
    
            return new UserResource($user);
        }

        public function delete(User $user)
        {
            $user = $user->delete();

            return new UserResource($user);

        }
}
