<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    protected $table ='schedules';

    protected $fillable =[
        'user_id',
        'role_id',
        'month_id',
        'year',
        'location_id',
        'desc_job',
        'submitted',
        'voltage',
        'bay_type_id',
        'equipment_out_id',
        'attribute',
        'person_responsible',
        'start_date',
        'end_date',
        'start_hours',
        'end_hours',
        'note',
        'notif',
        'operation_plan',
        'approve_id',
    ];

    public function month()
    {
        return $this->belongsTo('App\Models\Month', 'month_id');
    }

    public function location()
    {
        return $this->belongsTo('App\Models\Location', 'location_id');
    }

    public function bay_type()
    {
        return $this->belongsTo('App\Models\BayType', 'bay_type_id');
    }

    public function equipment_out()
    {
        return $this->belongsTo('App\Models\EquipmentOut', 'equipment_out_id');
    }


  
}
