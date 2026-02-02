<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\OrdreApproche;


class DouaneController extends Controller
{
    public function index(Request $request)
    {

        $user = Auth::user();

        $query = OrdreApproche::latest();

        if ($request->filled('ItemNumber')) {
            $query->where('ItemNumber', $request->ItemNumber);
        }

        $ordres = $query->paginate(3)->withQueryString();


        $itemNumbers = OrdreApproche::select('ItemNumber')
            ->distinct()
            ->orderBy('id', 'desc')
            ->pluck('ItemNumber');

        return view('douane.index', compact('ordres', 'itemNumbers', 'user'));
    }
}
