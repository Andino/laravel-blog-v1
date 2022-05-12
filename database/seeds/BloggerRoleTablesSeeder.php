<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class BloggerRoleTablesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin = Role::create([
            'name' => 'blogger',
            'guard_name' => 'web',
        ]);

        $admin->givePermissionTo(Permission::where('name', 'like', 'blog%')->get());
    }
}
