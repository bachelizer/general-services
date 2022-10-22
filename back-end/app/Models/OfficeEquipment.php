<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\Office;
use App\Models\Users;
use App\Models\Equipment;

class OfficeEquipment extends Model
{
    use HasFactory;
    protected $fillable = ['office_id', 'user_id', 'equipment_id', 'code', 'serial', 'amount', 'status', 'supplier', 'date_disposed', 'maintained_by', 'maintenance_day', 'action_taken'];

    public function office()
    {
        return $this->hasOne(Office::class, 'id', 'office_id');
    }

    public function custodian()
    {
        return $this->hasOne(Users::class, 'id', 'user_id');
    }

    public function equipment()
    {
        return $this->hasOne(Equipment::class, 'id', 'equipment_id');
    }

   
}
