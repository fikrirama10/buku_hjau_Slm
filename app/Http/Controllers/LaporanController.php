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
    public function laporan_harian(){}
    public function all_laporan($awal, $akhir)
    {
        $unit = DB::table('unit_transaksi')->get();
        $arrunit = array();
        foreach ($unit as $u) {
            $transaksi = DB::table('transaksi_detail')->whereBetween('tgl_transaksi', [$awal, $akhir])->where('bayar', 1)->get();
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
                if($nominall == 1){
                    $total +=( $nominal * $t->jumlah) - 15000;
                }else{
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
