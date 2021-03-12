<?php

namespace App\Http\Controllers;

use App\Models\Town;
use App\Http\Requests\TownRequest;
use Illuminate\Http\Request;

class TownController extends Controller
{
    public function home()
    {
        return view('home');
    }

    public function index()
    {
        return view('town');
    }

    public function getAll()
    {
        return Town::all();
    }

    public function store(TownRequest $request)
    {
        $Town = Town::create($request->all());
        return $Town;
    }

    public function update(TownRequest $request)
    {
        $town = Town::findOrFail($request->id);
        $town->update($request->all());
        return $town;
    }

    public function destroy(Request $request)
    {
        $town = Town::findOrFail($request->id);
        $town->delete();
        return response()->json();
    }
}
