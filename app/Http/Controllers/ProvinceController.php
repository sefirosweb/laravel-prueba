<?php

namespace App\Http\Controllers;

use App\Models\Province;
use App\Models\Town;
use Illuminate\Http\Request;
use App\Http\Requests\ProvinceRequest;

class ProvinceController extends Controller
{
    public function index(Request $request)
    {
        $town = Town::findOrFail($request->towns_id);
        return view('province')->with('town', $town);
    }

    public function getAll(Request $request)
    {
        return Province::where('towns_id',  $request->towns_id)->get();
    }

    public function store(ProvinceRequest $request)
    {
        $province = Province::create($request->all());
        return $province;
    }

    public function update(ProvinceRequest $request)
    {
        $province = Province::findOrFail($request->id);
        $province->update($request->all());
        return $province;
    }

    public function destroy(Request $request)
    {
        $province = Province::findOrFail($request->id);
        $province->delete();
        return response()->json();
    }
}
