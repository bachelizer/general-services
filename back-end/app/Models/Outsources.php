<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Outsources extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = ['institution_name', 'owner'];
}
