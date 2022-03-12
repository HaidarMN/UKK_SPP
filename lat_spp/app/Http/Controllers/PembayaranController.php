<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Pembayaran;
use Illuminate\Support\Facades\validator;
use Auth;
use Illuminate\Support\Facades\DB;

class PembayaranController extends Controller
{

    //POST
    public function store (Request $req) {
        $validator = Validator::make($req->all(), [
            'id_petugas'        => 'required',
            'nisn'              => 'required',
            'tgl_bayar'         => 'required',
            'bulan_spp'         => 'required',
            'tahun_spp'         => 'required',
        ]);
        if($validator->fails()) {
            return Response ()->json($validator->errors());
        }
        $save = Pembayaran::create([
            'id_petugas'        => $req->id_petugas,
            'nisn'              => $req->nisn,
            'tgl_bayar'         => $req->tgl_bayar,
            'bulan_spp'         => $req->bulan_spp,
            'tahun_spp'         => $req->tahun_spp,
        ]);
        if($save) {
            return Response()->json(['status'=>'Berhasil menambah pembayaran']);
        } else {
            return Response()->json(['status'=>'Gagal menambah pembayaran']);
        }
    }
    
    //UPDATE
    public function update(Request $req, $id_pembayaran) {
        $validator = Validator::make($req->all(), [
            'id_petugas'        => 'required',
            'nisn'              => 'required',
            'tgl_bayar'         => 'required',
            'bulan_spp'         => 'required',
            'tahun_spp'         => 'required',
        ]);
        if($validator->fails()) {
            return Response ()->json($validator->errors());
        }
        $ubah = Pembayaran::where('id_pembayaran', $id_pembayaran)->update([
            'id_petugas'        => $req->id_petugas,
            'nisn'              => $req->nisn,
            'tgl_bayar'         => $req->tgl_bayar,
            'bulan_spp'         => $req->bulan_spp,
            'tahun_spp'         => $req->tahun_spp,
        ]);
        if($ubah) {
            return Response()->json(['status'=>'Berhasil mengubah data']);
        } else {
            return Response()->json(['status'=>'Gagal mengubah data']);
        }
    }

    //DELETE
    public function destroy($id_pembayaran) {
        $hapus = Pembayaran::where('id_pembayaran', $id_pembayaran)->delete();
        if($hapus) {
            return Response()->json(['status'=>'Berhasil menghapus data']);
        } else {
            return Response()->json(['status'=>'Gagal menghapus data']);
        }
    }

    //GET
    public function pembayaran() {
        $getpembayaran = Pembayaran::get();
        return Response()->json($getpembayaran);
    }

    //GET 1 DATA
    public function getdetail($id_pembayaran){
        $detail=Pembayaran::where('id_pe$id_pembayaran', $id_pembayaran)->first();
        return Response()->json($detail);
    }

    //SEARCH
    public function cari_data($kata_kunci) {
        $detail = Pembayaran::where('nisn', 'like', '%'.$kata_kunci.'%')->get();
        return Response()->json($detail);
    }

    public function pembayaranAuth() {
        $data = "Selamat datang " . Auth::user()->name . ", di bagian Pembayaran";
        return response()->json($data, 200);
    }
}
