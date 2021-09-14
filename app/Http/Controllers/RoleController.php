<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    public function index()
    {
        $roles = Role::with('permissions')->get();
        $permissions = Permission::all();
        return view('Rolemange.index', compact('roles', 'permissions'));
    }//role yönetimi

    public function deleteRole($id)
    {//
        $role = Role::findById($id);

        $name = $role->name;

        $role->delete();

        return redirect()->route('role-manage')
            ->with('mesaj', $name . 'has deleted')
            ->with('mesaj_tur', 'danger');

    }//silinmesi modal ile onaylanan role silinmesi için buraya düşer

    public function createRole(Request $request)
    {
        $request->validate([
            'role_name' => 'required|max:30|min:5',
            'permissions' => 'required',
        ]);

        $role_name = $request->role_name;
        $permissions = $request->permissions;

        $role = Role::create(['name' => $role_name]);
        $role->syncPermissions($permissions);//oluşturulan rol ile permissionları ilişkilendirir

        return redirect()->route('role-manage')
            ->with('mesaj', $role->name . 'role has created')
            ->with('mesaj_tur', 'success');

    }//modal ile gelen role ismi ve role ait permissionlar buraya düşer

    public function newPermissonOfRole(Request $request)
    {
        $role = Role::findById($request->role_id);

        $newPermisonOfRole = $request->permissions;

        $role->syncPermissions($newPermisonOfRole);

        return redirect()->route('role-manage')
            ->with('mesaj', 'changes has saved');
    }//modal da gelen yeni permissonları gerekli role ile ilişkilendirir.
}
