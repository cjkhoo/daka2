<?php

namespace App\Http\Controllers;

use App\Models\Location;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AdminLocationController extends Controller
{
    public function index()
    {
        $locations = Location::where('is_delete', false)->get();
        return view('admin.locations.index', compact('locations'));
    }

    public function create()
    {
        return view('admin.locations.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'loc_name' => 'required|string|max:255',
            'code' => 'required|string|max:50|unique:locations',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after:start_date',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        Location::create([
            'loc_name' => $request->loc_name,
            'code' => $request->code,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'is_delete' => false,
        ]);

        return redirect()->route('admin.locations.index')->with('success', '位置成功創建.');
    }

    public function edit(Location $location)
    {
        return view('admin.locations.edit', compact('location'));
    }

    public function update(Request $request, Location $location)
    {
        $validator = Validator::make($request->all(), [
            'loc_name' => 'required|string|max:255',
            'code' => 'required|string|max:50|unique:locations,code,' . $location->id,
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after:start_date',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $location->update([
            'loc_name' => $request->loc_name,
            'code' => $request->code,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
        ]);

        return redirect()->route('admin.locations.index')->with('success', '位置成功更新');
    }

    public function destroy(Location $location)
    {
        $location->update(['is_delete' => true]);
        return redirect()->route('admin.locations.index')->with('success', '位置成功刪除');
    }
}