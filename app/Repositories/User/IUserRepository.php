<?php 

namespace App\Repositories\User;

use App\Models\User;

interface IUserRepository
{
    public function allUser();

    public function storeUser(array $data);

    public function getSingleUser(User $user);

    public function updateUser(User $user, array $data);

    public function deleteUser(User $user);
}