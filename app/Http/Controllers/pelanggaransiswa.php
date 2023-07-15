<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\pelanggaransiswa as psiswa;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class pelanggaransiswa extends Controller
{
    public function index()
    {
        //get data from table posts
        $pelanggaransiswa = psiswa::with('siswa', 'pelanggaran')->latest()->get();

        //make response JSON
        return response()->json([
            'success' => true,
            'message' => 'List Data Pelanggaran Siswa',
            'data'    => $pelanggaransiswa
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
        $pelanggaransiswa = psiswa::with('pelanggaran', 'siswa')->findOrfail($id);

        //make response JSON
        return response()->json([
            'success' => true,
            'message' => 'Detail Data Pelanggaran',
            'data'    => $pelanggaransiswa
        ], 200);
    }

    /**
     * store    
     *
     * @param  mixed $request
     * @return void
     */

    public function update(Request $request, psiswa $psiswa)
    {
        $pelanggaransiswa = psiswa::findOrfail($psiswa->id);
        if ($pelanggaransiswa) {

            //update post
            $pelanggaransiswa->update([
                'pelanggaran_id'       => $request->pelanggaran_id,
            ]);
            return response()->json([
                'success' => true,
                'message' => 'Post Updated',
                'data'    => $pelanggaransiswa
            ], 200);
        }

        //data post not found
        return response()->json([
            'success' => false,
            'message' => 'Post Not Found',
        ], 404);
    }

    public function store(Request $request)
    {
        //set validation
        $validator = Validator::make($request->all(), [
            'siswa_id'   => 'required',
            'pelanggaran_id' => 'required',
        ]);

        //response error validation
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        //save to database
        $pelanggarans = psiswa::create([
            'siswa_id'       => $request->siswa_id,
            'pelanggaran_id' => $request->pelanggaran_id,
        ]);

        //success save to database
        if ($pelanggarans) {
            $pesan = '---Informasi BK SMKN 1 Sumenep--- Siswa yang bernama ' . $pelanggarans->siswa->nama_siswa .  " telah melakukan pelanggaran yaitu " . $pelanggarans->pelanggaran->jenis_pelanggaran . ". " . ' waktu pencatatan ' . $pelanggarans->created_at . ' ID ' . $pelanggarans->id;
            $message = '---Informasi BK SMKN 1 Sumenep--- Siswa yang bernama ' . $pelanggarans->siswa->nama_siswa .  " telah melakukan pelanggaran yaitu *" . $pelanggarans->pelanggaran->jenis_pelanggaran . ".* " . ' waktu pencatatan ' . $pelanggarans->created_at . ' ID ' . $pelanggarans->id;
            if ($pelanggarans->siswa->orangtua->status_nomor == 'sms') {
                $this->sendsms($pelanggarans->siswa->orangtua->no_hp_orangtua, $pesan);
            } else {
                $this->kirimWA($pelanggarans->siswa->orangtua->no_hp_orangtua, $message);
            }

            return response()->json([
                'success' => true,
                'message' => 'Post Created',
                'data'    => $pelanggarans
            ], 201);
        }

        //failed save to database
        return response()->json([
            'success' => false,
            'message' => 'Post Failed to Save',
        ], 409);
    }

    public function kirimWA($hp, $message)
    {
        $data = [
            'api_key' => 'pfYbs880nasckx11gbQviN6ZzKqP94',
            'sender' => '6287787518398',
            'number' => $hp,
            'message' => $message
        ];
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://wa.srv1.wapanels.com/send-message',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => json_encode($data),
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json'
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        echo $response;
    }
    public function sendsms($no_tujuan, $pesan)
    {
        $idmesin = "196";
        $pin = "095344";
        $pesan = str_replace(" ", "%20", $pesan);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://sms.indositus.com/sendsms.php?idmesin=$idmesin&pin=$pin&to=$no_tujuan&text=$pesan");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $output = curl_exec($ch);
        curl_close($ch);
        return ($output);
    }

    public function destroy($id)
    {
        //find post by ID
        $psiswa = psiswa::findOrfail($id);

        if ($psiswa) {

            //delete post
            $psiswa->delete();

            return response()->json([
                'success' => true,
                'message' => 'Data Deleted',
            ], 200);
        }

        //data post not found
        return response()->json([
            'success' => false,
            'message' => 'Post Not Found',
        ], 404);
    }

    public function getPelSiswaOrtu($id)
    {
        $pelanggaran = DB::select("SELECT * FROM pelanggaran_siswa INNER JOIN siswas ON pelanggaran_siswa.siswa_id = siswas.id INNER JOIN orangtua ON siswas.id_orangtua = orangtua.id_orangtua WHERE orangtua.id_orangtua = $id");

        return response()->json([$pelanggaran]);
    }
}
