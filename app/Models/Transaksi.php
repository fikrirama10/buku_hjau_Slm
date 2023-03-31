<?php

namespace App\Models;

use Alfa6661\AutoNumber\AutoNumberTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    use HasFactory;
    use AutoNumberTrait;
    protected $table = 'transaksi';
    public $timestamps = false;
    protected $guarded = [];
    public function getAutoNumberOptions()
    {        
        return [
            'id_transaksi' => [
                'format' => function () {
                    //$absen  = DB::table('tbl_kode_absen')->where('id',$this->id_presensi)->first();
                    return  'TRX'.date('dmY').'-?'; // autonumber format. '?' will be replaced with the generated number.
                },
                'length' => 3 // The number of digits in the autonumber
            ]
        ];
    }
}
