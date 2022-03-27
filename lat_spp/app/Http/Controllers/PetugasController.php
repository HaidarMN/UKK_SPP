<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Petugas;
use App\User;
use Illuminate\Support\Facades\validator;
use Illuminate\Support\Facades\Hash;
use Auth;
use DB;

class PetugasController extends Controller
{

    //POST
    public function store (Request $req) {
        $validator = Validator::make($req->all(), [
            'username'              => 'required',
            'password'              => 'required',
            'nama_petugas'          => 'required',
        ]);
        if($validator->fails()) {
            return Response ()->json($validator->errors());
        }
        $save = Petugas::create([
            'username'              => $req->username,
            'password'              => hash::make($req->password),
            'nama_petugas'          => $req->nama_petugas,
        ]);
        if($save) {
            return Response()->json(['status'=>'Berhasil menambahkan petugas']);
        } else {
            return Response()->json(['status'=>'Gagal menambahkan petugas']);
        }
    }

    //UPDATE
    public function update(Request $request, $id_petugas)
    {
        $validator = Validator::make($request->all(), [
            'nama_petugas'  => 'required|string|max:255',
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

        //Data PETUGAS
        $petugas = Petugas::where('id_petugas', $id_petugas)->update([
            'username'      => $request->get('username'),
            'password'      => Hash::make($request->get('password')),
            'nama_petugas'  => $request->get('nama_petugas'),
            'email'         => $request->get('email'),
            'level'         => $request->get('level'),
        ]);
        
        //Data USER
        $user = User::where('id_petugas', $id_petugas)->update([
            'name'          => $request->get('nama_petugas'),
            'email'         => $request->get('email'),
            'password'      => Hash::make($request->get('password')),
            'level'         => $request->get('level'),
            'username'      => $request->get('username'),
        ]);

        //PETUGAS
        if($petugas) {
            $data['status']     = true;
            $data['message']    = "Berhasil mengubah petugas";
        } else {
            $data['status']     = false;
            $data['message']    = "Gagal mengubah petugas";
        }

        //USER
        if($user) {
            $data['status']     = true;
            $data['message']    = "Berhasil mengubah petugas";
        } else {
            $data['status']     = false;
            $data['message']    = "Gagal mengubah petugas";
        }
        return $data;
    }

    //DELETE
    public function destroy($id_petugas) {
        $hapus= Petugas::where('id_petugas', $id_petugas)->delete();
        if($hapus) {
            return Response()->json(['status'=>'Berhasil menghapus data']);
        } else {
            return Response()->json(['status'=>'Gagal menghapus data']);
        }
    }

    //GET
    public function petugas() {
        $getpetugas=Petugas::get();
        return Response()->json($getpetugas);
    }

    //GET 1 DATA
    public function getdetail($id_petugas){
        $detail=User::where('id_petugas', $id_petugas)->first();
        return Response()->json($detail);
    }

    //SEARCH
    public function cari_data($kata_kunci) {
        $detail = Petugas::where('nama_petugas', 'like', '%'.$kata_kunci.'%')->get();
        return Response()->json($detail);
    }

    //TOTAL
    public function total() {
        $user = DB::table('petugas')->count();
        return Response()->json($user);
    }

    public function petugasAuth() {
        $data = "Selamat datang " . Auth::user()->name . ", di bagian Petugas";
        return response()->json($data, 200);
    }
}
/*
 _ _       _ _    _ _ _ _ _ _ _    _ _    _ _ _ _         _ _ _ _ _ _ _    _ _ _ _ _ _ _
|   |     |   |  |    _ _ _    |  |   |  |        \      |    _ _ _    |  |    _ _ _    |
|   |     |   |  |   |     |   |  |   |  |   _ _   \     |   |     |   |  |   |     |   |
|   |     |   |  |   |     |   |  |   |  |  |   \   \    |   |     |   |  |   |     |   |
|   |_ _ _|   |  |   |_ _ _|   |  |   |  |  |    \   \   |   |_ _ _|   |  |   |_ _ _|   |
|    _ _ _    |  |    _ _ _    |  |   |  |  |     |   |  |    _ _ _    |  |    _ _ _    |
|   |     |   |  |   |     |   |  |   |  |  |    /   /   |   |     |   |  |   |     \   \
|   |     |   |  |   |     |   |  |   |  |  |_ _/   /    |   |     |   |  |   |      \   \
|   |     |   |  |   |     |   |  |   |  |         /     |   |     |   |  |   |       \   \
|_ _|     |_ _|  |_ _|     |_ _|  |_ _|  |_ _ _ _ /      |_ _|     |_ _|  |_ _|        \_ _\

 _ _ _ _ _ _ _ _ _ _    _ _       _ _    _ _       _ _    _ _ _ _ _ _ _    _ _ _ _ _ _ _ _ _ _    _ _ _ _ _ _ _ _ _ _    _ _ _ _ _ _ _    _ _ _ _
|    _ _     _ _    |  |   |     |   |  |   |     |   |  |    _ _ _    |  |    _ _     _ _    |  |    _ _     _ _    |  |    _ _ _    |  |        \
|   |   |   |   |   |  |   |     |   |  |   |     |   |  |   |     |   |  |   |   |   |   |   |  |   |   |   |   |   |  |   |     |   |  |   _ _   \
|   |   |   |   |   |  |   |     |   |  |   |     |   |  |   |     |   |  |   |   |   |   |   |  |   |   |   |   |   |  |   |     |   |  |  |   \   \
|   |   |   |   |   |  |   |     |   |  |   |_ _ _|   |  |   |_ _ _|   |  |   |   |   |   |   |  |   |   |   |   |   |  |   |_ _ _|   |  |  |    \   \
|   |   |   |   |   |  |   |     |   |  |    _ _ _    |  |    _ _ _    |  |   |   |   |   |   |  |   |   |   |   |   |  |    _ _ _    |  |  |     |   |
|   |   |   |   |   |  |   |     |   |  |   |     |   |  |   |     |   |  |   |   |   |   |   |  |   |   |   |   |   |  |   |     |   |  |  |    /   /
|   |   |   |   |   |  |   |     |   |  |   |     |   |  |   |     |   |  |   |   |   |   |   |  |   |   |   |   |   |  |   |     |   |  |  |_ _/   /
|   |   |   |   |   |  |   |_ _ _|   |  |   |     |   |  |   |     |   |  |   |   |   |   |   |  |   |   |   |   |   |  |   |     |   |  |         /
|_ _|   |_ _|   |_ _|  |_ _ _ _ _ _ _|  |_ _|     |_ _|  |_ _|     |_ _|  |_ _|   |_ _|   |_ _|  |_ _|   |_ _|   |_ _|  |_ _|     |_ _|  |_ _ _ _ /

 _ _ _ _         _ _    _ _ _ _ _ _ _    _ _       _ _    _ _ _ _ _ _ _    _ _ _ _ _ _ _    _ _
|       \       |   |  |    _ _ _    |  |   |     |   |  |    _ _ _ _ _|  |    _ _ _    |  |   |
|   |\   \      |   |  |   |     |   |  |   |     |   |  |   |_ _ _ _ _   |   |     |   |  |   |
|   | \   \     |   |  |   |     |   |  |   |     |   |  |    _ _ _ _ _|  |   |     |   |  |   |
|   |  \   \    |   |  |   |_ _ _|   |  |   |     |   |  |   |            |   |_ _ _|   |  |   |
|   |   \   \   |   |  |    _ _ _    |  |   |     |   |  |   |            |    _ _ _    |  |   |
|   |    \   \  |   |  |   |     |   |  |   |     |   |  |   |            |   |     |   |  |   |
|   |     \   \ |   |  |   |     |   |  |   |     |   |  |   |            |   |     |   |  |   |
|   |      \   \|   |  |   |     |   |  |   |_ _ _|   |  |   |            |   |     |   |  |   |_ _ _ _
|_ _|       \_ _ _ _|  |_ _|     |_ _|  |_ _ _ _ _ _ _|  |_ _|            |_ _|     |_ _|  |_ _ _ _ _ _|

*/