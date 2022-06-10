<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\User;
use App\Blog;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin = User::create([
            'first_name' => 'Jhon',
            'last_name' => 'Doe',
            'email' => 'laravel.admin@gmail.com',
            'password' => Hash::make('secret')
        ]);
        $admin->assignRole('administrator');
        factory(User::class, 50)->create()->each(function ($user){
            $roles = ["supervisor", "blogger"];
            $key = array_rand($roles);
            $user->assignRole($roles[$key]);

            $blog = Blog::create([
                'name' => $user->first_name . " " . $user->last_name . "Created blog",
                'description' => "Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.",
                'user_id' => $user->id,
            ]);
        });
    }
}
