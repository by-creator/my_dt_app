<?php

namespace App\Http\Controllers;

use App\Models\Agent;
use App\Models\Service;
use Illuminate\Http\Request;

class AgentController extends Controller
{
    public function index()
    {
        $agents = Agent::with('service')->get();
        return view('admin.agents.index', compact('agents'));
    }

    public function create()
    {
        $services = Service::all();
        return view('admin.agents.create', compact('services'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'       => 'required|string|max:255',
            'info'       => 'required|string|max:255',
            'service_id' => 'required|exists:services,id',
        ]);

        Agent::create($request->only('name', 'info', 'service_id'));

        return redirect()->route('agents.index')->with('success', 'Agent créé avec succès');
    }

    public function edit(Agent $agent)
    {
        $services = Service::all();
        return view('admin.agents.edit', compact('agent', 'services'));
    }

    public function update(Request $request, Agent $agent)
    {
        $request->validate([
            'name'       => 'required|string|max:255',
            'info'       => 'required|string|max:255',
            'service_id' => 'required|exists:services,id',
        ]);

        $agent->update($request->only('name', 'info', 'service_id'));

        return redirect()->route('agents.index')->with('success', 'Agent mis à jour');
    }

    public function destroy(Agent $agent)
    {
        $agent->delete();

        return redirect()->route('agents.index')->with('success', 'Agent supprimé');
    }
}
