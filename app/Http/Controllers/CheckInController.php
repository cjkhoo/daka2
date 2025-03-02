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
use App\Exports\CheckInsExport;
use App\Exports\CheckInsExportAll; 
use Maatwebsite\Excel\Facades\Excel;

class CheckInController extends Controller
{
	   public function index(Request $request)
    {
        Log::Debug('index');

        // Apply filters
    

        $selectedMonth = $request->input('date', Carbon::now()->format('Y-m'));
        
        $months = [
            Carbon::now()->format('Y-m'),
            Carbon::now()->subMonth()->format('Y-m'),
            Carbon::now()->subMonths(2)->format('Y-m')
        ];


        // if ($request->filled('year') && $request->filled('user_name')) {
        //     $query->whereYear('date', $request->year)
        //           ->whereMonth('date', $request->month);
        // }

        if ($request->filled('date') && $request->filled('user_id')) {

          $attendances = CheckIn::where('user_id',$request->user_id)
            ->whereYear('date', substr($selectedMonth, 0, 4))
            ->whereMonth('date', substr($selectedMonth, 5, 2))
            ->where('is_delete',0)
            ->orderBy('date', 'desc')
            ->with('user') // Eager load the user relationship
            ->get();



        }
        else{
        	$attendances =[];
        }

        // $attendances = $query->orderBy('date', 'desc');
        $users = User::where('is_delete', 0)
             ->where('user_level', '!=', 1)
             ->get();

        return view('admin.reports.checkin', compact('attendances', 'users'));
    }

    public function showCheckinList(Request $request)
    {
        $user = Auth::guard('web')->user();
        $selectedMonth = $request->input('month', Carbon::now()->format('Y-m'));
        
         $months = [];
    for ($i = 0; $i <3; $i++) {
        $months[] = Carbon::now()->subMonths($i)->format('Y-m');
    }
        
        $checkins = CheckIn::where('user_id', $user->id)
            ->whereYear('date', substr($selectedMonth, 0, 4))
            ->whereMonth('date', substr($selectedMonth, 5, 2))
            ->orderBy('date', 'desc')
            ->get();
        
        return view('web.checkin_list', compact('checkins', 'months', 'selectedMonth','user'));
    }



	public function destroy(Request $request)
	{
		  Log::Debug('destroy');
	    $user_id = $request->user_id;
	    $selectedMonth = $request->input('date', Carbon::now()->format('Y-m'));

	    try {
	        \DB::beginTransaction();

	        $affectedRows = CheckIn::where('user_id', $user_id)
	            ->whereYear('date', substr($selectedMonth, 0, 4))
	            ->whereMonth('date', substr($selectedMonth, 5, 2))
	            ->update(['is_delete' => 1]);

	        \DB::commit();

	        if ($affectedRows > 0) {
	            return redirect()->back()->with('success', '記錄刪除成功');
	        } else {
	            return redirect()->back()->with('info', '沒有找到要刪除的記錄。');
	        }
	    } catch (\Exception $e) {
	        \DB::rollBack();
	        return redirect()->back()->with('error', '刪除記錄時發生錯誤: ' . $e->getMessage());
	    }
	}

    public function export(Request $request)
    {
        $user_id = $request->user_id;
        $name = User::where('id', $user_id)->value('name');
        $selectedMonth = $request->input('date', Carbon::now()->format('Y-m'));
        $year = substr($selectedMonth, 0, 4);
        $month = substr($selectedMonth, 5, 2);

        return Excel::download(new CheckInsExport($user_id, $year, $month), $name.'-'.$month.'.xlsx');
    }



       public function exportall(Request $request)
    {
    
        $selectedMonth = $request->input('date', Carbon::now()->format('Y-m'));
        $year = substr($selectedMonth, 0, 4);
        $month = substr($selectedMonth, 5, 2);

        return Excel::download(new CheckInsExportAll( $year, $month), $month.'.xlsx');
    }
}