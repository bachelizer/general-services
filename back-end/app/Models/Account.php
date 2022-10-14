<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\Users;

class Account extends Model
{
    use HasFactory;
    protected $fillable = ['username', 'password', 'user_id'];

    public function user()
    {
        return $this->hasOne(Users::class, 'id', 'user_id'); // foreign_key, local_key
    }
}
