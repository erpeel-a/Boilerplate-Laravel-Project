<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = [
            'post-list',
            'post-create',
            'post-edit',
            'post-delete',
            'category-list',
            'category-create',
            'category-edit',
            'category-delete',
            'user-list',
            'user-create',
            'user-delete',
            'role-list',
            'role-create',
            'role-edit',
            'role-delete',
            'publish-post',
            'archive-post',
            'change-user-role',
            'trash-post'
        ];
    
        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }
    }
}
