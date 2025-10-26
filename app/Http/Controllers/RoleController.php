<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    public function index()
    {
        $roles = Role::orderBy('id', 'desc')->get();
        return view('dashboard', compact('roles'));
    }

    public function create(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',

        ]);

        Role::create($data);

        return redirect()->back()->with('create', 'Rôle créé avec succès.');
    }

    public function update(Request $request, $id)
    {
        $role = Role::findOrFail($id);

        $role->name = $request->name;

        $role->save();

        return redirect()->back()->with('update', 'Rôle mis à jour avec succès.');
    }

    public function delete($id)
    {
        $role = Role::findOrFail($id);
        $role->delete();

        return redirect()->back()->with('delete', 'Rôle supprimé avec succès.');
    }
}
