<?php

namespace App\Helpers;
use Illuminate\Support\Facades\DB;
use Haruncpi\LaravelIdGenerator\IdGenerator;

class Penilian
{
    public static function laporan_harian($day) {
        $transaksi_selesai = DB::table('transaksi')->where('tgl_keluar',$day)->where('status_transaksi', 3)->get();
        $transaksi_selesai_total = DB::table('transaksi')->where('tgl_keluar',$day)->where('status_transaksi', 3)->sum('total_transaksi');
        $transaksi_draf = DB::table('transaksi')->where('tgl_masuk',$day)->where('status_transaksi','!=',4)->get();
        $transaksi_dp = DB::table('transaksi_dp')->join('transaksi','transaksi_dp.id_transaksi','=','transaksi.id')->select([
            'transaksi_dp.*',
            'transaksi.nama_pasien',
            'transaksi.jenis_rawat',
            'transaksi.no_rm',
        ])->where('tgl_dp',$day)->where('status', 'Aktif')->get();
        $transaksi_dp_total = DB::table('transaksi_dp')->where('tgl_dp',$day)->where('status', 'Aktif')->sum('nominal');

        return [
            'transaksi_selesai'=>$transaksi_selesai,
            'transaksi_selesai_total'=>$transaksi_selesai_total,
            'transaksi_draf'=>$transaksi_draf,
            'transaksi_dp'=>$transaksi_dp,
            'transaksi_dp_total'=>$transaksi_dp_total,
        ];
    }
    public static function penyebut($nilai) {
		$nilai = abs($nilai);
		$huruf = array("", "Satu", "Dua", "Tiga", "Empat", "Lima", "Enam", "Tujuh", "Delapan", "Sembilan", "Sepuluh", "Sebelas");
		$temp = "";
		if ($nilai < 12) {
			$temp = " ". $huruf[$nilai];
		} else if ($nilai <20) {
			$temp = Penilian::penyebut($nilai - 10). " Belas";
		} else if ($nilai < 100) {
			$temp = Penilian::penyebut($nilai/10)." Puluh". Penilian::penyebut($nilai % 10);
		} else if ($nilai < 200) {
			$temp = " Seratus" . Penilian::penyebut($nilai - 100);
		} else if ($nilai < 1000) {
			$temp = Penilian::penyebut($nilai/100) . " Ratus" . Penilian::penyebut($nilai % 100);
		} else if ($nilai < 2000) {
			$temp = " Seribu" . Penilian::penyebut($nilai - 1000);
		} else if ($nilai < 1000000) {
			$temp = Penilian::penyebut($nilai/1000) . " Ribu" . Penilian::penyebut($nilai % 1000);
		} else if ($nilai < 1000000000) {
			$temp = Penilian::penyebut($nilai/1000000) . " Juta" . Penilian::penyebut($nilai % 1000000);
		} else if ($nilai < 1000000000000) {
			$temp = Penilian::penyebut($nilai/1000000000) . " Milyar" . Penilian::penyebut(fmod($nilai,1000000000));
		} else if ($nilai < 1000000000000000) {
			$temp = Penilian::penyebut($nilai/1000000000000) . " Trilyun" . Penilian::penyebut(fmod($nilai,1000000000000));
		}     
		return $temp;
	}
    public static function upload_foto($foto, $kode, $location)
    {
        $filenameWithExt = $foto->getClientOriginalName();
        $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
        $extension = $foto->getClientOriginalExtension();
        $filenameSimpan = $filename . '_' . $kode . '_' . time() . '.' . $extension;
        $path = $foto->storeAs('public/' . $location, $filenameSimpan);
        return $filenameSimpan;
    }
    public static function koneksi_api($url, $post = '', $delete = '')
    {
        date_default_timezone_set('UTC');
        // $tStamp = strval(time() - strtotime('1970-01-01 00:00:00'));
        // $signature = hash_hmac('sha256', env('CONS_ID') . "&" . $tStamp, env('SECRET_KEY_ID'), true);
        // $encodedSignature = base64_encode($signature);
        $usecookie = __DIR__ . "/cookie.txt";
        // $header[] = "X-cons-id: " . env('CONS_ID') . " ";
        // $header[] = "X-timestamp: " . $tStamp . " ";
        // $header[] = "X-signature: " . $encodedSignature . " ";
        // $header[] = "user_key: " . env('USER_KEY') . " ";
        // $header[] = 'Content-Type: application/x-www-form-urlencoded';
        $header[] = "Accept-Encoding: gzip, deflate";
        $header[] = "Cache-Control: max-age=0";
        $header[] = "Connection: keep-alive";
        $header[] = "Accept-Language:  en-US,en;q=0.8,id;q=0.6";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_VERBOSE, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_ENCODING, true);
        curl_setopt($ch, CURLOPT_AUTOREFERER, true);
        curl_setopt($ch, CURLOPT_MAXREDIRS, 5);

        curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows NT 6.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/37.0.2062.120 Safari/537.36");

        if ($post) {
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
            curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($post));
        }

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        $rs = curl_exec($ch);

        if (empty($rs)) {
            curl_close($ch);
            return false;
        }
        curl_close($ch);
        return $rs;
    }
}