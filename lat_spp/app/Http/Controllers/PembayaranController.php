<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Pembayaran;
use Illuminate\Support\Facades\validator;
use JWTAuth;
use Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PembayaranController extends Controller
{

    //POST
    public function store (Request $req) {
        $validator = Validator::make($req->all(), [
            'nisn'              => 'required',
            'bulan_spp'         => 'required',
            'tahun_spp'         => 'required',
        ]);

        if($validator->fails()) {
            $data['status']     = false;
            $data['message']   = $validator->errors();
            return Response ()->json($data);
        }

        $ceklunas =  Pembayaran::where('nisn', $req->get('nisn'))
                                ->where('bulan_spp', $req->get('bulan_spp'))
                                ->where('tahun_spp', $req->get('tahun_spp'));
        
        if($ceklunas->count() == 0) {
            $pembayaran = Pembayaran::create([
                'id_petugas'    => JWTAuth::user()->id_petugas,
                'nisn'          => $req->get('nisn'),
                'tgl_bayar'     => date('Y-m-d'),
                'bulan_spp'     => $req->get('bulan_spp'),
                'tahun_spp'     => $req->get('tahun_spp'),
                'status'        => 'lunas'
            ]);

            if($pembayaran) {
                $data['status']     = true;
                $data['message']    = "Pembayaran berhasil";
            } else {
                $data['status']     = false;
                $data['message']    = "Pembayaran gagal";
            }
            return $data;
        } else {
            $data['status']     = false;
            $data['message']    = "SPP bulan ini sudah lunas";
        }
        return $data;
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
    public function getdetail($id_pembayaran) {
        $detail = Pembayaran::where('id_pembayaran', $id_pembayaran)->first();
        return Response()->json($detail);
    }

    //GET 1 DATA FROM NISN
    public function getnisn($nisn) {
        $getnisn = Pembayaran::where('nisn', $nisn)->get();
        return Response()->json($getnisn);
    }

    //SEARCH
    public function cari_data($kata_kunci) {
        $detail = Pembayaran::where('nisn', 'like', '%'.$kata_kunci.'%')->get();
        return Response()->json($detail);
    }

    //LAST
    public function last() {
        $last = DB::table('pembayaran')->latest('id_pembayaran')->take(4)->get();
        return Response()->json($last);
    }

    public function pembayaranAuth() {
        $data = "Selamat datang " . Auth::user()->name . ", di bagian Pembayaran";
        return response()->json($data, 200);
    }
}
