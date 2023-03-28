<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{

    public function register(Request $request)
    {
        $responseData = [
            'status' => 'fail',
            'message' => '',
            'data' => null
        ];
      
        
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'email' => 'required|string|unique:employees',
            'password' => 'required|string|min:6',
        ]);
        
        if ($validator->fails()) {
            $responseData['message'] = $validator->errors()->first();
            
            return response()->json($responseData, 400);
        }

        

        $employee = Employee::create([
            'name' => $request['name'],
            'email' => $request['email'],
            'password' => Hash::make($request['password']),
            'role' => 'Employee',
            'status' => true
        ]);

        if ($employee == null)
        {   
            $responseData['message'] = 'Unsuccessful Registration';
            return response()->json($responseData, 400);
        }
        
        $responseData['status'] = 'success';
        $responseData['message'] = 'Successful Registration';

        return response()->json($responseData, 201);
    }

    public function login(Request $request)
    {
        
    }





}
