<?php

namespace App\Imports;

use App\Models\BayType;
use App\Models\EquipmentOut;
use App\Models\Location;
use App\Models\Schedule;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class ScheduleImport implements ToCollection, WithHeadingRow, WithMultipleSheets
{
    /**
     * @param Collection $collection
     */
    public function sheets(): array
    {
        return [
            'Worksheet' => new ScheduleImport(),
        ];
    }

    public function collection(Collection $rows)
    {
        $carbon = Carbon::now();
        foreach ($rows as $row) {
            $schedule = new Schedule();
            if($row['bulan'] == 'Januari'){
                $schedule->month_id = 1;
            }else if($row['bulan'] == 'Februari'){
                $schedule->month_id = 2;
            }else if($row['bulan'] == 'Maret'){
                $schedule->month_id = 3;
            }
            else if($row['bulan'] == 'April'){
                $schedule->month_id = 4;
            }
            else if($row['bulan'] == 'Mei'){
                $schedule->month_id = 5;
            }
            else if($row['bulan'] == 'Juni'){
                $schedule->month_id = 6;
            }
            else if($row['bulan'] == 'Juli'){
                $schedule->month_id = 7;
            }
            else if($row['bulan'] == 'Agustus'){
                $schedule->month_id = 8;
            }
            else if($row['bulan'] == 'September'){
                $schedule->month_id = 9;
            }
            else if($row['bulan'] == 'Oktober'){
                $schedule->month_id = 10;
            }
            else if($row['bulan'] == 'November'){
                $schedule->month_id = 11;
            }else{
                $schedule->month_id = 12;
            }

            $schedule->user_id =1;
            $schedule->role_id =1;
            $schedule->year= $row['tahun'];

            $schedule->location_id = $row['location_id'];
            $location = Location::firstwhere('id', $row['location_id']);
            if(!$location){
                $location = new Location();
                $location->id = $row['location_id'];
                $location->name = $row['location'];
                $location->save();
            }

            $schedule->desc_job = $row['deskripsi'];
            $schedule->voltage = $row['voltage'];
            
            $schedule->bay_type_id = $row['bay_type_id'];
            $bay = BayType::firstwhere('id', $row['bay_type_id']);
            if(!$bay){
                $bay = new BayType();
                $bay->id = $row['bay_type_id'];
                $bay->location_id = $row['location_id'];
                $bay->name = $row['jenis_bay'];
                $bay->save();
            }
            $schedule->equipment_out_id = $row['equipment_out_id'];
            $equipment = EquipmentOut::firstwhere('id', $row['equipment_out_id']);
            if(!$equipment){
                $equipment = new EquipmentOut();
                $equipment->id = $row['equipment_out_id'];
                $equipment->bay_type_id = $row['bay_type_id'];
                $equipment->name = $row['peralatan_padam'];
                $equipment->save();
            }

            $schedule->attribute = $row['attribute'];
            $schedule->person_responsibles = $row['person_responsible'];
            $schedule->start_date = $row['start_date'];
            $schedule->end_date = $row['end_date'];
            $schedule->start_hours = $row['start_hours'];
            $schedule->end_hours = $row['end_hours'];
            $schedule->note = $row['note'];
            $schedule->notif= $row['notif'];
            $schedule->operation_plan = $row['operation_plan'];
            $schedule->approve_id = 4;
            $schedule->save();

            
            
        }
    }
}
