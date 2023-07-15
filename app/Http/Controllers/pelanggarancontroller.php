<?php

namespace App\Http\Controllers;

use App\Models\pelanggaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class pelanggarancontroller extends Controller
{
    public function index()
    {
        //get data from table posts
        $pelanggaran = pelanggaran::all();

        //make response JSON
        return response()->json([
            'success' => true,
            'message' => 'List Data Pelanggaran',
            'data'    => $pelanggaran
        ], 200);
    }

    /**
     * show
     *
     * @param  mixed $id
     * @return void
     */
    public function show($id)
    {
        //find post by ID
        $pelanggaran = pelanggaran::findOrfail($id);

        //make response JSON
        return response()->json([
            'success' => true,
            'message' => 'Detail Data Pelanggaran',
            'data'    => $pelanggaran
        ], 200);
    }

    /**
     * store
     *
     * @param  mixed $request
     * @return void
     */
    public function store(Request $request)
    {
        //set validation
        $validator = Validator::make($request->all(), [
            'jenis_pelanggaran'   => 'required',
            'poin' => 'required',
        ]);

        //response error validation
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        //save to database
        $pelanggaran = pelanggaran::create([
            'jenis_pelanggaran' => $request->jenis_pelanggaran,
            'poin'             => $request->poin,
        ]);

        //success save to database
        if ($pelanggaran) {

            return response()->json([
                'success' => true,
                'message' => 'Post Created',
                'data'    => $pelanggaran
            ], 201);
        }

        //failed save to database
        return response()->json([
            'success' => false,
            'message' => 'Post Failed to Save',
        ], 409);
    }

    /**
     * update
     *
     * @param  mixed $request
     * @param  mixed $post
     * @return void
     */
    public function update(Request $request, pelanggaran $pelanggaran)
    {
        //set validation
        $validator = Validator::make($request->all(), [
            'jenis_pelanggaran'   => 'required',

        ]);

        //response error validation
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        //find post by ID
        $pelanggaran = pelanggaran::findOrFail($pelanggaran->id);

        if ($pelanggaran) {

            //update post
            $pelanggaran->update([
                'jenis_pelanggaran'     => $request->jenis_pelanggaran,
                'poin'                  => $request->poin,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Post Updated',
                'data'    => $pelanggaran
            ], 200);
        }

        //data post not found
        return response()->json([
            'success' => false,
            'message' => 'Post Not Found',
        ], 404);
    }

    /**
     * destroy
     *
     * @param  mixed $id
     * @return void
     */
    public function destroy($id)
    {
        //find post by ID
        $pelanggaran = pelanggaran::findOrfail($id);

        if ($pelanggaran) {

            //delete post
            $pelanggaran->delete();

            return response()->json([
                'success' => true,
                'message' => 'Post Deleted',
            ], 200);
        }

        //data post not found
        return response()->json([
            'success' => false,
            'message' => 'Post Not Found',
        ], 404);
    }
}
