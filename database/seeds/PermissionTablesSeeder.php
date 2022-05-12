<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionTablesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = $this->permissions();
        collect($permissions)->each(
            function ($permission) {
                Permission::create(
                    [
                        'name' => $permission,
                        'guard_name' => 'web',
                    ]
                );
            }
        );
    }

    public function permissions()
    {
        return [
            'users create',
            'users list',
            'users edit',
            'users delete',
            'users detail',
            'blog create',
            'blog list',
            'blog edit',
            'blog delete',
            'blog detail'
        ];
    }
}
