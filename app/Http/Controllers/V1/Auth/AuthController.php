<?php

namespace App\Http\Controllers\V1\Auth;

use App\Events\Register;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Notifications\Auth\LoginNotification;
use App\Notifications\RegisterNotification;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Mail;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $user = User::first();

        $user = $request->validate([
            'username' => 'required',
            'email' => 'required',
            'password' => 'required' 
        ]);

        $user = User::create([
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $token  = $user->createToken('myapptoken')->plainTextToken;

        $response = [
            'user'=>$user,
            'token'=>$token,
        ];

        $when = Carbon::now()->addSeconds(10);

        $user->notify((new RegisterNotification($user))->delay($when));

        event(new Register($user));

        cache()->forget('user:all');

        return response($response, 201);
    }

    public function login(Request $request)
    {
        
        $user = User::first();

        $data = $request->validate([
            'email' => 'required',
            'password' => 'required|min:8',
        ]);

      $user = User::where('email', $data['email'])->first();

      if(!$user || !Hash::check($data['password'], $user->password))
      {
          return response(['message'=>'invalid credentials'], 401);
      } else {
        $token  = $user->createToken('myapptoken')->plainTextToken;

        $response = [
            'user'=>$user,
            'token'=>$token,
        ];

        event(new Register($user));

        $when = Carbon::now()->addSeconds(10);

        $user->notify((new LoginNotification($user))->delay($when));

        Cache::put('comment', $data);

        return response($response, 200);
      }
    }

    public function logout(Request $request, User $user) 
    {
        $user->tokens()->delete();

        return response()->json('Successfully logged out');
    }

}
