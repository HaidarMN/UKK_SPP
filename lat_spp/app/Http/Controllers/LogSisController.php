<?php

namespace App\Http\Controllers;

use App\Siswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use JWTAuth;
use Auth;
use Config;
use Tymon\JWTAuth\Exceptions\JWTException;

class LogSisController extends Controller
{
    function __construct()
    {
        Config::set('jwt.user', \App\Siswa::class);
        Config::set('auth.providers', ['users' => [
            'driver' => 'eloquent',
            'model' => \App\Siswa::class,
        ]]);
    }

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
        return response()->json(compact('token'));
    }

    //POST
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nis'       => 'required|string|max:10',
            'nama'      => 'required|string',
            'id_kelas'  => 'required',
            'alamat'    => 'required|string',
            'no_telp'   => 'required|string|max:13',
            'email'     => 'required|string|email|max:255|unique:siswa',
            'password'  => 'required|string|confirmed|min:6',
        ]);
        if($validator->fails()){
            return response()->json($validator->errors()->toJson(), 400);
        }
        
        $siswa = Siswa::create([
            'nis'       => $request->nis,
            'nama'      => $request->nama,
            'id_kelas'  => $request->id_kelas,
            'alamat'    => $request->alamat,
            'no_telp'   => $request->no_telp,
            'email'     => $request->email,
            'password'  => Hash::make($request->password),
        ]);
        
        $token = JWTAuth::fromUser($siswa);
        return response()->json(compact('siswa','token'),201);
    }

    //GET
    public function siswa() {
        $getsiswa=Siswa::get();
        return Response()->json(['data'=>$getsiswa]);
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
