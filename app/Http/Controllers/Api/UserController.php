<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return User::all();
    }

    public function archives()
    {
        return User::onlyTrashed()->orderBy('deleted_at', 'desc')->get();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request)
    {
        $responseData = [
            'status' => 'fail',
            'message' => 'User not found',
            'data' => null
        ];

        $user = User::find();
    }

    public function getUser(Request $request)
    {
        $responseData = [
            'status' => 'fail',
            'message' => 'User not found',
            'data' => null
        ];

        $user = $request->user();
        
        if($user->role_id == 1) {
            $user = User::get(['id', 'name', 'email', 'position', 'contact_number', 'role_id', 'photo']);
        }
        else {
            $user = $user->only(['id', 'name', 'email', 'position', 'contact_number', 'role_id', 'photo']);
        }
        
        if($user)
        {
            $responseData = [
                'status' => 'success',
                'message' => 'User retrieved succesfully',
                'data' => $user
            ];

            return response($responseData, 200);
        }
        return response($responseData, 404);
    }

    /**
     * Update the specified resource in storage.
     */

    public function addPhoto(Request $request, int $id)
    {
        $responseData = [
            'status' => 'fail',
            'message' => '',
            'data' => null
        ];

        $file_path = $request['photo']->store('public/uploads');
        $file_name = str_replace("public/uploads/", "", $file_path);


        $response = DB::table('users')
        ->where('id', $id)
        ->update([
            'photo' => $file_name
        ]);

        if($response != null)
        {
            $responseData['status'] = 'success';
            $responseData['message'] = 'Profile Photo Added';
            $responseData['data'] = $file_name;
            return response()->json($responseData, 200);
        }
        
        $responseData['message'] = 'Photo Upload Unsuccessful';
        return response($responseData);
    }

    public function getRate(int $id)
    {
        $rate = User::getRate($id);
        return $rate;
    }

    public function getPhoto($photo)
    {
        return response()->file(storage_path("app/public/uploads/$photo"));
    }

    public function updateRate(Request $request, int $id)
    {   
        $validator = Validator::make($request->all(), [
            'rate' => 'required|numeric'
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()->first()], 400);
        }

        $response = User::updateRate($request->all(), $id);

        if(!$response) {
            return response()->json(['message' => "Rate Update Fail"], 500);
        }

        return response()->json(['message' => "Rate Updated"], 200);
    }

    public function updateUser(Request $request, int $id)
    {
        $responseData = [
            'status' => 'fail',
            'message' => '',
            'data' => null
        ];

        $validator = Validator::make($request->all(), [
            'name' => 'string',
            'password' => 'string',
            'contact_number' => 'string',
            'position' => 'string',
        ]);

        if ($validator->fails()) {
            $responseData['message'] = $validator->errors()->first();
            
            return response()->json($responseData, 400);
        }

        $request['password'] = Hash::make($request['password']);

        $data = array_filter($request->all());

        $response = User::where('id', $id)->update($data);

        if($response != null)
        {
            $responseData['status'] = 'success';
            $responseData['message'] = 'Update Successful';
            return response()->json($responseData, 200);
        }
        
        $responseData['message'] = 'Update Unsuccessful';
        return response($responseData);
    }

    public function update(Request $request, int $id)
    {
        $responseData = [
            'status' => 'fail',
            'message' => '',
            'data' => null
        ];

        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'password' => 'required|string|min:6',
        ]);
        
        if ($validator->fails()) {
            $responseData['message'] = $validator->errors()->first();
            
            return response()->json($responseData, 400);
        }

        $request['password'] = Hash::make($request['password']);

        $data = array_filter($request->all());

        $response = User::where('id', $id)->update($data);

        if($response != null)
        {
            $responseData['status'] = 'success';
            $responseData['message'] = 'Update Successful';
            return response()->json($responseData, 200);
        }
        
        $responseData['message'] = 'Update Unsuccessful';
        return response($responseData);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {
        $responseData = [
            'status' => 'fail',
            'message' => 'User not found',
            'data' => null
        ];

        
        $user = User::withTrashed()->find($id);

        if($user)
        {
            if($user->trashed())
            {
                $user->forceDelete();
                $responseData = [
                    'status' => 'success',
                    'message' => 'User successfully Deleted!',
                    'data' => null
                ];

                return response($responseData, 200);
                
            }
            User::where('id', $id)->update(['status' => false]);
            $status = $user->delete();
            if($status) {
                $responseData = [
                    'status' => 'success',
                    'message' => 'User successfully Soft Deleted!',
                    'data' => null
                ];
    
                return response($responseData, 200);
            }
            $responseData['message'] = 'Soft Delete Unsuccessful';
        }
        return response($responseData, 400);
    }

    public function restore(int $id)
    {
        $responseData = [
            'status' => 'fail',
            'message' => 'User not found',
            'data' => null
        ];
        
        $user = User::withTrashed()->find($id);
        
        if($user)
        {   
            $user->restore();
            User::where('id', $id)->update(['status' => true]);
            $responseData['status'] = 'success';
            $responseData['message'] = 'User successfully Restored';
            return response($responseData, 200);
        }

        return response($responseData, 404);
    }
}