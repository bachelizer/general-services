<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Borrow extends Model
{
    use HasFactory;
    protected $fillable = ['borrower_id', 'borrower_office_id', 'approver_id', 'office_id', 'equipment_id', 'qty', 'purpose', 'rejection_remarks', 'date_borrowed', 'date_returned', 'approval_status', 'promise_return_date', 'mr_id'];

    public function office()
    {
        return $this->hasOne(Office::class, 'id', 'office_id'); // foreign_key, local_key
    }

    public function equipment()
    {
        return $this->hasOne(OfficeEquipment::class, 'id', 'equipment_id'); // foreign_key, local_key
    }

    public function approver()
    {
        return $this->hasOne(Users::class, 'id', 'approver_id'); // foreign_key, local_key
    }
    public function borrower()
    {
        return $this->hasOne(Users::class, 'id', 'borrower_id'); // foreign_key, local_key
    }
}
