<?php

namespace App\Http\Controllers\V1\Auth;

use App\Http\Controllers\Controller;
use App\Events\Profile\ProfileCreated;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\UserResource;
use App\Notifications\PasswordNotification;
use App\Notifications\ProfileNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Password;

class ProfileController extends Controller
{
    public function updateProfile(Request $request)
    {

        $user = User::first();

        $data = Validator::make($request->all(),[
            'first_name' => 'required',
            'last_name' => 'required',
            'username' => 'required|unique:users',
            'avatar' => 'required',
            'gender' => 'required',
            'occupation' => 'required',
            'phone_number' => 'required|max:11',
            'address' => 'required',
            'country' => 'required',
            'state' => 'required',
            'city' => 'required',
           // 'email' => 'required|same:email'
        ]);

       // dd($data);
  
        if($data->fails()) {
            return response()->json([
                'message'=> 'please check your credentials fillable and try again'
            ]);

        }

        $profile = $request->user();

        if( $request->hasFile('avatar')) {
  
            $avatar = $request->avatar;
  
            $originalName = $avatar->getClientOriginalName();
    
            $image_new_name = 'avatar-' .time() .  '-' .$originalName;
    
            $avatar->move('profile/avatar', $image_new_name);
  
            $profile->avatar = 'profile/avatar/' . $image_new_name;
      }

        $profile->first_name = $request->input('first_name');
        $profile->last_name = $request->input('last_name');
        $profile->username = $request->input('username');
        $profile->gender = $request->input('gender');
        $profile->occupation = $request->input('occupation');
        $profile->country = $request->input('country');
        $profile->state = $request->input('state');
        $profile->city = $request->input('city');
        $profile->phone_number = $request->input('phone_number');
        $profile->address = $request->input('address');
        $profile->update();

        $user->verify(new ProfileNotification($user));

        event(new ProfileCreated($profile));

        Cache::put('user', $data);

        return new UserResource($profile);

      // return response()->json(['message' => 'successfully']);
    }

    public function changePassword(Request $request)
    {

        $user = User::first();

        $data = Validator::make($request->all(), [
            "old_password" => "required",
            "password" => "required",
            "confirm_password" => "required|same:password"
           ]);
    
           if($data->fails()) {
            return response()->json([
                'message'=> 'check your passwords for validation'], 422);
           }
    
           $user = $request->user();
    
            if( Hash::check($request->old_password, $user->password)){
               
                $user->update([
                    'password' => Hash::make($request->password)
                ]);

               $user->verify(new PasswordNotification($user));

               Cache::put('user', $data);
    
               return response()->json([
                  'message'=> 'Password Updated Successfully',
               ], 200);
    
            } else {
                return response()->json([
                    'message' => 'old password does no match !'
                ], 401);
             }
    }
}
