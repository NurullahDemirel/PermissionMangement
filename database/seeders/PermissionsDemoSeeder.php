<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Testing\Fluent\Concerns\Has;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;
use Illuminate\Support\Str;

class PermissionsDemoSeeder extends Seeder
{
    /**
     * Create the initial roles and permissions.
     *
     * @return void
     */
    public function run()
    {
        // Reset cached roles and permissions
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // create permissions
        Permission::create(['name' => 'edit articles']);
        Permission::create(['name' => 'delete articles']);
        Permission::create(['name' => 'publish articles']);
        Permission::create(['name' => 'unpublish articles']);
        Permission::create(['name' => 'create user']);
        // create roles and assign existing permissions
        $role1 = Role::create(['name' => User::ROLE_WRITER]);
        $role1->givePermissionTo('edit articles');
        $role1->givePermissionTo('delete articles');

        $role2 = Role::create(['name' => User::ROLE_ADMIN]);

        $role2->givePermissionTo('publish articles');
        $role2->givePermissionTo('unpublish articles');
        $role2->givePermissionTo('create user');

        $role3 = Role::create(['name' => User::ROLE_SUPER_ADMIN]);
        // gets all permissions via Gate::before rule; see AuthServiceProvider

        // create demo users
        $user = \App\Models\User::create([
            'name' => 'Nurullah Demirel',
            'email' => 'i@gmail.com',
            'password'=>Hash::make('12345678'),
//            'activate_code'=>Str::limit(md5(now()->timestamp), 60)
        ]);

        $user->assignRole($role2);// kendimi admin yaptım
        $user->givePermissionTo('create user');//kendime kullanıcı oluşturabilme izni verdim

        $user = \App\Models\User::create([
            'name' => 'Emre Demirel',
            'email' => 'a@gmail.com',
            'password'=>Hash::make('12345678'),
        ]);
        $user->assignRole($role1);
    }
}
