<?php

namespace App\Http\Controllers;

use App\Helpers\Penilian;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\View;
class PenilaianController extends Controller
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
                $html = '<a href="' . route('detail-pegawai', $data->id) . '" class="btn btn-info btn-xs"><i class=" tf-icons ti ti-edit"></i>Nilai</a>';
                return $html;
            })->rawColumns(['action'])->make(true);
        }
        $noabsen = DB::table('tbl_kode_absen')->get();
        $jabatan = DB::table('tbl_jabatan')->get();
        return view('penilaian.index',[
            'title'=>'Data Pegawai',
            'id'=>'penilaian'
        ],compact('noabsen','jabatan'));
    }
    public function ranking($id, $tahun)
    {
        $data = DB::table('users')->where('id', $id)->first();
        $kriteria_all = DB::table('tbl_kriteria')->get();
        $bulan = [
            ['id' => '01', 'bulan' => 1],
            ['id' => '02', 'bulan' => 2],
            ['id' => '03', 'bulan' => 3],
            ['id' => '04', 'bulan' => 4],
            ['id' => '05', 'bulan' => 5],
            ['id' => '06', 'bulan' => 6],
            ['id' => '07', 'bulan' => 7],
            ['id' => '08', 'bulan' => 8],
            ['id' => '09', 'bulan' => 9],
            ['id' => '10', 'bulan' => 10],
            ['id' => '11', 'bulan' => 11],
            ['id' => '12', 'bulan' => 12],
        ];
        return view('penilaian.ranking',compact('data','kriteria_all','bulan','tahun'));
        //return View::make('penilaian.ranking',['data'=>$data,'kriteria_all'=>$kriteria_all,'bulan'=>$bulan,'tahun'=>$tahun]);
    }
    public function detail($id)
    {
        $data = DB::table('users')->where('id', $id)->first();
        $kriteria = DB::table('tbl_kriteria')->where('id', '!=', 1)->get();
        $kriteria_all = DB::table('tbl_kriteria')->get();
        $tahun = date('Y');
        $bulan = [
            ['id' => '01', 'bulan' => 1],
            ['id' => '02', 'bulan' => 2],
            ['id' => '03', 'bulan' => 3],
            ['id' => '04', 'bulan' => 4],
            ['id' => '05', 'bulan' => 5],
            ['id' => '06', 'bulan' => 6],
            ['id' => '07', 'bulan' => 7],
            ['id' => '08', 'bulan' => 8],
            ['id' => '09', 'bulan' => 9],
            ['id' => '10', 'bulan' => 10],
            ['id' => '11', 'bulan' => 11],
            ['id' => '12', 'bulan' => 12],
        ];
        $array_kriteria = array();
        foreach ($kriteria as $kr) {
            $array_sub = array();
            $sub_kriteria = DB::table('tbl_sub_kriteria')->where('id_kriteria', $kr->id)->get();
            foreach ($sub_kriteria as $sk) {
                array_push($array_sub, [
                    'id_sub_kriteria' => $sk->id,
                    'sub_kriteria' => $sk->sub_kriteria,
                    'poin' => $sk->bobot_sub,
                ]);
            }
            array_push($array_kriteria, [
                'id_kriteria' => $kr->id,
                'kriteria' => $kr->kriteria,
                'bobot' => $kr->bobot,
                'sub' => $array_sub,
            ]);
        }

        //dd($array_kriteria);
        return view('penilaian.view', [
            'title'=>'Detail Pegawai',
            'id'=>'penilaian'
        ], compact('data', 'kriteria', 'array_kriteria', 'bulan', 'kriteria_all','tahun'));
    }

    public function post_nilai(Request $request, $id)
    {
        $cek = DB::table('tbl_penilaian')->where('id_user', $id)->where('bulan', $request->bulan)->where('tahun', $request->tahun)->first();
        if ($cek) {
            Alert::error('Gagal menambahkan nilai , nilai sudah ada ');
            return back();
        }
        $penilaian = DB::table('tbl_penilaian')->insertGetId([
            'id_user' => $id,
            'bulan' => $request->bulan,
            'tahun' => $request->tahun,
            'tgl_buat' => date('Y-m-d H:i:s'),
            'keterangan' => 'keterangan',
        ]);
        if ($penilaian) {
            if ($request->poin_absen) {
                $presensi = DB::table('tbl_penilaian_detail')->insertGetId([
                    'id_penilaian' => $penilaian,
                    'id_user' => $id,
                    'id_kriteria' => 1,
                    'id_sub_kriteria' => 1,
                ]);

                if ($presensi) {
                    DB::table('tbl_penilaian_total')->insert([
                        'id_penilaian' => $penilaian,
                        'id_user' => $id,
                        'id_kriteria' => 1,
                        'nilai' => $request->poin_angka,
                        'nilai_persen' => $request->poin_absen,
                    ]);
                }
            }

            if ($request->poin) {
                foreach ($request->poin as $poin) {
                    $sub = DB::table('tbl_sub_kriteria')->where('id', $poin)->first();
                    $kriteria = DB::table('tbl_kriteria')->where('id', $sub->id_kriteria)->first();
                    $nilai_kriteria = DB::table('tbl_penilaian_detail')->insertGetId([
                        'id_penilaian' => $penilaian,
                        'id_user' => $id,
                        'id_kriteria' => $kriteria->id,
                        'id_sub_kriteria' => $sub->id,
                    ]);
                }
            }
           // Penilian::cek_total2($penilaian, $id);
        }

       // Penilian::hitung_total($penilaian, $id);
        Alert::success('Berhasil menambahkan nilai');
        return back();
    }
    
}
