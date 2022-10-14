<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\OfficeRequest;

use App\Models\Office;

class OfficeController extends Controller
{
    public  function index()
    {
        return Office::all();
    }

    public function show($id)
    {
        $office = Office::find($id);
        return response()->json(['office' => $office]);
    }

    public function officeEquipments()
    {
        $office_equipments = Office::with('equipments')->get();
        return response()->json($office_equipments);
    }


    public function store(Request $request) 
    {
        $office = new Office([
            'office' => $request->get('office')
        ]);
        $office->save();

        return response()->json([
            'status' => true,
            'message' => "Successfully Added",
        ], 200);
    }

    public function update(OfficeRequest $request, $id) 
    {
        $office = Office::find($id);
        $office->office = $request->get('office');
        $office->save();
        
        return response()->json([
            'status' => true,
            'message' => "Successfully Updated",
        ], 200);
    }
}
