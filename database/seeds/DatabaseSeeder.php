<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        //$this->call(UsersTableSeeder::class);
        $this->call(PermissionTablesSeeder::class);
        $this->call(AdminRoleTablesSeeder::class);
        $this->call(BloggerRoleTablesSeeder::class);
        $this->call(SupervisorRoleTablesSeeder::class);
        $this->call(UserTableSeeder::class);
    }
}
