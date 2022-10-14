<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\OfficeEquipment;

class Office extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = ['office'];

    public function equipments()
    {
        return $this->hasMany(OfficeEquipment::class, 'office_id', 'id');
    }
}
