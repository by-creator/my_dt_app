<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Yard;


class DouaneController extends Controller
{
    public function index(Request $request)
    {

        $user = Auth::user();

        $query = Yard::latest();

        if ($request->filled('item_number')) {
            $query->where('item_number', $request->item_number);
        }

        $yards = $query->paginate(3)->withQueryString();


        $item_numbers = Yard::select('item_number')
            ->distinct()
            ->orderBy('id', 'desc')
            ->pluck('item_number');

        return view('douane.index', compact('yards', 'item_numbers', 'user'));
    }

     public function list(Request $request)
    {
        $request->validate([
            'ordre_id' => 'required|string'
        ]);

        // 🔍 Récupération de l'ordre
        $yard = Yard::where('item_number', $request->yard)->first();
        $user = Auth::user();

        return view('douane.list', compact('yard', 'user'));
    }
}
