<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;



class CustomAdminLoginController extends Controller
{
    public function index()
    {
        return view('admin.home');
    }

    public function showLoginForm()
    {
        return view('admin.login');
    }


      public function login(Request $request)
    {
        $credentials = $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);


        if (Auth::guard('admin')->attempt($credentials)) {
           $user = Auth::guard('admin')->user();
            if ($user->isAdmin()) {
                $request->session()->regenerate();
     
               return redirect()->route('admin.users.index')->with('success', '管理員登入成功');
            } else {

                Auth::guard('admin')->logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();
                return back()->withErrors([
                    'username' => '您沒有管理員權限',
                ]);
            }
        }

        return back()->withErrors([
            'username' => '提供的憑證與我們的記錄不符或您不是管理員.',
        ]);
    }

    public function logout(Request $request)
    {
        Auth::guard('admin')->logout();
        // $request->session()->invalidate();
        // $request->session()->regenerateToken();
        return redirect('/admin/login');
    }
}




