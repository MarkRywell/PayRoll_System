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
use Illuminate\Support\Facades\RateLimiter;

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

        if(gettype($address) === 'string') return response()->json(['message' => $address], 400);

        $file_path = $request['photo']->store('public/uploads');

        $file_name = str_replace("public/uploads/", "", $file_path);

        $role = 2;

        if($request['position'] == "Clerk") {
            $role = 3;
        }

        $user = User::create([
            'name' => $request['name'],
            'email' => $request['email'],
            'password' => Hash::make($request['password']),
            'position' => $request['position'],
            'address_id' => $address['id'],
            'contact_number' => $request['contact_number'],
            'rate' => $request['rate'],
            'role_id' => $role,
            'status' => true,
            'photo' => $file_name
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

        try {

            if (RateLimiter::tooManyAttempts(request()->ip(), 3)) {
                return response()->json(
                    [ 'message' => 'Too Many Failed Login Attempt. Restricted for 30 Seconds'], 
                );
            }

            if (Auth::attempt($credentials)) {

                $user = $request->user();
    
                $user->tokens()->delete();
                
                $responseData = [
                    'status' => 'success',
                    'message' => 'Successful Login',
                    'data' => [
                        'token' => $user->createToken(Auth::user())->plainTextToken,
                        'user' => $user
                    ]
                ];
                RateLimiter::clear(request()->ip());
                return response($responseData, 200);
            }

            RateLimiter::hit(request()->ip(), 30);
            return response($responseData, 400);
        }
        catch(\Throwable $th) {
            throw $th;
        }
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

        $credentials = request(['email']);

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
