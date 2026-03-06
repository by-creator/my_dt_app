<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    public function index()
    {
        $services = Service::all();
        return view('admin.services.index', compact('services'));
    }

    public function create()
    {
        return view('admin.services.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'   => 'required|string|max:255',
            'prefix' => 'required|string|max:5|unique:services,prefix',
        ]);

        Service::create($request->only('name', 'prefix'));

        return redirect()->route('services.index')->with('success', 'Service créé avec succès');
    }

    public function edit(Service $service)
    {
        return view('admin.services.edit', compact('service'));
    }

    public function update(Request $request, Service $service)
    {
        $request->validate([
            'name'   => 'required|string|max:255',
            'prefix' => 'required|string|max:5|unique:services,prefix,' . $service->id,
        ]);

        $service->update($request->only('name', 'prefix'));

        return redirect()->route('services.index')->with('success', 'Service modifié');
    }

    public function destroy(Service $service)
    {
        $service->delete();

        return redirect()->route('services.index')->with('success', 'Service supprimé');
    }
}
