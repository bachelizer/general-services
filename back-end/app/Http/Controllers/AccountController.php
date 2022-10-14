<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Account;

use DB;

class AccountController extends Controller
{
    //
    public function login(Request $request)
    {
        $username =  $request->get('username');
        $password =  $request->get('password');

        // $account = Account::select('username')->with('user')->where('username', $username)->where('password', $password)->first();

        $account = DB::table('accounts')
        ->join('users', 'users.id', '=', 'accounts.user_id')
        ->select('accounts.user_id', 'users.*')
        ->where('username', $username)->where('password', $password)->first();

        if($account) {
            return response()->json([
                'authenticated' => true, 
                'data' => $account],
                200);
        }
        else {
            return response()->json([
                'status' => false,
                'message' => "Invalid Account",
            ], 400);
        }
        
    }

    public function store(Request $request)
    {
        $borrows = new Account([
            'username' => $request->get('username'),
            'password' => $request->get('password'),
            'user_id' => $request->get('user_id'),
        ]);
        $borrows->save();
        
        return response()->json([
            'status' => true,
            'message' => "Successfully Added",
        ], 200);
    }
}
