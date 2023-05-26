<?php 

namespace App\Repositories\User;

use App\Models\User;
use App\Http\Resources\UserResource;
use Exception;

class UserRepository implements IUserRepository
{
    public function allUser()
    {

        if(! $users = User::with('roles')->get()) {

            return response()->json(['message' => 'User not found']);
            
        }

        return UserResource::collection($users);
    }

    public function storeUser(array $data)
    {
       User::insert([
        'first_name' => $data['first_name'],
        'last_name' => $data['last_name'],
        'username' => $data['username'],
        'gender' => $data['gender'],
        'occupation' => $data['occupation'],
        'country' => $data['country'],
        'state' => $data['state'],
        'city' => $data['city'],
        'phone_number' => $data['phone_number'],
        'address' => $data['address'],
        'email' => $data['email'],
        'password' => $data['password'],
       ]);
    }

    public function getSingleUser(User $user)
    {
        return $user;
    }

    public function updateUser(User $user, array $data)
    {
        $user->update([
          'first_name' => $data['first_name'],
          'last_name' => $data['last_name'],
          'username' => $data['username'],
          'gender' => $data['gender'],
          'occupation' => $data['occupation'],
          'country' => $data['country'],
          'state' => $data['state'],
          'city' => $data['city'],
          'phone_number' => $data['phone_number'],
          'address' => $data['address'],
         ]);
    }

    public function deleteUser(User $user)
    {
        $user = $user->delete();
    }

}