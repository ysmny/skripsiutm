<?php

namespace App\Http\Controllers;

use App\Models\Siswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class Siswacontroller extends Controller
{
    public function index()
    {
        //get data from table posts
        $siswas = Siswa::with('orangtua')->latest()->get();
        //make response JSON
        return response()->json([
            'success' => true,
            'message' => 'List Data Siswa',
            'data'    => $siswas
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

        //find siswa by ID
        $post = Siswa::findOrfail($id);

        //make response JSON
        return response()->json([
            'success' => true,
            'message' => 'Detail Data Post',
            'data'    => $post
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
            'nama_siswa'   => 'required',
        ]);

        //response error validation
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        //save to database
        $siswa = Siswa::create([
            'id'            => $request->id,
            'nama_siswa'     => $request->nama_siswa,
            'alamat_siswa'   => $request->alamat_siswa,
            'jurusan'        => $request->jurusan,
            'no_hp_siswa'    => $request->no_hp_siswa,
            'id_orangtua'   => $request->id_orangtua,
            'kelas'         => $request->kelas,
        ]);

        //success save to database
        if ($siswa) {

            return response()->json([
                'success' => true,
                'message' => 'Post Created',
                'data'    => $siswa
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
    public function update(Request $request, Siswa $siswa)
    {
        //set validation
        $validator = Validator::make($request->all(), [
            'nama_siswa'   => 'required',

        ]);

        //response error validation
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        //find post by ID

        $siswa = Siswa::findOrFail($siswa->id);

        if ($siswa) {

            //update post
            $siswa->update([
                'nama_siswa'     => $request->nama_siswa,
                'alamat_siswa'   => $request->alamat_siswa,
                'jurusan'        => $request->jurusan,
                'no_hp_siswa'     => $request->no_hp_siswa,
                'kelas'           => $request->kelas,

            ]);
            return response()->json([
                'success' => true,
                'message' => 'Post Updated',
                'data'    => $siswa
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
        $siswa = siswa::findOrfail($id);

        if ($siswa) {

            //delete post
            $siswa->delete();

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
