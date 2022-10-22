<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\OfficeEquipment;

use App\Http\Requests\OfficeEquipmentRequest;

class OfficeEquipmentController extends Controller
{
    //
    public function index()
    {
        $office_equipments = OfficeEquipment::with('office', 'custodian', 'equipment')->get();
        return response()->json($office_equipments);
    }

    public function show($id)
    {
        $office_equipment = OfficeEquipment::with('office', 'custodian', 'equipment')->where('id', $id)->get();
        return response()->json($office_equipment);
    }

    public function store(Request $request)
    {
        $office_equipment = new OfficeEquipment([
            'office_id' => $request->get('office_id'),
            'user_id' => $request->get('user_id'),
            'equipment_id' => $request->get('equipment_id'),
            'code' => $request->get('code'),
            'serial' => $request->get('serial'),
            'amount' => $request->get('amount'),
            'status' => 'working',
            'supplier' => $request->get('supplier'),
            'maintenance_day'  => $request->get('maintenance_day'),
            'days_maintenance' =>  $request->get('maintenance_day'),
        ]);
        $office_equipment->save();

        return response()->json([
            'status' => true,
            'message' => "Successfully Updated",
        ], 200);
    }

    public function regularMaintenanceNotification()
    {
        $office_equipments = OfficeEquipment::with('office', 'custodian', 'equipment')
        ->where('maintenance_day', '<=', 3)
        ->orderBy('maintenance_day', 'asc')->get();
        return response()->json($office_equipments);
    }

    public function regularOfficeEquipmentMaintenance(Request $request, $id) 
    {
        $equipment = OfficeEquipment::find($id);
        
        $equipment->maintained_by =  $request->get('maintained_by');
        $equipment->action_taken =  $request->get('action_taken');
        $equipment->maintenance_day =  $request->get('maintenance_day');
        $equipment->save();
        
        return response()->json([
            'status' => true,
            'message' => "Successfully Updated",
        ], 200);
    }


}
