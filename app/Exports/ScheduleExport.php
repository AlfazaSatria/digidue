<?php

namespace App\Exports;

use App\Models\Schedule;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ScheduleExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        
        $date = Carbon::now();
        $month=$date->format('m');
        $conv_month= (int)$month;
        $export = Schedule::where('month_id',$conv_month )->get();
        return $export;
    }

    public function headings(): array
    {  
        $date = Carbon::now();
        $title=$date->format('F');
        return [
            ['Lpaoran Jadwal Bulan', $title],
            ['id',
            'month_id',
            'user_id',
            'role_id',
            'year',
            'location_id',
            'desc_job',
            'submitted',
            'voltage',
            'bay_type_id',
            'equipment_out_id',
            'attribute',
            'person_responsibles',
            'start_date',
            'end_date',
            'start_hours',
            'end_hours',
            'note',
            'notif',
            'operation_plan',
            'approve_id',
            'created_at',
            'updated_at',
            'tag']
        ];
    }
}
