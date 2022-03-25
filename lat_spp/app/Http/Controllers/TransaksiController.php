<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Pembayaran;
use JWTAuth;
use Auth;
use Validator;
use App\Tunggakan;
use config;
use DB;
use Carbo\Carbon;

class TransaksiController extends Controller
{
    //CEK BAYAR
    public function bayar(Request $req)
    {
        $validator = Validator::make($req->all(), [
            'nisn'          => 'required',
            'bulan_spp'     => 'required',
            'tahun_spp'     => 'required',
        ]);
        if($validator->fails()) {
            return Response()->json($validator->errors()->toJson(), 400);
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
    public function kurang($nisn)
    {
        $gethistori = tunggakan::select(
            'siswa.nisn', 'siswa.nama', 'kelas.nama_kelas', 'kelas.jurusan', 'nominal'
        )->join(
            'siswa', 'siswa.nisn', '=', 'tunggakan.nisn'
        )->join(
            'kelas', 'kelas.id_kelas', '=', 'siswa.id_kelas'
        )->join(
            'spp', 'spp.angkatan', '=', 'kelas.angkatan'
        )->where(
            'tunggakan.nisn', $nisn
        )->where(
            'status', 'belum lunas'
        )->get();
        return Response()->json($gethistori);
    }

    //REPORT
    public function report(Request $req)
    {
        $validator = Validator::make($req->all(), [
            'tahun' => 'required',
            'bulan' => 'required'
        ]);
        if($validator->fails()) {
            return response()->json($validator->errors());
        }

        $tahun = $req->tahun;
        $bulan = $req->bulan;

        $data = DB::table('pembayaran')->join('siswa', 'pembayaran.nisn', '=', 'siswa.nisn')
                    ->select('pembayaran.id_pembayaran', 'pembayaran.id_petugas', 'pembayaran.nisn', 'pembayaran.tgl_bayar', 'pembayaran.bulan_spp', 'pembayaran.tahun_spp')
                    ->where('tahun_spp', '=', $tahun)
                    ->where('bulan_spp', '=', $bulan)
                    ->get();
        
        return Response()->json($data);
    }
}
