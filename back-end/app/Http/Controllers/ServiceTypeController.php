<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Services;

class ServiceTypeController extends Controller
{
    //
    public function index()
    {
        return Services::all();
    }
}
