<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Termwind\Components\Dd;

class userController extends Controller
{
    public function index()
    {
        //get data from table posts
        $user = user::latest()->get();
        //make response JSON
        return response()->json([
            'success' => true,
            'message' => 'List Data User',
            'data'    => $user
        ], 200);
    }
    public function show($id)
    {
        //find post by ID
        $user = user::findOrfail($id);

        //make response JSON
        return response()->json([
            'success' => true,
            'message' => 'Detail Data user',
            'data'    => $user
        ], 200);
    }
    public function store(Request $request)
    {
        //set validation
        $validator = Validator::make($request->all(), [
            'name'   => 'required',
            'email'   => 'required',
            'password'   => 'required',
            'position' => 'required',
        ]);

        //response error validation
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        //save to database
        $user = user::create([
            'name'           => $request->name,
            'email'          => $request->email,
            'password'       => bcrypt($request->password),
            'position'   => $request->position,
        ]);

        //success save to database
        if ($user) {

            return response()->json([
                'success' => true,
                'message' => 'Post Created',
                'data'    => $user
            ], 201);
        }

        //failed save to database
        return response()->json([
            'success' => false,
            'message' => 'user Failed to Save',
        ], 409);
    }
    public function update(Request $request, user $user)
    {
        //set validation
        $validator = Validator::make($request->all(), [
            'name'   => 'required',
            'password' => 'required'

        ]);

        //response error validation
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        //find post by ID
        $user = User::findOrFail($user->id);
        if ($user) {

            //update post
            $user->update([
                'name'     => $request->name,
                'password' => bcrypt($request->password)

            ]);

            return response()->json([
                'success' => true,
                'message' => 'Post Updated',
                'data'    => $user
            ], 200);
        }

        //data post not found
        return response()->json([
            'success' => false,
            'message' => 'Post Not Found',
        ], 404);
    }
    public function destroy($id)
    {
        //find post by ID
        $user = user::findOrfail($id);

        if ($user) {

            //delete post
            $user->delete();

            return response()->json([
                'success' => true,
                'message' => 'User Deleted',
            ], 200);
        }

        //data post not found
        return response()->json([
            'success' => false,
            'message' => 'User Not Found',
        ], 404);
    }
}
