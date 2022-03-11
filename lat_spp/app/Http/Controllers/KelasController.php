<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Kelas;
use Illuminate\Support\Facades\validator;
use Auth;
use Illuminate\Support\Facades\DB;

class KelasController extends Controller
{

    //POST
    public function store (Request $req) {
        $validator = Validator::make($req->all(), [
            'nama_kelas'        => 'required',
            'jurusan'           => 'required',
            'angkatan'          => 'required',
        ]);
        if($validator->fails()) {
            $data['status']     = false;
            $data['messagae']   = $validator->errors();
            return Response ()->json($data);
        }
        $save = Kelas::create([
            'nama_kelas'        => $req->nama_kelas,
            'jurusan'           => $req->jurusan,
            'angkatan'          => $req->angkatan,
        ]);
        if($save) {
            $data['status']     = true;
            $data['message']    = "Berhasil menambah kelas";
        } else {
            $data['status']     = false;
            $data['message']    = "Gagal menambah kelas";
        }
        return $data;
    }

    //UPDATE
    public function update(Request $req, $id_kelas) {
        $validator = Validator::make($req->all(), [
            'nama_kelas'        => 'required',
            'jurusan'           => 'required',
            'angkatan'          => 'required',
        ]);
        if($validator->fails()) {
            $data['status']     = false;
            $data['messagae']   = $validator->errors();
            return Response ()->json($data);
        }
        $ubah = Kelas::where('id_kelas', $id_kelas)->update([
            'nama_kelas'        => $req->nama_kelas,
            'jurusan'           => $req->jurusan,
            'angkatan'          => $req->angkatan,
        ]);
        if($ubah) {
            $data['status']     = true;
            $data['message']    = "Berhasil mengubah data";
        } else {
            $data['status']     = false;
            $data['message']    = "Gagal mengubah data";
        }
        return $data;
    }

    //DELETE
    public function destroy($id_kelas) {
        $hapus = Kelas::where('id_kelas', $id_kelas)->delete();
        if($hapus) {
            $data['status']     = true;
            $data['message']    = "Berhasil menghapus data";
        } else {
            $data['status']     = false;
            $data['message']    = "Gagal menghapus data";
        }
        return $data;
    }

    //GET
    public function kelas() {
        $getkelas = Kelas::get();
        return Response()->json($getkelas);
    }

    //GET 1 DATA
    public function getdetail($id_kelas){
        $detail=Kelas::where('id_kelas', $id_kelas)->first();
        return Response()->json($detail);
    }

    //SEARCH
    public function cari_data($kata_kunci) {
        $detail = Kelas::where('nama_kelas', 'like', '%'.$kata_kunci.'%')->get();
        return Response()->json($detail);
    }

    //TOTAL
    public function total() {
        $count = DB::table('kelas')->count();
    }

    //JWT
    public function kelasAuth() {
        $data = "Selamat datang " . Auth::user()->name . ", di bagian Kelas";
        return Response()->json($data, 200);
    }
}
