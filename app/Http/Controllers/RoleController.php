<?php


namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Role;

class RoleController extends Controller
{
    public function index()
    {
        $roles = Role::all();
        return view('roles.index', compact('roles'));
    }

    public function create()
    {
        return view('roles.create');
    }

    public function store(Request $request)
    {
        $request->validate(['name' => 'required|unique:roles']);
        Role::create($request->all());
        return redirect()->route('roles.index')->with('success', 'Role created.');
    }

    public function edit(Role $role)
    {
        return view('roles.edit', compact('role'));
    }

    public function update(Request $request, Role $role)
    {
        $request->validate(['name' => 'required|unique:roles,name,' . $role->id]);
        $role->update($request->all());
        return redirect()->route('roles.index')->with('success', 'Role updated.');
    }

    public function destroy(Role $role)
    {
        $role->delete();
        return redirect()->route('roles.index')->with('success', 'Role deleted.');
    }

    public function show(Role $role)
{
    $employees = $role->employees;
    return view('roles.show', compact('role', 'employees'));
}

}
