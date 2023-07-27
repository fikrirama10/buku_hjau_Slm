<?php

namespace App\Http\Controllers;

use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LaporanController extends Controller
{
    public function index()
    {
        return view('laporan.index', [
            'title' => 'Laporan',
        ]);
    }
    public function laporan_harian($day)
    {
        
    }
    public function view_laporan($bulan, $tahun)
    {
        $unit = DB::table('unit_transaksi')->get();
        $dokter = DB::table('transaksi_detail')->whereMonth('tgl_transaksi', '=', $bulan)->whereYear('tgl_transaksi', '=', $tahun)->where('bayar', 1)->whereNotNull('id_dokter')->groupBy('id_dokter')->get();
        return view('laporan.view', compact('bulan', 'tahun','unit','dokter'));
    }
    public function laporan_perdokter($bulan, $tahun, $unit){
        $dokter = DB::table('transaksi_detail')->whereMonth('tgl_transaksi', '=', $bulan)->whereYear('tgl_transaksi', '=', $tahun)->where('bayar', 1)->where('id_dokter',$unt)->get();
        
        
    }
    public function laporan_unit($bulan, $tahun, $unit)
    {
        $transaksi = DB::table('transaksi_detail')->whereMonth('tgl_transaksi', '=', $bulan)->whereYear('tgl_transaksi', '=', $tahun)->where('bayar', 1)->get();
        
        $total = 0;
        $total2 = 0;
        foreach ($transaksi as $t) {
            $tarif_detail = DB::table('tarif_detail')->where('id_tarif', $t->id_tarif)->where('id_unit', $unit)->whereNull('sekali')->get();
            $tarif_detail_sekali = DB::table('tarif_detail')->where('id_tarif', $t->id_tarif)->where('id_unit', $unit)->where('sekali', 1)->get();
            $nominal = 0;
            $nominall = 0;
            $nominal_sekali = 0;
            foreach ($tarif_detail as $td) {
                $nominal += $td->nominal;
                $nominall = $td->nominal;
            }
            foreach ($tarif_detail_sekali as $tds) {
                $nominal_sekali += $tds->nominal;
            }
            if ($nominall == 1) {
                $total += ($nominal * $t->jumlah) - 15000;
            } else {
                $total += $nominal * $t->jumlah;
            }

            $total2 += $nominal_sekali * 1;
        }
        $unitt = DB::table('unit_transaksi')->where('id',$unit)->first();
        $data_transaksi = DB::table('tarif_detail')->leftJoin('transaksi_detail','tarif_detail.id_tarif','=','transaksi_detail.id_tarif')->join('transaksi','transaksi_detail.id_transaksi','=','transaksi.id')->whereMonth('transaksi_detail.tgl_transaksi', '=', $bulan)->whereYear('transaksi_detail.tgl_transaksi', '=', $tahun)->where('transaksi_detail.bayar', 1)->where('tarif_detail.id_unit',$unit)->orderBy('transaksi_detail.tgl_transaksi','asc')->get();
        if($unit == 1){
            $dokter = DB::table('transaksi_detail')->leftJoin('tarif_detail','tarif_detail.id_tarif','=','transaksi_detail.id_tarif')->whereMonth('tgl_transaksi', '=', $bulan)->whereYear('tgl_transaksi', '=', $tahun)->where('bayar', 1)->whereNotNull('transaksi_detail.id_dokter')->where('tarif_detail.id_unit',1)->groupBy('id_dokter')->get();           
        }else{
            $dokter = '';
        }
        //dd($dokter);
        //return $data_transaksi;
        // return [
        //     'unit'=>$unitt->unit,
        //     'total' => $total + $total2,
        //     'data_transaksi'=>$data_transaksi
        // ];
        $pdf = Pdf::loadview('laporan.unit_laporan', [
            'id_unit'=>$unitt->id,
            'unit'=>$unitt->unit,
            'total' => $total, 
            'data_transaksi'=>$data_transaksi
        ],compact('bulan','tahun','dokter'))->setPaper('a4', 'landscape');
        return $pdf->stream('laporan-keuangan-unit.pdf');
    }
    public function laporan_unit_2($bulan, $tahun, $unit)
    {
        $transaksi = DB::table('transaksi_detail')->whereMonth('tgl_transaksi', '=', $bulan)->whereYear('tgl_transaksi', '=', $tahun)->where('bayar', 1)->get();
        
        $total = 0;
        $total2 = 0;
        foreach ($transaksi as $t) {
            $tarif_detail = DB::table('tarif_detail')->where('id_tarif', $t->id_tarif)->where('id_unit', $unit)->whereNull('sekali')->get();
            $tarif_detail_sekali = DB::table('tarif_detail')->where('id_tarif', $t->id_tarif)->where('id_unit', $unit)->where('sekali', 1)->get();
            $nominal = 0;
            $nominall = 0;
            $nominal_sekali = 0;
            foreach ($tarif_detail as $td) {
                $nominal += $td->nominal;
                $nominall = $td->nominal;
            }
            foreach ($tarif_detail_sekali as $tds) {
                $nominal_sekali += $tds->nominal;
            }
            if ($nominall == 1) {
                $total += ($nominal * $t->jumlah) - 15000;
            } else {
                $total += $nominal * $t->jumlah;
            }

            $total2 += $nominal_sekali * 1;
        }
        $unitt = DB::table('unit_transaksi')->where('id',$unit)->first();
        $data_transaksi = DB::table('tarif_detail')->leftJoin('transaksi_detail','tarif_detail.id_tarif','=','transaksi_detail.id_tarif')->join('transaksi','transaksi_detail.id_transaksi','=','transaksi.id')->whereMonth('transaksi_detail.tgl_transaksi', '=', $bulan)->whereYear('transaksi_detail.tgl_transaksi', '=', $tahun)->where('transaksi_detail.bayar', 1)->where('tarif_detail.id_unit',1)->orderBy('transaksi_detail.tgl_transaksi','asc')->sum('nominal');
         
        //$data_dua = DB::table('transaksi_detail')
        dd($data_transaksi);
        if($unit == 1){
            $dokter = DB::table('transaksi_detail')->leftJoin('tarif_detail','tarif_detail.id_tarif','=','transaksi_detail.id_tarif')->whereMonth('tgl_transaksi', '=', $bulan)->whereYear('tgl_transaksi', '=', $tahun)->where('bayar', 1)->whereNotNull('transaksi_detail.id_dokter')->where('tarif_detail.id_unit',1)->groupBy('id_dokter')->get();           
        }else{
            $dokter = '';
        }
        //dd($dokter);
        //return $data_transaksi;
        // return [
        //     'unit'=>$unitt->unit,
        //     'total' => $total + $total2,
        //     'data_transaksi'=>$data_transaksi
        // ];
        $pdf = Pdf::loadview('laporan.unit_laporan', [
            'id_unit'=>$unitt->id,
            'unit'=>$unitt->unit,
            'total' => $total, 
            'data_transaksi'=>$data_transaksi
        ],compact('bulan','tahun','dokter'))->setPaper('a4', 'landscape');
        return $pdf->stream('laporan-keuangan-unit.pdf');
    }
    public function all_laporan($bulan, $tahun)
    {
        $unit = DB::table('unit_transaksi')->get();
        $arrunit = array();
        foreach ($unit as $u) {
            $transaksi = DB::table('transaksi_detail')->whereMonth('tgl_transaksi', '=', $bulan)->whereYear('tgl_transaksi', '=', $tahun)->where('bayar', 1)->get();
            $total = 0;
            $total2 = 0;
            foreach ($transaksi as $t) {
                $tarif_detail = DB::table('tarif_detail')->where('id_tarif', $t->id_tarif)->where('id_unit', $u->id)->whereNull('sekali')->get();
                $tarif_detail_sekali = DB::table('tarif_detail')->where('id_tarif', $t->id_tarif)->where('id_unit', $u->id)->where('sekali', 1)->get();
                $nominal = 0;
                $nominall = 0;
                $nominal_sekali = 0;
                foreach ($tarif_detail as $td) {
                    $nominal += $td->nominal;
                    $nominall = $td->nominal;
                }
                foreach ($tarif_detail_sekali as $tds) {
                    $nominal_sekali += $tds->nominal;
                }
                if ($nominall == 1) {
                    $total += ($nominal * $t->jumlah) - 15000;
                } else {
                    $total += $nominal * $t->jumlah;
                }

                $total2 += $nominal_sekali * 1;
            }
            array_push($arrunit, [
                'unit' => $u->unit,
                'total' => $total + $total2,
            ]);
        }

        $pdf = Pdf::loadview('laporan.all_laporan', compact('arrunit'))->setPaper('a4', 'portrait');
        return $pdf->stream('laporan-keuangan-pdf');
    }
}
