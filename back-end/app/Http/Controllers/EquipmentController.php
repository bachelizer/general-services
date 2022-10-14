<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Equipment;
use App\Models\EquipmentType;

use App\Http\Requests\EquipmentRequest;

class EquipmentController extends Controller
{
    public function index()
    {
        return Equipment::all();
    }

    public function show($id)
    {
        $equipment = Equipment::find($id);
        return response()->json($equipment);
    }

    public function store(EquipmentRequest $request)
    {
        $equipment = new Equipment([
            'equipment' => $request->get('equipment')
        ]);
        $equipment->save();
        return response()->json('Successfully Added');
    }
    
    public function update(Request $request, $id)
    {
        $equipment = Equipment::find($id);
        $equipment->equipment = $request->get('equipment');
        $equipment->save();

        return response()->json([
            'status' => true,
            'message' => "Successfully Updated",
        ], 200);
    }

}
