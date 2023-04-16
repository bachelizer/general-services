<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\EquipmentType;

class Equipment extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'equipments';
    protected $fillable = ['equipment', 'maintenance_interval'];
}
