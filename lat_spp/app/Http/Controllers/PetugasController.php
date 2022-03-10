<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Petugas;
use Illuminate\Support\Facades\validator;
use Illuminate\Support\Facades\Hash;
use Auth;

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
    public function update(Request $req, $id_petugas) {
        $validator = Validator::make($req->all(), [
            'username'              => 'required',
            'password'              => 'required',
            'nama_petugas'          => 'required',
        ]);
        if($validator->fails()) {
            return Response ()->json($validator->errors());
        }
        $ubah = Petugas::where('id_petugas', $id_petugas)->update([
            'username'              => $req->username,
            'password'              => hash::make($req->password),
            'nama_petugas'          => $req->nama_petugas,
        ]);
        if($ubah) {
            return Response()->json(['status'=>'Berhasil mengubah data']);
        } else {
            return Response()->json(['status'=>'Gagal mengubah data']);
        }
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
        return Response()->json(['data'=>$getpetugas]);
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