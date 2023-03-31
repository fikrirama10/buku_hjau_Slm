<?php

namespace App\Http\Controllers;

use App\Models\Tarif;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PhpParser\Node\Expr\FuncCall;
use Yajra\DataTables\Facades\DataTables;

class TarifController extends Controller
{
    public function get_tarif_id($id){
        $tarif = Tarif::where('id',$id)->first();
        return $tarif;
    }
    public function get_tarif(Request $request){
        $term = trim($request->q);
        if (empty($term)) {
            return response()->json([]);
        }

        $filterResult = Tarif::where('nama_tarif', 'LIKE', "%$term%")->get();
        $formatted_tags = [];
        foreach ($filterResult as $tag) {
            
            $formatted_tags[] = ['id' => $tag->id, 'text' => $tag->kode_tarif.'-'.$tag->nama_tarif.' : Rp.'.number_format($tag->nominal_tarif,2,',','.')];
        }
        return response()->json($formatted_tags);
    }
    public function index(){
        if (request()->ajax()) {
            $data = DB::table('tarif')->join('tarif_kategori','tarif.kategori_tarif','=','tarif_kategori.id')->select([
                'tarif.*',
                'tarif_kategori.kategori_tarif as tarif_kategori',
            ]);
            return DataTables::query($data)->addColumn('action',function($data){
                $html = '<a href="'.route('detail-tarif',$data->id).'" class="btn btn-info">Lihat</a>';
                return $html;
            })->make(true);
        }
        $kategori = DB::table('tarif_kategori')->get();
        return view('tarif.index',[
            'title'=>'Tarif',
            'id'=>'Data Tarif',
        ],compact('kategori'));
    }
    public function post_tarif(Request $request){
        $data = [
            'nama_tarif'=>$request->nama_tarif,
            'nominal_tarif'=>$request->harga_tarif,
            'kategori_tarif'=>$request->kategori_tarif,            
            'status_tarif'=>'aktif',            
        ];

        Tarif::create($data);
        return back();
    }

    public function detail_tarif($id){
        $tarif = Tarif::join('tarif_kategori','tarif.kategori_tarif','=','tarif_kategori.id')->select([
            'tarif.*',
            'tarif_kategori.kategori_tarif as tarif_kategori',
        ])->where('tarif.id',$id)->first();
        $tarif_detail = DB::table('tarif_detail')->leftJoin('unit_transaksi','tarif_detail.id_unit','=','unit_transaksi.id')->select([
            'tarif_detail.*',
            'unit_transaksi.unit'
        ])->where('id_Tarif',$id)->get();
        $unit = DB::table('unit_transaksi')->get();
        return view('tarif.detail',[
           'title'=>'Tarif Detail',
           'id'=>'tarif', 
        ],compact('tarif','tarif_detail','unit'));
    }
    public function delete_detail($id){
        DB::table('tarif_detail')->where('id',$id)->delete();
        return back();
    }
    public function post_detail_tarif(Request $request ,$id){
        $data = [
            'id_unit'=>$request->unit,
            'id_tarif'=>$id,
            'nominal'=>$request->nominal,
            'keterangan'=>$request->keterangan,
        ];
        DB::table('tarif_detail')->insert($data);
        return back();
    }
}
