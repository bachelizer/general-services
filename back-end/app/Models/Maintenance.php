<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\Users;
use App\Models\Office;
use App\Models\Equipment;
use App\Models\Services;

class Maintenance extends Model
{
    use HasFactory;
    protected $fillable = ['request_status', 'request_by_id', 'serve_by_id', 'office_id', 'office_equipment_id', 'service_id', 'reason', 'action_taken', 'remarks', 'equipment_status', 'date_filed', 'time_start', 'time_end'];

    public function request_by()
    {
        return $this->hasOne(Users::class, 'id', 'request_by_id'); // foreign_key, local_key
    }
    
    public function served_by()
    {
        return $this->hasOne(Users::class, 'id', 'serve_by_id'); // foreign_key, local_key
    }

    public function office()
    {
        return $this->hasOne(Office::class, 'id', 'office_id'); // foreign_key, local_key
    }

    public function equipment()
    {
        return $this->hasOne(Equipment::class, 'id', 'office_equipment_id'); // foreign_key, local_key
    }

    public function service()
    {
         return $this->hasOne(Services::class, 'id', 'service_id'); 
    }
}
