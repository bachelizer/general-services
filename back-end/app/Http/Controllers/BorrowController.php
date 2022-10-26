<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Borrow;

use App\Http\Requests\BorrowRequest;

use PDF;

use DB;

class BorrowController extends Controller
{
    public function index()
    {
        $borrows = Borrow::with('borrower', 'approver', 'office', 'equipment')->orderBy('id', 'desc')->get();
        return response()->json($borrows);
    }

    public function show($id)
    {
        $borrows = Borrow::with('borrower', 'approver', 'office', 'equipment')->where('id', $id)->get();
        return response()->json($borrows);
    }

    public function store(Request $request)
    {
        $borrows = new Borrow([
            'borrower_id' => $request->get('request_by_id'),
            'office_id' => $request->get('office_id'),
            'equipment_id' => $request->get('equipment_id'),
            'qty' => $request->get('qty'),
            'purpose' => $request->get('purpose'),
            'date_borrowed' => now()->toDateString(),
            'approval_status' => "Pending"
        ]);
        $borrows->save();
        
        return response()->json([
            'status' => true,
            'message' => "Successfully Added",
        ], 200);
    }

    public function approve(Request $request, $id)
    {
        $borrows = Borrow::find($id);
        
        $borrows->approval_status = 'Approved';
        $borrows->approver_id = $request->get('approver_id');// $request->get('approver_id'); this should take the approver id
        $borrows->save();
        
        return response()->json([
            'status' => true,
            'message' => "Successfully Updated Approval",
        ], 200);
    }

    public function consent(Request $request, $id)
    {
        $borrows = Borrow::find($id);
        
        $borrows->approval_status = 'Consent';
        $borrows->approver_id = $request->get('approver_id');// $request->get('approver_id'); this should take the approver id
        $borrows->save();
        
        return response()->json([
            'status' => true,
            'message' => "Successfully Updated Approval",
        ], 200);
    }

    public function reject(Request $request, $id)
    {
        $borrows = Borrow::find($id);
        
        $borrows->approval_status = 'Rejected';
        $borrows->rejection_remarks = $request->get('rejection_remarks');
        $borrows->approver_id = $request->get('approver_id');// $request->get('approver_id'); this should take the approver id
        $borrows->save();
        
        return response()->json([
            'status' => true,
            'message' => "Request rejected",
        ], 200);
    }

    public function return(Request $request, $id)
    {
        $borrows = Borrow::find($id);
        
        $borrows->approval_status = 'Returned';
        $borrows->date_returned = now()->toDateString();// $request->get('approver_id'); this should take the approver id
        $borrows->save();
        
        return response()->json([
            'status' => true,
            'message' => "Borrow returned",
        ], 200);
    }

    public function report($startDate, $endDate)
    {
        $borrows = Borrow::with('borrower', 'approver', 'office', 'equipment')
            ->whereDate('created_at', '>=', $startDate)
            ->whereDate('created_at', '<=', $endDate)
            ->orderBy('id', 'desc')->get();
        return response()->json($borrows);
    }

    public function generatePDF(BorrowRequest $request)
    {
        $id = $request->get('id');
        $borrows = Borrow::with('borrower', 'approver', 'office', 'equipment')->find($id);
        $pdf = PDF::loadView('borrowForm',  $borrows->toArray());
        return $pdf->download('gen-services-borrow.pdf');
    }

    public function borrowDashBoardStatistics()
    {
        $borrows = DB::table('borrows')
        ->select('approval_status', DB::raw('count(*) as total'))
        ->groupBy('approval_status')
        ->get();
        return response()->json($borrows);
    }
   
}
