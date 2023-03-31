<?php

namespace App\Http\Controllers;

use App\Helpers\Penilian;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\Facades\DataTables;

class KepegawaianController extends Controller
{
    public function index()
    {
        if (request()->ajax()) {
            $data = DB::table('users')
                ->select([
                    'users.*',
                    'tbl_jabatan.jabatan',
                ])
                ->leftJoin('tbl_jabatan', 'users.id_jabatan', '=', 'tbl_jabatan.id')
                ->where('id_jabatan', '!=', 1)->where('aktif',1);
            return DataTables::query($data)->addColumn('action', function ($data) {
                $html_edit = '<a href="' . route('detail-pegawai', $data->id) . '" class="btn btn-warning btn-xs"><i class=" tf-icons ti ti-edit"></i></a>';
                $html_delete = '<a href="' . route('nonaktif', $data->id) . '" class="btn btn-danger btn-xs"><i class=" tf-icons ti ti-trash"></i></a>';
                return $html_edit.' '.$html_delete;
            })->rawColumns(['action'])->make(true);
        }
        $noabsen = DB::table('tbl_kode_absen')->get();
        $jabatan = DB::table('tbl_jabatan')->get();
        return view('kepegawaian.index',[
            'title'=>'Detail Pegawai',
            'id'=>'kepegawaian'
        ],compact('noabsen','jabatan'));
    }
    public function nonaktif($id){
        User::where('id',$id)->update([
            'aktif'=>0
        ]);
        Alert::success('Pegawai berhasil di non aktifkan');
        return back();
    }
    public function post_tambah(Request $request){
        //return $request->all();
        $random = rand();
        $request->validate([
            "kode_absen"=>"required",
            "no_absen"=>"required",
            "nama"=>"required",
            "alamat"=>"required",
            "jenis_kelamin"=>"required",
            "jabatan"=>"required",
            "pertama_kerja"=>"required",
            "pengabdian"=>"required",
            "pendidikan"=>"required",
            "foto"=>"required",
            "email"=>"required",
        ]);

        if ($request->hasFile('foto')) {
            $foto = Penilian::upload_foto($request->foto, $random, 'foto_pegawai');
        } else {
            $foto = 'default.jpg';
        }

        $pegawai = User::create([
            'id_jabatan'=>$request->jabatan,
            'id_presensi'=>$request->kode_absen,
            'name'=>$request->nama,
            'foto'=>$foto,
            'alamat'=>$request->alamat,
            'jenis_kelamin'=>$request->jenis_kelamin,
            'pertama_kerja'=>$request->pertama_kerja,
            'email'=>$request->email,
            'password'=>Hash::make('12345'),
            'pengabdian'=>$request->pengabdian,
            'pendidikan'=>$request->pendidikan,
            'aktif'=>1,
        ]);
        Alert::success('Data berhasil ditambah');
        return back();
    }
}
