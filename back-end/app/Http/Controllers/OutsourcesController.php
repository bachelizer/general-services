<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Outsources;

use App\Http\Requests\OutsourcesRequest;

class OutsourcesController extends Controller
{
    //
    public function index()
    {
        return Outsources::all();
    }

    public function show($id)
    {
        $equipment = Outsources::find($id);
        return response()->json($equipment);
    }

    public function store(OutsourcesRequest $request)
    {
        $equipment = new Outsources([
            'institution_name' => $request->get('institution_name'),
            'owner' => $request->get('owner')
        ]);
        $equipment->save();
        return response()->json(['status' => true,
        'message' => "Successfully Added",
    ], 200);
    }
    
    public function update(Request $request, $id)
    {
        $equipment = Outsources::find($id);
        $equipment->institution_name = $request->get('institution_name');
        $equipment->owner = $request->get('owner');
        $equipment->save();

        return response()->json([
            'status' => true,
            'message' => "Successfully Updated",
        ], 200);
    }
}
