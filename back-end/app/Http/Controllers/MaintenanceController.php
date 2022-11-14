<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Maintenance;

use App\Http\Requests\BorrowRequest;

use PDF;

use DB;

class MaintenanceController extends Controller
{
    //
    public function index()
    {
        $maintenances = Maintenance::with('request_by', 'served_by', 'office', 'equipment', 'service', 'served_by_3rd_party')->orderBy('id', 'desc')->get();
        return response()->json($maintenances);
    }

    public function show($id)
    {
        $maintenances = Maintenance::with('request_by', 'served_by', 'office', 'equipment', 'service', 'served_by_3rd_party')->where('id', $id)->get();
        return response()->json($maintenances);
    }

    public function store(Request $request)
    {
        $maintenance = new Maintenance([
            'request_by_id' => $request->get('request_by_id'),
            'office_id' => $request->get('office_id'),
            'office_equipment_id' => $request->get('office_equipment_id'),
            'service_id' => $request->get('service_id'),
            'reason' => $request->get('reason'),
            'date_filed' => now()->toDateString(),
        ]);
        $maintenance->save();
        
        return response()->json([
            'status' => true,
            'message' => "Successfully Added",
        ], 200);
    }

    public function update(Request $request, $id)
    {
        $maintenance = Maintenance::find($id);
        
        $maintenance->serve_by_id = $request->get('serve_by_id');
        $maintenance->action_taken = $request->get('action_taken');
        $maintenance->remarks = $request->get('remarks');
        $maintenance->equipment_status = $request->get('equipment_status');
        $maintenance->time_start = $request->get('time_start');
        $maintenance->time_end = $request->get('time_end');
        $maintenance->save();
        
        return response()->json([
            'status' => true,
            'message' => "Successfully Updated Maintenance",
        ], 200);
    }

    public function approval(Request $request, $id)
    {
        $maintenance = Maintenance::find($id);
        
        $maintenance->request_status = $request->get('request_status');
        $maintenance->save();
        
        return response()->json([
            'status' => true,
            'message' => "Successfully Updated Approval",
        ], 200);
    }

    public function served(Request $request, $id)
    {
        $maintenance = Maintenance::find($id);
        
        $maintenance->request_status = 'Served';
        $maintenance->serve_by_id =  $request->get('serve_by_id');
        $maintenance->serve_by_3rd_id =  $request->get('serve_by_3rd_id');
        $maintenance->time_start =  $request->get('time_start');
        $maintenance->time_end =  $request->get('time_end');
        $maintenance->action_taken =  $request->get('action_taken');
        $maintenance->date_served =  $request->get('date_served');
        $maintenance->save();
        
        return response()->json([
            'status' => true,
            'message' => "Successfully Served",
        ], 200);
    }

    public function evaluate(Request $request, $id)
    {
        $maintenance = Maintenance::find($id);
        
        $maintenance->request_status = 'Fulfilled';
        $maintenance->satisfaction =  $request->get('satisfaction');
        $maintenance->remarks =  $request->get('remarks');
        $maintenance->save();
        
        return response()->json([
            'status' => true,
            'message' => "Successfully Evaluated",
        ], 200);
    }

    public function report($startDate, $endDate)
    {
        $maintenances = Maintenance::with('request_by', 'served_by', 'office', 'equipment', 'service')
            ->whereDate('created_at', '>=', $startDate)
            ->whereDate('created_at', '<=', $endDate)
            ->orderBy('id', 'desc')->get();
        return response()->json($maintenances);
    }

    public function generatePDF(BorrowRequest $request)
    {
        $id = $request->get('id');
        $maintenance = Maintenance::with('request_by', 'served_by', 'office', 'equipment', 'service', 'served_by_3rd_party')->find($id);
        $pdf = PDF::loadView('service-form',  $maintenance->toArray());
        return $pdf->download('gen-services-service.pdf');
    }

    public function serviceDashboardStatistics() 
    {
        $services = DB::table('maintenances')
        ->select('request_status', DB::raw('count(request_status) as total'))
        ->groupBy('request_status')
        ->get();
        return response()->json($services);
    }
}
