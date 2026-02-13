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

    public function datalist(Request $request)
    {
        $field = $request->get('field'); 
        $query = $request->get('q');

        // 🔐 Sécurité : champs autorisés
        if (!in_array($field, ['item_number' ])) {
            return response()->json([]);
        }

        $results = Yard::query()
            ->whereNotNull($field)
            ->when(
                $query,
                fn($q) =>
                $q->where($field, 'LIKE', "%{$query}%")
            )
            ->distinct()
            ->limit(10) // ⚡ limite pour perf
            ->pluck($field);

        return response()->json($results);
    }
    
}
