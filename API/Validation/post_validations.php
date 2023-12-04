<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public function store(Request $request)
    {
        // Request Validation
        $validator = Validator::make($request->all(), [
            'name'      => ['required'],
            'email'     => ['required', 'unique:users,email'],
            'password'  => ['required'],
        ]);
        if ($validator->fails()) {
            // Request Error Pass
            return response()->json($validator->messages(), 400);
        } else {
            // Insert Data    
            $data = [
                'name'      => $request->name,
                'email'     => $request->email,
                'password'  => bcrypt($request->password),
            ];

            DB::beginTransaction(); //Notify that data going to be insert 

            try {
                $user =  User::create($data);
                DB::commit(); //Insert Data
            } catch (\Exception $th) {
                DB::rollBack(); //If any error found it will remove bulk data 
                $user = null; //To verify and respons succsess data
            }
            if ($user != null) {
                return response()->json([
                    'message' => 'User registerd successfully',
                ], 200);
            } else {
                return response()->json([
                    'message' => 'Internal server error',
                ], 500);
            }
        }
    }
}


//Coming soon

//Working well