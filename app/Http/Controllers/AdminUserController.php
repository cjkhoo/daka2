<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Location;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminUserController extends Controller
{
    public function index()
    {
        $users = User::leftJoin('locations', 'users.loc_id', '=', 'locations.id')
            ->select('users.*', 'locations.loc_name', 'locations.code')
            ->where('users.is_delete', 0)
            // ->where('users.user_level', '!=', 1)
            ->paginate(10);

        return view('admin.users.index', compact('users'));
    }

    public function create()
    {
        $locations = Location::all();
        return view('admin.users.create', compact('locations'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255',
            'password' => 'required|string|min:8',
            'loc_id' => 'nullable|exists:locations,id',
            'user_level' => 'required|integer|in:2,3',
            
        ]);

        User::create([
            'name' => $validated['name'],
            'username' => $validated['username'],            
            'password' => Hash::make($validated['password']),
            'loc_id' => $validated['loc_id'],
            'user_level' => $validated['user_level'],
        ]);

        return redirect()->route('admin.users.index')->with('success', 'User created successfully.');
    }

 public function edit($id)
    {
        // Find the user by ID
        $user = User::findOrFail($id);

        // Get all active locations for the dropdown
        $locations = Location::where('is_delete', 0)
                             // ->where('end_date', '>=', now())
                             // ->orWhereNull('end_date')
                             ->get();

        // Get user levels for the dropdown (you might want to adjust this based on your needs)
        $userLevels = [
            '1' => 'Admin',
            '2' => 'indoor',
            '3' => 'outdoor',
        ];

        return view('admin.users.edit', compact('user', 'locations', 'userLevels'));
    }

public function update(Request $request, $id)
    {

        $user = User::findOrFail($id);

        $validatedData = $request->validate([
            'username' => 'required|string|max:255|unique:users,username,'.$id,
            'name' => 'required|string|max:255',
            'loc_id' => 'nullable|exists:locations,id',
            'user_level' => 'required|integer|in:1,2,3',
        ]);

        $user->username = $request->username;
        $user->name = $validatedData['name'];
        $user->loc_id = $validatedData['loc_id'];
        $user->user_level = $validatedData['user_level'];
         if (!empty($request->password)) {
        $user->password = Hash::make($request->password);
        }

  
      
        $user->save();

        return redirect()->route('admin.users.index')->with('success', 'User updated successfully');
    }

    public function destroy(Request $request, $id)
    {

        $user = User::findOrFail($id);

        $user->is_delete = 1;

  
      
        $user->save();

        //$user->delete();
        return redirect()->route('admin.users.index')->with('success', 'User deleted successfully.');
    }
}