<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class SupervisorRoleTablesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin = Role::create([
            'name' => 'supervisor',
            'guard_name' => 'web',
        ]);

        $admin->givePermissionTo(Permission::where('name', 'like', 'blog%')->get());
    }
}
