<?php

namespace App\Models;

use Alfa6661\AutoNumber\AutoNumberTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tarif extends Model
{
    use HasFactory;
    use AutoNumberTrait;
    protected $table = 'tarif';
    public $timestamps = false;
    protected $guarded = [];
    public function getAutoNumberOptions()
    {        
        return [
            'kode_tarif' => [
                'format' => function () {
                    //$absen  = DB::table('tbl_kode_absen')->where('id',$this->id_presensi)->first();
                    return  'TRF'.'?'; // autonumber format. '?' will be replaced with the generated number.
                },
                'length' => 3 // The number of digits in the autonumber
            ]
        ];
    }
}
