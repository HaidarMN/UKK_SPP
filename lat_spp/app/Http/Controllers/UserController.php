<?php

namespace App\Http\Controllers;

use App\User;
use App\Petugas;
use App\Siswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use DB;
use Auth;
 
class UserController extends Controller
{
    //LOGIN
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');
        try {
            if (! $token = JWTAuth::attempt($credentials)) {
                return response()->json(['error' => 'invalid_credentials'], 400);
            }
        } catch (JWTException $e) {
            return response()->json(['error' => 'could_not_create_token'], 500);
        }
        $level      = Auth::user()->level;
        $username   = Auth::user()->username;
        $nisn       = Auth::user()->nisn;
        return response()->json(compact('token', 'level', 'username', 'nisn'));
    }

    //REG PETUGAS
    public function register(Request $request)
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
        $petugas = Petugas::create([
            'username'      => $request->get('username'),
            'password'      => Hash::make($request->get('password')),
            'nama_petugas'  => $request->get('nama_petugas'),
        ]);
        
        //Data USER
        $user = User::create([
            'name'          => $petugas->nama_petugas,
            'email'         => $request->get('email'),
            'password'      => $petugas->password,
            'level'         => $request->get('level'),
            'id_petugas'    => DB::getPdo()->lastInsertId(),
            'username'      => $request->username
        ]);

        //PETUGAS
        if($petugas) {
            $data['status']     = true;
            $data['message']    = "Berhasil menambah petugas";
        } else {
            $data['status']     = false;
            $data['message']    = "Gagal menambah petugas";
        }

        //USER
        if($user) {
            $data['status']     = true;
            $data['message']    = "Berhasil menambah petugas";
        } else {
            $data['status']     = false;
            $data['message']    = "Gagal menambah petugas";
        }
        return $data;
    }

    //REG SIS
    public function regsis(Request $request)
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
        $siswa = Siswa::create([
            'nis'       => $request->nis,
            'nama'      => $request->nama,
            'id_kelas'  => $request->id_kelas,
            'alamat'    => $request->alamat,
            'no_telp'   => $request->no_telp,
            'email'     => $request->email,
            'password'  => Hash::make($request->password),
        ]);

        //Data USER
        $user = User::create([
            'username'      => $request->get('username'),
            'email'         => $siswa->email,
            'password'      => $siswa->password,
            'name'          => $siswa->nama,
            'nisn'          => DB::getPdo()->lastInsertId(),
            'level'         => $request->get('level'),
        ]);

        //SISWA
        if($siswa) {
            $data['status']     = true;
            $data['message']    = "Berhasil menambah siswa";
        } else {
            $data['status']     = false;
            $data['message']    = "Gagal menambah siswa";
        }

        //USER
        if($user) {
            $data['status']     = true;
            $data['message']    = "Berhasil menambah siswa";
        } else {
            $data['status']     = false;
            $data['message']    = "Gagal menambah siswa";
        }
        return $data;
    }
    
    //DELETE
    public function destroy($id) {
        $hapus = User::where('id', $id)->delete();
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
    public function user() {
        $getuser=User::get();
        return Response()->json($getuser);
    }

    //GET 1 DATA
    public function getdetail($id){
        $detail=User::where('id', $id)->first();
        return Response()->json($detail);
    }

    //SEARCH
    public function cari_data($kata_kunci) {
        $detail = User::where('name', 'like', '%'.$kata_kunci.'%')->get();
        return Response()->json($detail);
    }
    
    //TOTAL
    public function total() {
        $user = DB::table('users')->count();
        return Response()->json($user);
    }

    public function getAuthenticatedUser()
    {
        try {
            if (! $user = JWTAuth::parseToken()->authenticate()) {
                return response()->json(['user_not_found'], 404);
            }
        } catch (Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {
            return response()->json(['token_expired'], $e->getStatusCode());
        } catch (Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {
            return response()->json(['token_invalid'], $e->getStatusCode());
        } catch (Tymon\JWTAuth\Exceptions\JWTException $e) {
            return response()->json(['token_absent'], $e->getStatusCode());
        }
        return response()->json([
            'success' => true,
            'message' => 'Success'
        ]);
    }
    public function getprofile()
    {
    	return response()->json(['data'=>JWTAuth::user()]);
    }
    public function getprofileadmin()
    {
        return response()->json(['data'=>JWTAuth::user()]);
    }
}
