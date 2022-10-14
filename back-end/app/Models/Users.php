<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\Office;
use App\Models\Role;

class Users extends Model
{
    use HasFactory;
    public $timestamps = true;
    protected $fillable = ['designation', 'last_name', 'first_name', 'middle_name', 'suffix', 'office_id', 'role_id'];

    public function office()
    {
        return $this->hasOne(Office::class, 'id', 'office_id'); // foreign_key, local_key
    }

    public function role()
    {
        return $this->hasOne(Role::class, 'id', 'role_id'); // foreign_key, local_key
    }

    public function account()
    {
        return $this->hasOne(Account::class, 'user_id', 'id');
    }
  
}
