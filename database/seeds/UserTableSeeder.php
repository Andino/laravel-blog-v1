<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\User;

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
    }
}
