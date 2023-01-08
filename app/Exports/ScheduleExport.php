<?php

namespace App\Exports;

use App\Models\Schedule;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ScheduleExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Schedule::all();
    }

    public function headings(): array
    {
        return [
            'id',
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
            'tag'
        ];
    }
}
