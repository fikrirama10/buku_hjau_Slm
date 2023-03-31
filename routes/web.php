<?php

use App\Helpers\Penilian;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\KepegawaianController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\PenilaianController;
use App\Http\Controllers\TarifController;
use App\Http\Controllers\TransaksiController;
use App\Models\Tarif;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::group(['middleware' => ['guest']], function () {
    Route::get('/login', [AuthController::class, 'login'])->name('login');
    Route::get('/refresh-captcha', [AuthController::class, 'refreshCaptcha']);
    Route::post('/auth', [AuthController::class, 'auth'])->name('auth');
});
Route::group(['middleware' => ['auth']], function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/', function () {
        $day = date('Y-m-d');
        $transaksi = Penilian::laporan_harian($day);
        $no = 1;
        $no2 = 1;
        return view('welcome',compact('transaksi','no','no2'));
    })->name('home');
    Route::group(['prefix' => 'laporan'], function () {
        Route::get('/', [LaporanController::class, 'index'])->name('laporan');
        Route::get('/all-laporan/{awal}/{akhir}', [LaporanController::class, 'all_laporan'])->name('all-laporan');
        Route::get('/unit-laporan/{awal}/{akhir}/{unit}', [LaporanController::class, 'laporan_unit'])->name('unit-laporan');
        Route::get('/view-laporan/{bulan}/{tahun}', [LaporanController::class, 'view_laporan'])->name('view-laporan');
    });
    Route::group(['prefix' => 'tarif'], function () {
        Route::get('/', [TarifController::class, 'index'])->name('tarif');
        Route::get('/detail/{id}', [TarifController::class, 'detail_tarif'])->name('detail-tarif');
        Route::get('/edit-tarif/{id}', [TarifController::class, 'edit'])->name('edit-tarif');
        Route::get('/delete-detail/{id}', [TarifController::class, 'delete_detail'])->name('delete-detail-tarif');
        Route::get('/get-tarif', [TarifController::class, 'get_tarif'])->name('get-tarif');
        Route::get('/get-tarif-id/{id}', [TarifController::class, 'get_tarif_id'])->name('get-tarif-id');
        Route::post('/post-tarif', [TarifController::class, 'post_tarif'])->name('post-tarif');
        Route::post('/post-edit-tarif/{id}', [TarifController::class, 'post_edit'])->name('post-edit-tarif');
        Route::post('/post-detai-tarif/{id}', [TarifController::class, 'post_detail_tarif'])->name('post-detail-tarif');
    });
    Route::group(['prefix' => 'transaksi'], function () {
        Route::get('/', [TransaksiController::class, 'index'])->name('transaksi');
        Route::get('/tambah-transaksi', [TransaksiController::class, 'tambah'])->name('tambah.transaksi');
        Route::get('/tambah-transaksi-manual', [TransaksiController::class, 'tambah_manual'])->name('tambah.transaksi_manual');
        Route::get('/get-pasien', [TransaksiController::class, 'get_pasien'])->name('get-pasien');
        Route::get('/get-dokter', [TransaksiController::class, 'get_dokter'])->name('get-dokter');
        Route::get('/view-transaksi/{id}', [TransaksiController::class, 'view'])->name('view-transaksi');
        Route::get('/delete-dp/{id}', [TransaksiController::class, 'delete_dp'])->name('delete-dp');
        Route::get('/kwitansi-dp/{id}', [TransaksiController::class, 'cetak_kwitasi_dp'])->name('kwitansi-dp');
        Route::get('/faktur-rajal/{id}', [TransaksiController::class, 'cetak_faktur_rajal'])->name('faktur-rajal');
        Route::get('/preview-rajal/{id}', [TransaksiController::class, 'cetak_faktur_raja_preview'])->name('preview-rajal');
        Route::get('/delete-item-tarif/{id}', [TransaksiController::class, 'delete_item_tarif'])->name('delete-item-tarif');
        Route::get('/batal-transaksi/{id}', [TransaksiController::class, 'batal_transaksi'])->name('batal-transaksi');
        Route::get('/edit-transaksi/{id}', [TransaksiController::class, 'edit_kasir'])->name('edit-transaksi');
        Route::post('/post-tambah/{jenis?}', [TransaksiController::class, 'post_tambah_trx'])->name('post-tambah');
        Route::post('/post-dp/{id}', [TransaksiController::class, 'post_dp'])->name('post-dp');
        Route::post('/post-tambah-tarif/{id}', [TransaksiController::class, 'post_tambah_tarif'])->name('post-tambah-tarif');
        Route::post('/post-bayar/{id}', [TransaksiController::class, 'post_bayar'])->name('post-bayar');
    });
});




Route::get('/cek-trx', function () {
    $awal = '2023-03-01';
    $akhir = '2023-03-31';
    $unit = DB::table('unit_transaksi')->get();
    $arrunit = array();
    foreach ($unit as $u) {
        $transaksi = DB::table('transaksi_detail')->whereBetween('tgl_transaksi',[$awal,$akhir])->where('bayar',1)->get();
        $total = 0;
        $total2 = 0;
        foreach ($transaksi as $t) {
            $tarif_detail = DB::table('tarif_detail')->where('id_tarif', $t->id_tarif)->where('id_unit',$u->id)->whereNull('sekali')->get();
            $tarif_detail_sekali = DB::table('tarif_detail')->where('id_tarif', $t->id_tarif)->where('id_unit',$u->id)->where('sekali',1)->get();
            $nominal = 0 ;
            $nominal_sekali = 0 ;
            foreach($tarif_detail as $td){               
                $nominal += $td->nominal;
            }
            foreach($tarif_detail_sekali as $tds){               
                $nominal_sekali += $tds->nominal;
            }
            $total += $nominal * $t->jumlah;
            $total2 += $nominal_sekali * 1;            
        }        
        array_push($arrunit, [
            'unit' => $u->unit,
            'total'=>$total+$total2,
        ]);
    }
    return $arrunit;
});
