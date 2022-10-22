<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Inventory;

class InventoryController extends Controller
{
    //
    public function index()
    {
        return Inventory::all();
    }

    public function show($id)
    {
        $inventory = Inventory::find($id);
        return response()->json($inventory);
    }

    public function store(Request $request)
    {
        $inventory = new Inventory([
            'inventory_name' => $request->get('inventory_name'),
            'name' => $request->get('name'),
            'unit' => $request->get('unit'),
            'base_stock' => $request->get('base_stock'),
            'available_stock' => $request->get('base_stock'),
        ]);
        $inventory->save();
        
        return response()->json([
            'status' => true,
            'message' => "Successfully addded",
        ], 200);
    }

    public function replenish(Request $request, $id)
    {
        $inventory = Inventory::find($id);
        
        $inventory->available_stock = $request->get('base_stock');
        $inventory->base_stock = $request->get('base_stock');
        $inventory->save();
        
        return response()->json([
            'status' => true,
            'message' => "Successfully replenished",
        ], 200);
    }

    public function despense(Request $request, $id)
    {
        $inventory = Inventory::find($id);
        
        $inventory->available_stock = $request->get('request_stock');
        $inventory->save();
        
        return response()->json([
            'status' => true,
            'message' => "Successfully despense",
        ], 200);
    }

}
