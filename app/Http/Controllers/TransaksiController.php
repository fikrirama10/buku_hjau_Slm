<?php

namespace App\Http\Controllers;

use App\Helpers\Penilian;
use App\Models\Tarif;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\Facades\DataTables;
use Barryvdh\DomPDF\Facade\Pdf;

class TransaksiController extends Controller
{
    public function index()
    {
        if (request()->ajax()) {
            $data = DB::table('transaksi')->select([
                'transaksi.*',
                'transaksi_status.status'
            ])->join('transaksi_status', 'transaksi.status_transaksi', '=', 'transaksi_status.id')->orderBy('tgl_transaksi','desc');
            return DataTables::query($data)->addColumn('action', function ($data) {
                $html = '<a href="' . route('view-transaksi', $data->id) . '" class="btn btn-info">Lihat</a>';
                return $html;
            })->make(true);
        }
        return view('transaksi.index', [
            'title' => 'Transaksi',
            'id' => 'transaksi',
        ]);
    }
    public function tambah_manual()
    {
        return view('transaksi.tambah_data_manual', [
            'title' => 'Tambah Transaksi Manual',
            'id' => 'transaksi'
        ]);
    }
    public function tambah()
    {
        $json_jenis = Penilian::koneksi_api('https://new-simrs.rsausulaiman.com/dashboard/rest/get-jenisrawat');
        $jenis_rawat = json_decode($json_jenis);
        return view('transaksi.tambah_data', [
            'title' => 'Tambah Transaksi',
            'id' => 'transaksi'
        ], compact('jenis_rawat'));
    }

    public function get_pasien(Request $request)
    {
        $term = trim($request->q);
        if (empty($term)) {
            return response()->json([]);
        }
        $pasien = Penilian::koneksi_api('https://new-simrs.rsausulaiman.com/dashboard/rest/get-pasien?q=' . $term);
        $data_pasien = json_decode($pasien);
        //return $pasien;
        $formatted_tags = [];
        foreach ($data_pasien as $tag) {
            $formatted_tags[] = ['id' => $tag->no_rm, 'text' => $tag->no_rm . '-' . $tag->nama_pasien];
        }
        return response()->json($formatted_tags);
    }
    public function get_dokter(Request $request)
    {
        $term = trim($request->q);
        if (empty($term)) {
            return response()->json([]);
        }
        $pasien = Penilian::koneksi_api('https://new-simrs.rsausulaiman.com/dashboard/rest/get-dokter?q=' . $term);
        $data_pasien = json_decode($pasien);
        //return $pasien;
        $formatted_tags = [];
        foreach ($data_pasien as $tag) {
            $formatted_tags[] = ['id' => $tag->id_dokter, 'text' => $tag->nama_dokter];
        }
        return response()->json($formatted_tags);
    }

    public function post_tambah_trx(Request $request, $jenis = '')
    {
        $dokter = json_decode(Penilian::koneksi_api('https://new-simrs.rsausulaiman.com/dashboard/rest/getid-dokter?q=' . $request->id_dokter));
        if ($jenis == 'manual') {
            $data = [
                'no_rm' => $request->no_rm,
                'nama_pasien' => $request->nama_pasien,
                'no_hp' => $request->nohp,
                'jenis_rawat' => $request->jenis_rawat,
                'id_dokter' => $request->id_dokter,
                'nama_dokter' => $dokter->nama_dokter,
                'poli_ruangan' => $request->poli_ruangan,
                'id_user' => 1,
                'tgl_transaksi' => date('Y-m-d H:i:s'),
                'tgl_masuk' => $request->tgl_masuk,
                'status_transaksi' => 1,
                'input_simrs' => $request->input_simrs,
                'nama_penanggung' => $request->penanggung_jawab
            ];
        } else {
            $pasien = json_decode(Penilian::koneksi_api('https://new-simrs.rsausulaiman.com/dashboard/rest/getid-pasien?id=' . $request->no_rm));
            //return $dokter;
            $data = [
                'no_rm' => $pasien->no_rm,
                'nama_pasien' => $pasien->nama_pasien,
                'no_hp' => $pasien->nohp,
                'jenis_rawat' => $request->jenis_rawat,
                'id_dokter' => $dokter->id_dokter,
                'nama_dokter' => $dokter->nama_dokter,
                'poli_ruangan' => $request->poli_ruangan,
                'id_user' => 1,
                'tgl_transaksi' => date('Y-m-d H:i:s'),
                'tgl_masuk' => $request->tgl_masuk,
                'status_transaksi' => 1,
                'input_simrs' => $request->input_simrs,
                'nama_penanggung' => $request->penanggung_jawab
            ];
        }

        $transaksi = Transaksi::create($data);
        //return $data;
        Alert::success('Transaksi berhasil di tambahkan');
        return redirect(route('view-transaksi',$transaksi->id));
    }
    public function view($id)
    {
        $transaksi = Transaksi::where('id', $id)->first();
        $transaksi_dp = DB::table('transaksi_dp')->where('id_transaksi', $id)->get();
        $transaksi_detail = DB::table('transaksi_detail')->join('tarif', 'transaksi_detail.id_tarif', '=', 'tarif.id')->select([
            'transaksi_detail.*',
            'tarif.nama_tarif',
            'tarif.nominal_tarif',
        ])->where('transaksi_detail.id_transaksi', $id)->get();
        //dd($transaksi_detail);
        return view('transaksi.view', [
            'title' => 'Transaksi',
            'id' => 'transaksi'
        ], compact('transaksi', 'transaksi_dp', 'transaksi_detail'));
    }

