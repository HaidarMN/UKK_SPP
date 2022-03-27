<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Siswa;
use App\User;
use Illuminate\Support\Facades\validator;
use Illuminate\Support\Facades\Hash;
use Auth;
use Illuminate\Support\Facades\DB;

class SiswaController extends Controller
{

    //POST
    public function store (Request $req) {
        $validator = Validator::make($req->all(), [
            'nis'       => 'required',
            'nama'      => 'required',
            'id_kelas'  => 'required',
            'alamat'    => 'required',
            'no_telp'   => 'required',
            'email'     => 'required',
            'password'  => 'required',
        ]);
        if($validator->fails()) {
            $data['status']     = false;
            $data['messagae']   = $validator->errors();
            return Response ()->json($data);
        }
        $save = Siswa::create([
            'nis'       => $req->nis,
            'nama'      => $req->nama,
            'id_kelas'  => $req->id_kelas,
            'alamat'    => $req->alamat,
            'no_telp'   => $req->no_telp,
            'email'     => $req->email,
            'password'  => Hash::make($req->password),
        ]);
        if($save) {
            $data['status']     = true;
            $data['message']    = "Berhasil menambah siswa";
        } else {
            $data['status']     = false;
            $data['message']    = "Gagal menambah siswa";
        }
        return $data;
    }
    
    //UPDATE
    public function update(Request $request, $nisn)
    {
        $validator = Validator::make($request->all(), [
            'nis'           => 'required',
            'nama'          => 'required|string|max:255',
            'id_kelas'      => 'required',
            'alamat'        => 'required',
            'no_telp'       => 'required',
            'email'         => 'required|string|email|max:255|unique:users',
            'password'      => 'required|string|min:6|confirmed',
            'level'         => 'required',
            'username'      => 'required'
        ]);

        if($validator->fails()) {
            $data['status']     = false;
            $data['messagae']   = $validator->errors();
            return Response ()->json($data);
        }

        //Data SISWA
        $siswa = Siswa::where('nisn', $nisn)->update([
            'nis'       => $request->nis,
            'nama'      => $request->nama,
            'id_kelas'  => $request->id_kelas,
            'alamat'    => $request->alamat,
            'no_telp'   => $request->no_telp,
            'email'     => $request->email,
            'password'  => Hash::make($request->password),
        ]);

        //Data USER
        $user = User::where('nisn', $nisn)->update([
            'username'      => $request->get('username'),
            'email'         => $request->email,
            'password'      => Hash::make($request->password),
            'name'          => $request->nama,
            'level'         => $request->get('level'),
        ]);

        //SISWA
        if($siswa) {
            $data['status']     = true;
            $data['message']    = "Berhasil mengubah siswa";
        } else {
            $data['status']     = false;
            $data['message']    = "Gagal mengubah siswa";
        }

        //USER
        if($user) {
            $data['status']     = true;
            $data['message']    = "Berhasil mengubah siswa";
        } else {
            $data['status']     = false;
            $data['message']    = "Gagal mengubah siswa";
        }
        return $data;
    }

    //DELETE
    public function destroy($nisn) {
        $hapus= Siswa::where('nisn', $nisn)->delete();
        if($hapus) {
            return Response()->json(['status'=>'Berhasil menghapus data']);
        } else {
            return Response()->json(['status'=>'Gagal mengahpus data']);
        }
    }

    //GET
    public function siswa() {
        $getsiswa=Siswa::get();
        return Response()->json($getsiswa);
    }

    //GET 1 DATA
    public function getdetail($nisn){
        $detail=Siswa::where('nisn', $nisn)->first();
        return Response()->json($detail);
    }

    //SEARCH
    public function cari_data($kata_kunci) {
        $detail = Siswa::where('nama', 'like', '%'.$kata_kunci.'%')->get();
        return Response()->json($detail);
    }

    //TOTAL
    public function total() {
        $siswa = DB::table('siswa')->count();
        return Response()->json($siswa);
    }

    public function siswaAuth() {
        $data = "Selamat datang " . Auth::user()->name . ", di bagian Siswa";
        return response()->json($data, 200);
    }
}
