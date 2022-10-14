<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\Equipment;

class EquipmentType extends Model
{
    use HasFactory;
    protected $fillable = ['equipment_type'];

    // public function equipments()
    // {
    //     return $this->hasMany(Equipment::class);
    // }
}