    public function post_dp(Request $request, $id)
    {
        $data = [
            'id_transaksi' => $id,
            'tgl_dp' => $request->tgl_dp,
            'nama_dp' => $request->nama_dp,
            'nominal' => $request->nominal,
            'keterangan' => $request->keterangan,
            'status' => 'Aktif',
        ];
        DB::table('transaksi')->where('id', $id)->update([
            'status_transaksi' => 2,
        ]);
        DB::table('transaksi_dp')->insert($data);
        return back();
    }
    public function delete_dp($id)
    {
        DB::table('transaksi_dp')->where('id', $id)->delete();
        Alert::success('DP Berhasil di hapus');
        return back();
    }

    public function cetak_faktur_raja_preview($id){
        $transaksi = Transaksi::where('id',$id)->where('status_transaksi','<',3)->first();
        if(!$transaksi){
            return redirect(route('transaksi'));
        }
        $transaksi_detail = DB::table('transaksi_detail')->where('id_transaksi',$id)->get();
        $transaksi_detail_total = DB::table('transaksi_detail')->where('id_transaksi',$id)->sum('harga_total');
        $transaksi_dp = DB::table('transaksi_dp')->where('id_transaksi',$id)->where('status','Aktif')->sum('nominal');
        $customPaper = array(0, 0, 420,595);
        $title='Preview Faktur';
        $pdf = PDF::loadview('transaksi.preview-rajal', compact('transaksi', 'transaksi_detail','transaksi_dp','title','transaksi_detail_total'))->setPaper($customPaper, 'portrait');;

        return $pdf->stream('laporan-pegawai-pdf');
    }
    public function cetak_faktur_rajal($id){
        $transaksi = Transaksi::where('id',$id)->where('status_transaksi',3)->first();
        if(!$transaksi){
            return redirect(route('transaksi'));
        }
        $transaksi_detail_total = DB::table('transaksi_detail')->where('id_transaksi',$id)->sum('harga_total');
        $transaksi_detail = DB::table('transaksi_detail')->where('id_transaksi',$id)->get();
        $transaksi_dp = DB::table('transaksi_dp')->where('id_transaksi',$id)->where('status','Non Aktif')->sum('nominal');
        $customPaper = array(0, 0, 420,595);
        $title='Faktur Pembayaran';
        $pdf = PDF::loadview('transaksi.faktur-rajal', compact('transaksi', 'transaksi_detail','transaksi_dp','title','transaksi_detail_total'))->setPaper($customPaper, 'portrait');;

        return $pdf->stream('laporan-pegawai-pdf');
    }
    public function cetak_faktur_ranap($id){
        
    }
    public function cetak_kwitasi_dp($id)
    {
        $dp = DB::table('transaksi_dp')->where('id', $id)->first();

        $transaksi = DB::table('transaksi')->where('id', $dp->id_transaksi)->first();
        $customPaper = array(0, 0, 599.52, 212.60);
        $pdf = PDF::loadview('transaksi.kwitansi_dp', compact('transaksi', 'dp'))->setPaper($customPaper, 'portrait');

        return $pdf->stream('laporan-pegawai-pdf');
    }
    public function delete_item_tarif($id)
    {
        $data = DB::table('transaksi_detail')->where('id', $id)->delete();
        return back();
    }
    public function post_tambah_tarif(Request $request, $id)
    {
        if ($request->id_dokter != '') {
            $dokter = json_decode(Penilian::koneksi_api('https://new-simrs.rsausulaiman.com/dashboard/rest/getid-dokter?q=' . $request->id_dokter));
            $nama_dokter = $dokter->nama_dokter;
            $cek_trx = DB::table('transaksi_detail')->where('id_transaksi', $id)->where('id_dokter', $request->id_dokter)->where('id_tarif', $request->tarif)->first();
            //return $cek_trx;
            if ($cek_trx) {
                $jumlah = $cek_trx->jumlah + $request->jumlah;
                $total_harga = $cek_trx->harga * $jumlah;
                $update = DB::table('transaksi_detail')->where('id_transaksi', $id)->where('id_tarif', $request->tarif)->update([
                    'jumlah' => $jumlah,
                    'harga_total' => $total_harga
                ]);
                return back();
            }
        } else {
            $cek_trx = DB::table('transaksi_detail')->where('id_transaksi', $id)->where('id_tarif', $request->tarif)->first();
            //return $cek_trx;
            if ($cek_trx) {
                $jumlah = $cek_trx->jumlah + $request->jumlah;
                $total_harga = $cek_trx->harga * $jumlah;
                $update = DB::table('transaksi_detail')->where('id_transaksi', $id)->where('id_tarif', $request->tarif)->update([
                    'jumlah' => $jumlah,
                    'harga_total' => $total_harga
                ]);
                return back();
            }
            $nama_dokter = '';
        }
        $total = $request->harga_tarif * $request->jumlah;
        $data = [
            'id_tarif' => $request->tarif,
            'id_transaksi' => $id,
            'tgl_transaksi' => date('Y-m-d'),
            'nama_tarif' => $request->nama_tarif,
            'harga' => $request->harga_tarif,
            'jumlah' => $request->jumlah,
            'harga_total' => $total,
            'bayar' => 0,
            'dokter' => $nama_dokter,
            'id_dokter' => $request->id_dokter,
        ];
        DB::table('transaksi_detail')->insert($data);
        return back();
    }
    public function batal_transaksi($id)
    {
        DB::table('transaksi')->where('id', $id)->update([
            'status_transaksi' => 4
        ]);
        //lunas = 1
        //batal = 2
        DB::table('transaksi_detail')->where('id_transaksi', $id)->update([
            'bayar' => 2
        ]);
        DB::table('transaksi_dp')->where('id_transaksi', $id)->update([
            'status' => 'Non Aktif'
        ]);

        Alert::success('Transaksi Dibatalkan');
        return redirect(route('transaksi'));
    }
    public function edit_kasir($id){
        if(auth()->user()->role_id != 1){
            return redirect(route('transaksi'));
        }

        DB::table('transaksi')->where('id',$id)->update([
            'status_transaksi'=>1,
            'total_transaksi'=>0,
        ]);
        DB::table('transaksi_detail')->where('id_transaksi', $id)->update([
            'bayar' => 0
        ]);
        DB::table('transaksi_dp')->where('id_transaksi', $id)->update([
            'status' => 'Aktif'
        ]);
        
        return back();
    }
    public function post_bayar(Request $request, $id)
    {
        $detail =  DB::table('transaksi_detail')->where('id_transaksi', $id)->get();
        $total = 0;
        foreach ($detail as $d) {
            $total += $d->harga_total;
        }
        Transaksi::where('id', $id)->update([
            'status_transaksi' => 3,
            'tgl_keluar' => $request->tgl_keluar,
            'nama_user' => $request->nama_petugas,
            'tgl_bayar' => date('Y-m-d H:i:s'),
            'total_transaksi'=>$total,
        ]);
        DB::table('transaksi_detail')->where('id_transaksi', $id)->update([
            'bayar' => 1,
            'tgl_transaksi' => $request->tgl_keluar
        ]);
        DB::table('transaksi_dp')->where('id_transaksi', $id)->update([
            'status' => 'Non Aktif'
        ]);
        Alert::success('Transaksi Selesai');
        return back();
    }
}
