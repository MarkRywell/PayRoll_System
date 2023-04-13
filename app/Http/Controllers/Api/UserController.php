<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
    public function show(User $user)
    {
        
    }

    public function getUser(int $role_id)
    {
        $responseData = [
            'status' => 'fail',
            'message' => 'User not found',
            'data' => null
        ];


        $user = User::get(['id', 'name', 'email', 'role_id', 'photo'])->where('role_id', $role_id);
        
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

    public function update(Request $request, int $id)
    {
        $responseData = [
            'status' => 'fail',
            'message' => '',
            'data' => null
        ];

        $response = DB::table('users')
        ->where('id', $id)
        ->update([
            'name' => $request['name'],
            'photo' => $request['photo']
        ]);

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