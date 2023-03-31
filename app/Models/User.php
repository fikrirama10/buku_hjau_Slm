<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Alfa6661\AutoNumber\AutoNumberTrait;
use Illuminate\Support\Facades\DB;

class User extends Authenticatable
{
    use HasFactory;
    use AutoNumberTrait;
    protected $table = 'users';
    protected $guarded = [];
    public function getAutoNumberOptions()
    {        
        return [
            'no_presensi' => [
                'format' => function () {
                    $absen  = DB::table('tbl_kode_absen')->where('id',$this->id_presensi)->first();
                    return  $absen->kode_absen.'-?'; // autonumber format. '?' will be replaced with the generated number.
                },
                'length' => 3 // The number of digits in the autonumber
            ]
        ];
    }
}
