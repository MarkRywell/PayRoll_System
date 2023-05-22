<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Nette\Utils\Json;

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
            'email' => 'required|string|unique:users',
            'password' => 'required|string|min:6',
            'position' => 'required|string',
            'contact_number' => 'required|string',
        ]);
        
        if ($validator->fails()) {
            $responseData['message'] = $validator->errors()->first();
            
            return response()->json($responseData, 400);
        }

        $addressData = [
            'street' => $request['street'],
            'city' => $request['city'],
            'state' => $request['state'],
            'zip_code' => $request['zip_code'],
            'country' => $request['country'],
        ];

        $address = AddressController::store($addressData);


        $user = User::create([
            'name' => $request['name'],
            'email' => $request['email'],
            'password' => Hash::make($request['password']),
            'position' => $request['position'],
            'address_id' => $address['id'],
            'contact_number' => $request['contact_number'],
            'rate' => $request['rate'],
            'role_id' => 2,
            'status' => true
        ]);

        if ($user == null)
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
        $responseData = [
            'status' => 'fail',
            'message' => 'Authentication Failed',
            'data' => null
        ];

        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|string'
        ]);

        
        if ($validator->fails()) {
            $responseData['message'] = $validator->errors()->first();
            return response($responseData, 400);
        }

    
        $credentials = request(['email', 'password']);

        if (Auth::attempt($credentials)) {

            $user = $request->user();

            $user->tokens()->delete();
            
            $responseData = [
                'status' => 'success',
                'message' => 'Successful Login',
                'data' => [
                    'token' => $user->createToken(Auth::user())->plainTextToken,
                ]
            ];

            // print_r (Json::decode($user->tokens[0]->name)->role_id);

            return response($responseData, 200);
        }

        return response($responseData, 400);
    }

    public function logout(Request $request)
    {
        $responseData = [
            'status' => 'fail',
            'message' => 'Unsuccessful Logout',
            'data' => null
        ];

        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
        ]);

        
        if ($validator->fails()) {
            $responseData['message'] = $validator->errors()->first();
            return response($responseData, 400);
        }

        $credentials = request(['email', 'password']);

        $user = User::getUserbyEmail($credentials);

        if(!$user) return response()->json($responseData, 400);

        $user->tokens()->delete();

        $responseData = [
                    'status' => 'success',
                    'message' => 'Successful Logout',
                    'data' => null
                ];

        return response($responseData, 200);

    }




}
