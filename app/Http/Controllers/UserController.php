<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Location;
use App\Models\CheckIn;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function showRegistrationForm()
    {
        return view('web.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        User::create([
            'name' => $request->name,
            'username' => $request->username,
            'user_level' =>3, // default to staff_out
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('login')->with('success', '註冊成功。請登入。');
    }

    public function showLoginForm()
    {
        return view('web.login');
    }

    public function login(Request $request)
    {
        $credentials=$request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);


        if (Auth::guard('web')->attempt($credentials)) {
            $user = Auth::guard('web')->user();
            if ($user->isRegularUser()) {
                $request->session()->regenerate();
               return redirect()->route('checkin')->with('success', '登陸成功.');
            } else {
                Auth::guard('web')->logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();
                return back()->withErrors([
                    'username' => 'You do not have user access.',
                ]);
            }
        }

        return back()->withErrors([
            'username' => '提供的憑證與我們的記錄不符.',
        ]);
    }

    public function logout(Request $request)
    {
        Auth::guard('web')->logout();
        return redirect()->route('login')->with('success', '登出成功');
    }

     public function showChangePasswordForm()
    {
        return view('web.changepass');
    }

    /**
     * Handle the change password request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function changePassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'current_password' => 'required',
            'new_password' => 'required|string|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $user = Auth::user();

        if (!Hash::check($request->input('current_password'), $user->password)) {
            return redirect()->back()->withErrors(['current_password' => 'Current password is incorrect'])->withInput();
        }

        $user->password = Hash::make($request->input('new_password'));
        $user->save();

        return redirect()->route('checkin')->with('status', 'Password changed successfully!');
    }
     public function showChangelocationForm()
    {
         $locations = Location::where('is_delete', false)->get();
         $user = Auth::guard('web')->user();
        return view('web.changeloc', compact('user','locations'));
    }


public function changelocation(Request $request)
{
    // Validate the input to ensure loc_id is provided and valid
    $request->validate([
        'loc_id' => 'required|exists:locations,id', // Ensure the location ID exists in the locations table
    ]);

    // Update the user's location
    $user = auth()->user(); // Assuming the user is authenticated
    $user->loc_id = $request->input('loc_id');
    $user->save();

    // Redirect back with a success message
    return redirect()->route('checkin')->with('status', 'Location changed successfully!');
}

    public function showcheckin()
    {
        
        $user = Auth::guard('web')->user();
       
        $location = Location::find($user->loc_id);
        $currentDateTime = Carbon::now();


        return view('web.checkin', compact('location','user','currentDateTime'));
    }
    public function validatelocation(Request $request){

        Log::info('validatelocation', [
            'latitude' => $request->latitude,
            'longitude' => $request->latitude,
            'latitude' =>  $request->loc_latitude,
            'longitude' => $request->loc_longitude,
        ]);

        $distance = $this->calculateDistance(
            $request->latitude,
            $request->longitude,
            $request->loc_latitude,
            $request->loc_longitude
        );
          Log::info('distance='.$distance);
        $results = [
                'distance' => round($distance, 2), // 保留两位小数
            ];

        return response()->json($results);

    }

    public function checkin(Request $request)
    {
         Log::info('+checkin');

        $user = Auth::guard('web')->user();       
        $location = Location::find($user->loc_id);

        // Calculate distance between user and location
        $distance = $this->calculateDistance(
            $request->latitude,
            $request->longitude,
            $location->latitude,
            $location->longitude
        );

        // 获取当前日期
        $currentDate = Carbon::now();
        $dateFormatted = $currentDate->format('Y-m-d'); // 格式为 'DD/MM/YYYY'


    // Check for existing check-in for this user and date
    $existingCheckIn = CheckIn::where('user_id', $user->id)
                              ->where('date', $dateFormatted)
                              ->first();

    if ($existingCheckIn) {
        return response()->json(['message' => '今天已經簽到'], 409);
    }

        // Log::info('insert checin', [
        //    'user_id' => $user->id,
        //     'loc_id' => $location->id,
        //     'date' => $dateFormatted,
        //     'user_name' => $user->name,
        //     'loc_name' => $location->loc_name,
        //     'loc_latlong' => $location->latitude . ',' . $location->longitude,
        //     'check_in_time' => Carbon::now(),
        //     'check_in_latlong' => $request->latitude . ',' . $request->longitude,
        //     'check_in_distance' => $distance,
        // ]);


   // Prepare check-in data
    $checkInData = [
        'user_id' => $user->id,
        'loc_id' => $location->id,
        'date' => $dateFormatted,
        'user_name' => $user->name,
        'loc_name' => $location->loc_name,
        'loc_latlong' => $location->latitude . ',' . $location->longitude,
        'check_in_time' => Carbon::now(),
        'check_in_latlong' => $request->latitude . ',' . $request->longitude,
        'check_in_distance' => $distance,
    ];

    // Validate that all required fields are present and not empty
    foreach ($checkInData as $key => $value) {
        if (empty($value)) {
            return response()->json(['message' => "字段'$key'不能為空"], 400);
        }
    }

    Log::info('insert checkin', $checkInData);

    // Create and save the new check-in record
    $checkIn = new CheckIn($checkInData);
    $checkIn->save();



        // $checkin->create();

        return response()->json([
            'message' => '上班簽到成功',
            'distance' => $distance,
        ], 200);
    }

public function checkout(Request $request)
{
    Log::info('+checkout');

    // Validate request data
    // $validatedData = $request->validate([
    //     'latitude' => 'required|numeric',
    //     'longitude' => 'required|numeric',
    // ]);

    $user = Auth::guard('web')->user();
    if (!$user) {
        return response()->json(['message' => '用戶未經身份驗證'], 401);
    }

    $location = Location::find($user->loc_id);
    if (!$location) {
        return response()->json(['message' => '未找到用戶位置'], 404);
    }

    // Get current date
    $currentDate = Carbon::now()->format('Y-m-d');

    // Find the existing check-in record for this user and date
    $checkIn = CheckIn::where('user_id', $user->id)
                      ->where('date', $currentDate)
                      ->first();

    if (!$checkIn) {
        return response()->json(['message' => '沒有找到今天的簽到紀錄'], 404);
    }

    // Check if already checked out

    if ($checkIn->check_out_time != null) {
        return response()->json(['message' => '今天已經簽出'], 400);
    }

    // Calculate distance between user and location for checkout
    $checkoutDistance = $this->calculateDistance(
        $request->latitude,
        $request->longitude,
        $location->latitude,
        $location->longitude
    );

    // Prepare checkout data
    $checkoutData = [
        'check_out_time' => Carbon::now(),
        'check_out_latlong' => $request->latitude . ',' . $request->longitude,
        'check_out_distance' => $checkoutDistance,
    ];

    // Update the check-in record with checkout information
    $checkIn->update($checkoutData);

    Log::info('Checkout updated', [
        'user_id' => $user->id,
        'date' => $currentDate,
        'checkout_data' => $checkoutData
    ]);

    return response()->json([
        'message' => '下班簽出成功',
        'distance' => $checkoutDistance,
    ], 200);
}

    private function calculateDistance($lat1, $lon1, $lat2, $lon2)
    {
        // Implement distance calculation logic here
        // This is a simplified version and might not be accurate for your needs
        $earthRadius = 6371; // in kilometers

        $dLat = deg2rad($lat2 - $lat1);
        $dLon = deg2rad($lon2 - $lon1);

        $a = sin($dLat/2) * sin($dLat/2) + cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * sin($dLon/2) * sin($dLon/2);
        $c = 2 * atan2(sqrt($a), sqrt(1-$a));

        return $earthRadius * $c;
    }

}
