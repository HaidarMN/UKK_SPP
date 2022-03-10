<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Pembayaran;
use JWTAuth;
use Validator;
use App\Tunggakan;
use config;

class TransaksiController extends Controller
{
    //CEK BAYAR
    public function bayar(Request $req) {
        $validaotr = Validator::make($req->all(), [
            'nisn'          =>'required',
            'bulan_spp'     => 'required',
            'tahun_spp'     => 'required',
        ]);
        if($validaotr->fails()) {
            return Response()->json($validaotr->errors()->toJson(), 400);
        }
        $ceklunas=tunggakan::where('nisn', $req->get('nisn'))
            ->where('bulan_spp', $req->get('bulan_spp'))
            ->where('tahun_spp', $req->get('tahun_spp'));
        if($ceklunas->count()>0) {
            $status = $ceklunas->first();
            if($status->status=="belum lunas") {
                $pembayaran = pembayaran::create([
                    'id_petugas'    => JWTAuth::user()->id_petugas,
                    'nisn'          => $req->get('nisn'),
                    'tgl_bayar'     => date('Y-m-d'),
                    'bulan_spp'     => $req->get('bulan_spp'),
                    'tahun_spp'     => $req->get('tahun_spp'),
                ]);
                if($pembayaran) {
                    $up_tunggakan = tunggakan::where('nisn', $req->get('nisn'))
                        ->where('bulan_spp', $req->get('bulan_spp'))
                        ->where('tahun_spp', $req->get('tahun_spp'))
                        ->update([
                            'status' => 'lunas'
                        ]);
                    return Response()->json([
                        'status'    => true,
                        'message'   => 'Pembayaran sukses'
                    ]);
                } else {
                    return Response()->json([
                        'status'    => false,
                        'message'   => 'Pembayaran gagal'
                    ]);     
                }
            } elseif($status->status=="lunas") {
                return Response()->json([
                    'status'    => false,
                    'message'   => 'Bulan ini sudah lunas'
                ]);
            } else {
                return Response()->json([
                    'status'    => false,
                    'message'   => 'Tidak ada tunggakan'
                ]);
            }
        }
    }

    //KURANG BAYAR
    public function kurang($id) {
        $gethistori = tunggakan::select(
            'siswa.nisn', 'siswa.nama', 'kelas.nama_kelas', 'kelas.jurusan', 'nominal'
        )->join(
            'siswa', 'siswa.nisn', '=', 'tunggakan.nisn'
        )->join(
            'kelas', 'kelas.id_kelas', '=', 'siswa.id_kelas'
        )->join(
            'spp', 'spp.angkatan', '=', 'kelas.angkatan'
        )->where(
            'tunggakan.nisn', $id
        )->where(
            'status', 'belum lunas'
        )->get();
        return Response()->json($gethistori);
    }
}
