<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Users;

class UserController extends Controller
{
    public function index()
    {
        // $users = Users::all();
        $users = Users::with('office', 'role', 'account')->get();
        return response()->json($users);
    }

    public function store(Request $request)
    {
        $office_equipment = new Users([
            'designation' => $request->get('designation'),
            'last_name' => $request->get('last_name'),
            'first_name' => $request->get('first_name'),
            'middle_name' => $request->get('middle_name'),
            'suffix' => $request->get('suffix'),
            'office_id' => $request->get('office_id'),
            'role_id' => $request->get('role_id'),
        ]);
        $office_equipment->save();

        return response()->json([
            'status' => true,
            'message' => "Successfully Added",
        ], 200);
    }

    public function update(Request $request, $id)
    {
        $equipment = Users::find($id);
        $equipment->designation = $request->get('designation');
        $equipment->last_name = $request->get('last_name');
        $equipment->first_name = $request->get('first_name');
        $equipment->middle_name = $request->get('middle_name');
        $equipment->suffix = $request->get('suffix');
        $equipment->office_id = $request->get('office_id');
        $equipment->role_id = $request->get('role_id');
        $equipment->save();

        return response()->json([
            'status' => true,
            'message' => "Successfully Updated",
        ], 200);
    }

}
