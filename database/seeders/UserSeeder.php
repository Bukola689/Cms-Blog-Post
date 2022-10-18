<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::factory()->count(5)->create()->each(
            function($user) {
                $user->assignRole('admin');
            }
        );

        // User::factory()->count(7)->create()->each(
        //     function($user) {
        //         $user->assignRole('user');
        //     }
        // );
    }
}
