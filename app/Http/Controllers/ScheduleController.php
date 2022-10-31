<?php

namespace App\Http\Controllers;

use App\Exports\ScheduleExport;
use App\Models\BayType;
use App\Models\Attributes;
use App\Models\EquipmentOut;
use App\Models\Location;
use App\Models\Month;
use App\Models\RevisionSchedule;
use App\Models\Schedule;
use App\User;
use Illuminate\Http\Request;
use DataTables;
use Exception;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;

class ScheduleController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }


    public function dataSchedule()
    {
        $schedule = Schedule::with('bay_type', 'equipment_out', 'location', 'month')
            ->whereIn('approve_id', [1,2,4])
            ->whereIn('role_id', [1, 2]);

        if (request()->ajax()) {
            return Datatables::of($schedule)
                ->addIndexColumn()
                ->addColumn('approve', function ($schedule) {
                    $btn = '<a> - </a>';;

                    return $btn;
                })
                ->addColumn('action', function ($schedule) {
                    $button = '<button id="delete" class="btn  btn-danger" data-id="' . $schedule->id . '">Delete</button>';
                    return $button;
                })
                ->rawColumns(['approve', 'action'])
                ->make(true);
        }
        return view('admin.schedule.index')->with('title', 'Jadwal');
    }

    public function dataRevisionSchedule()
    {
        $schedule = RevisionSchedule::with('bay_type', 'equipment_out', 'location', 'month')
            ->where('approve_id', '=', 3)
            ->where('role_id', 3);

        if (request()->ajax()) {
            return Datatables::of($schedule)
                ->addIndexColumn()
                ->addColumn('approve', function ($schedule) {
                    if ($schedule->approve_id == 1) {
                        $btn = '<a class="btn btn-sm btn-danger" >Disetujui</a>';;
                    } else if ($schedule->approve_id == 3) {
                        $btn = '<button id="changestatus" class="btn btn-sm btn-success" data-id="' . $schedule->id . '">Setujui</button>';;
                        $btn .= '<button id="changeapprove" class="btn btn-sm btn-danger text" data-id="' . $schedule->id . '">Tolak</button>';;
                    } else {
                        $btn = '<a class="btn btn-sm btn-danger" >Ditolak</a>';;
                    }
                    return $btn;
                })
                ->addColumn('action', function ($schedule) {
                    $button = '<button id="delete" class="btn  btn-danger" data-id="' . $schedule->id . '">Delete</button>';
                    return $button;
                })
                ->rawColumns(['approve', 'action'])
                ->make(true);
        }
        return view('admin.schedule.indexRevision')->with('title', 'Jadwal Pengajuan');
    }

    public function dataScheduleULTG()
    {
        $schedule = Schedule::with('bay_type', 'equipment_out', 'location', 'month');

        if (request()->ajax()) {
            return Datatables::of($schedule)
                ->addIndexColumn()
                ->addColumn('approve', function ($schedule) {
                    if ($schedule->approve_id == 1) {
                        $btn = '<a class="btn btn-sm btn-success text-light" >Pengajuan Disetujui</a>';
                    } else if($schedule->approve_id == 2) {
                        $btn = '<a class="btn btn-sm btn-danger text-light" >Pengajuan Ditolak</a>';
                    }else if($schedule->submitted != 0) {
                        $btn = '<a >Proses Pengajuan</a>';
                    }else{
                        $btn = '<a  > - </a>';
                    }
                    return $btn;
                })
                ->addColumn('action', function ($schedule) {
                    if($schedule->submitted != 0){
                        $button = '<a>-</a>';
                    }else{
                        $button = '<a href="' . route('schedule.show.update.revision', $schedule->id) . '" class="btn btn-sm btn-success">Ajukan Revisi</a>';
                    }
                    
                    return $button;
                })
                ->rawColumns(['approve', 'action'])
                ->make(true);
        }
        return view('admin.schedule.indexULTG')->with('title', 'Jadwal ULTG');
    }

    public function showUpdateSumbittedSchedule($id){
        $schedule = Schedule::firstwhere('id', $id);
        $month= Month::firstwhere('id', $schedule->month_id);
        $location = Location::firstwhere('id', $schedule->location_id);
        $bay_type = BayType::firstwhere('id', $schedule->bay_type_id);
        $equipment_out= EquipmentOut::firstwhere('id', $schedule->equipment_out_id);

        return view('admin.schedule.submittedSchedule')->with('schedule', $schedule)->with('month', $month)->with('location', $location)
        ->with('bay_type', $bay_type)->with('equipment_out', $equipment_out);
    }

    public function updateSubmittedSchedule(Request $request, $id){
        try{
            $schedule= Schedule::firstwhere('id', $id);

            $revision = new RevisionSchedule ();
            $revision->schedule_id = $schedule['id'];
            $revision->month_id = $schedule['month_id'];
            $revision->user_id = $schedule['user_id'];
            $revision->role_id = 3;
            $revision->year = $schedule['year'];
            $revision->location_id = $schedule['location_id'];
            $revision->desc_job = $schedule['desc_job'];
            $revision->voltage = $schedule['voltage'];
            $revision->bay_type_id = $schedule['bay_type_id'];
            $revision->equipment_out_id = $schedule['equipment_out_id'];
            $revision->attribute = $schedule['attribute'];
            $revision->person_responsibles = $schedule['person_responsibles'];
            $revision->start_date = $request['start_date'];
            $revision->end_date = $request['end_date'];
            $revision->start_hours = $request['start_hours'];
            $revision->end_hours = $request['end_hours'];
            $revision->note = $schedule['note'];
            $revision->approve_id = 3;
            $revision->notif = $schedule['notif'];
            $revision->operation_plan = $schedule['operation_plan'];
            $revision->save();

            $schedule->submitted = 1;
            $schedule->save();

            return response()->json([
                'status' => 200,
                'message' => 'success add data'
            ]);
      }catch(Exception $err){
            return response()->json([
                'status'=> 500,
                'error' => $err->getMessage()
            ]);
        }
    }



    public function dataScheduleROB()
    {
        $schedule = Schedule::with('bay_type', 'equipment_out', 'location', 'month')->whereIn('operation_plan', ['ROB','ROM','ROH'])->get();
        if (request()->ajax()) {
            return Datatables::of($schedule)
                ->addIndexColumn()
                ->addColumn('approve', function ($schedule) {
                    if ($schedule->approve_id == 1) {
                        $btn = '<a class="btn btn-sm btn-danger" >Disetujui</a>';;
                    } else if ($schedule->approve_id == 4) {
                        $btn = '<a> - </a>';;
                    } else if ($schedule->approve_id == 3) {
                        $btn = '<button id="changestatus" class="btn btn-sm btn-danger" data-id="1">Setujui</button>';;
                        $btn .= '<button id="changestatus" class="btn btn-sm btn-danger" data-id="2">Tolak</button>';;
                    } else {
                        $btn = '<a class="btn btn-sm btn-danger" >Ditolak</a>';;
                    }
                    return $btn;
                })
                ->addColumn('action', function ($schedule) {
                    $button = '<button id="delete" class="btn  btn-danger" data-id="' . $schedule->id . '">Delete</button>';
                    return $button;
                })
                ->rawColumns(['approve', 'action'])
                ->make(true);
        }
        return view('admin.schedule.indexROB')->with('title', 'Jadwal');
    }

    public function dataScheduleROM()
    {
        $schedule = Schedule::with('bay_type', 'equipment_out', 'location', 'month')->whereIn('operation_plan', ['ROM','ROH']);
        if (request()->ajax()) {
            return Datatables::of($schedule)
                ->addIndexColumn()
                ->addColumn('approve', function ($schedule) {
                    if ($schedule->approve_id == 1) {
                        $btn = '<a class="btn btn-sm btn-danger" >Disetujui</a>';;
                    } else if ($schedule->approve_id == 4) {
                        $btn = '<a> - </a>';;
                    } else if ($schedule->approve_id == 3) {
                        $btn = '<button id="changestatus" class="btn btn-sm btn-danger" data-id="1">Setujui</button>';;
                        $btn .= '<button id="changestatus" class="btn btn-sm btn-danger" data-id="2">Tolak</button>';;
                    } else {
                        $btn = '<a class="btn btn-sm btn-danger" >Ditolak</a>';;
                    }
                    return $btn;
                })
                ->addColumn('action', function ($schedule) {
                    $button = '<button id="delete" class="btn  btn-danger" data-id="' . $schedule->id . '">Delete</button>';
                    return $button;
                })
                ->rawColumns(['approve', 'action'])
                ->make(true);
        }
        return view('admin.schedule.indexROM')->with('title', 'Jadwal');
    }

    public function dataScheduleROH()
    {
        $schedule = Schedule::with('bay_type', 'equipment_out', 'location', 'month')->where('operation_plan', '=', 'ROH');
        if (request()->ajax()) {
            return Datatables::of($schedule)
                ->addIndexColumn()
                ->addColumn('approve', function ($schedule) {
                    if ($schedule->approve_id == 1) {
                        $btn = '<a class="btn btn-sm btn-danger" >Disetujui</a>';;
                    } else if ($schedule->approve_id == 4) {
                        $btn = '<a> - </a>';;
                    } else if ($schedule->approve_id == 3) {
                        $btn = '<button id="changestatus" class="btn btn-sm btn-danger" data-id="1">Setujui</button>';;
                        $btn .= '<button id="changestatus" class="btn btn-sm btn-danger" data-id="2">Tolak</button>';;
                    } else {
                        $btn = '<a class="btn btn-sm btn-danger" >Ditolak</a>';;
                    }
                    return $btn;
                })
                ->addColumn('action', function ($schedule) {
                    $button = '<button id="delete" class="btn  btn-danger" data-id="' . $schedule->id . '">Delete</button>';
                    return $button;
                })
                ->rawColumns(['approve', 'action'])
                ->make(true);
        }
        return view('admin.schedule.indexROH')->with('title', 'Jadwal');
    }

    public function showAddSchedule()
    {

        $locations = Location::all();
        $months = Month::all();

        return view('admin.schedule.addschedule')->with('title', 'Tambah Jadwal')->with('locations', $locations)->with('months', $months);
    }

    public function showAddBayType($id)
    {
        $bay_type = BayType::where('location_id', $id)->pluck("name", "id");

        return json_encode($bay_type);
    }

    public function showAddEquipmentOut($id)
    {
        $equipment_out = EquipmentOut::where("bay_type_id", $id)->pluck("name", "id");;

        return json_encode($equipment_out);
    }

    public function addSchedule(Request $request)
    {
        try {
            $schedule = new Schedule();
            $schedule->month_id = $request['month_id'];
            $schedule->user_id = $request['user_id'];
            $role = User::firstwhere('id', $request['user_id']);
            $schedule->role_id = $role['role_id'];
            $schedule->year = $request['year'];
            $schedule->location_id = $request['location_id'];
            $schedule->desc_job = $request['desc_job'];
            $schedule->voltage = $request['voltage'];
            $schedule->bay_type_id = $request['bay_type_id'];
            $schedule->equipment_out_id = $request['equipment_out_id'];
            $schedule->attribute = $request['attribute'];
            $schedule->person_responsibles = $request['person_responsibles'];
            $schedule->start_date = $request['start_date'];
            $schedule->end_date = $request['end_date'];
            $schedule->start_hours = $request['start_hours'];
            $schedule->end_hours = $request['end_hours'];
            $schedule->note = $request['note'];
            $schedule->approve_id = 4;
            $schedule->notif = $request['notif'];
            $schedule->operation_plan = $request['operation_plan'];
            $schedule->save();

            return response()->json([
                'status' => '200',
                'message' => 'Success add data',
            ]);
        } catch (Exception $err) {
            return response()->json([
                'status' => '500',
                'error' => $err->getMessage()
            ], 500);
        }
    }

    public function destroy($id){
        try{
            $schedule = Schedule::firstwhere('id', $id);

            $schedule->delete();
            
            return response()->json([
                'status' => '200',
                'message' => 'Success Delete Data'
            ]);
        }catch(Exception $err){
            return response()->json([
                'status' => '500',
                'message' => $err->getMessage() 
            ]);
        }
    }

    public function acceptSchedule($id){
        try{
            $Revschedule = RevisionSchedule::firstwhere('id', $id);
            $schedule = Schedule::firstwhere('id',$Revschedule['schedule_id']);

            $schedule->operation_plan = $Revschedule['operation_plan'];
            $schedule->start_date = $Revschedule['start_date'];
            $schedule->end_date = $Revschedule['end_date'];
            $schedule->start_hours= $Revschedule['start_hours'];
            $schedule->end_hours= $Revschedule['end_hours'];
            $schedule->approve_id = 1;
            $schedule->save();

            $Revschedule->approve_id = 1;
            $Revschedule->save();

            return response()->json([
                'status' => '200',
                'message' => $Revschedule
            ]);
        }catch(Exception $err){
            return response()->json([
                'status' => '500',
                'message' => $err->getMessage()
            ]);
        }
    }

    public function declineSchedule($id){
        try{
            $Revschedule = RevisionSchedule::firstwhere('id', $id);
            $schedule = Schedule::firstwhere('id',$Revschedule['schedule_id']);

            $schedule->approve_id = 2;
            $schedule->save();
            $Revschedule->approve_id=2;
            $Revschedule->save();
            
            return response()->json([
                'status' => '200',
                'message' => 'Success Update Data'
            ]);
        }catch(Exception $err){
            return response()->json([
                'status' => '500',
                'message' => $err->getMessage() 
            ]);
        }
    }

    public function export_excel()
	{
		return Excel::download(new ScheduleExport, 'schedule.xlsx');
	}
}
