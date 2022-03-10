<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Spp;
use Illuminate\Support\Facades\validator;
use Auth;

class SppController extends Controller
{

    //POST
    public function store (Request $req) {
        $validator = Validator::make($req->all(), [
            'angkatan'      => 'required',
            'tahun'         => 'required',
            'nominal'       => 'required',
        ]);
        if($validator->fails()) {
            $data['status']     = false;
            $data['messagae']   = $validator->errors();
            return Response ()->json($data);
        }
        $save = Spp::create([
            'angkatan'      => $req->angkatan,
            'tahun'         => $req->tahun,
            'nominal'       => $req->nominal,
        ]);
        if($save) {
            $data['status']     = true;
            $data['message']    = "Berhasil menambah spp";
        } else {
            $data['status']     = false;
            $data['message']    = "Gagal menambah spp";
        }
        return $data;
    }

    //UPDATE
    public function update(Request $req, $id_spp) {
        $validator = Validator::make($req->all(), [
            'angkatan'      => 'required',
            'tahun'         => 'required',
            'nominal'       => 'required',
        ]);
        if($validator->fails()) {
            $data['status']     = false;
            $data['messagae']   = $validator->errors();
            return Response ()->json($data);
        }
        $ubah = Spp::where('id_spp', $id_spp)->update([
            'angkatan'      => $req->angkatan,
            'tahun'         => $req->tahun,
            'nominal'       => $req->nominal,
        ]);
        if($save) {
            $data['status']     = true;
            $data['message']    = "Berhasil mengubah data";
        } else {
            $data['status']     = false;
            $data['message']    = "Gagal mengubah data";
        }
        return $data;
    }

    //DELETE
    public function destroy($id_spp) {
        $hapus= Spp::where('id_spp', $id_spp)->delete();
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
    public function spp() {
        $getspp=Spp::get();
        return Response()->json(['data'=>$getspp]);
    }

    //SEARCH
    public function cari_data($kata_kunci) {
        $detail = Spp::where('angkatan', 'like', '%'.$kata_kunci.'%')->get();
        return Response()->json($detail);
    }

    public function sppAuth() {
        $data = "Selamat datang " . Auth::user()->name . ", di bagian SPP";
        return response()->json($data, 200);
    }
}
