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
        return $responseData;
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
        return $responseData;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        //
    }
}
