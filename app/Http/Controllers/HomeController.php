<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\Schedule;
use DataTables;


class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {



        $date = Carbon::now()->format('Y-m-d');
        $schedule = Schedule::with('bay_type', 'equipment_out', 'location', 'month')
            ->whereIn('approve_id', [1, 2, 4])
            ->where('start_date', $date)
            ->whereIn('role_id', [1, 2]);

        if (request()->ajax()) {
            return Datatables::of($schedule)
                ->addIndexColumn()
                
                ->make(true);
        }



        return view('home')->with('title', 'Home Dashboard');
    }
}
