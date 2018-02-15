<?php

namespace Kulkul\LogisticStock;

use Slim\Http\Request;
use Slim\Http\Response;
use App\Controller\Controller;
use App\Model\Brgsatuan;
use App\Model\Account;
use App\Model\Brgkategori;
use App\Model\Barang;
use App\Model\Gudang;
use App\Model\Gudpakai; //pemakaian barang
use App\Model\Gudpakaidetail; //pemakaian barang
use App\Model\Gudterima; //penerimaan barang
use App\Model\Gudterimadetail; //penerimaan barang
use App\Model\Gudpindah; //mutasi gudang
use App\Model\Gudpindahdetail; //mutasi gudang
use App\Model\Gudhilang; //barang rusak & hilang
use App\Model\Gudhilangdetail; //barang rusak & hilang
use App\Model\Gudrevisi; //revisi stok
use App\Model\Gudrevisidetail; //revisi stok
use App\Model\Reskasir; //kasir restoran
use App\Model\Resgudang; //gudang restoran
use Kulkul\Options;
use Illuminate\Database\Capsule\Manager as DB;


class LogisticStockProvider
{

    public function __construct(){

    }
    /*
      mengecek stok akhir pada tanggal, gudang, kategori dan barang tertentu
      kode stok tampilan kondisi stok 0 = stok kosong, 1 = stok minimal, 2 = stok tidak kosong
    */
    public function getStock($date, $gudang_id, $kategori_id, $barang_id, $stok)
    {
            $data['options'] = Options::all();

            $data['warehouse'] = (object)[];
            if($gudang_id > 0) $data['warehouse'] = Gudang::find($gudang_id);

            if($kategori_id>0){
                $data['categories'] = Brgkategori::where('id',"=",$kategori_id)->get();
            }else{
                $data['categories'] = Brgkategori::all();
            }

            if($barang_id>0){
                $data['categories'] = Brgkategori::whereHas('goods',function($q) use($barang_id){
                    $q->where('id',"=",$barang_id);
                })->get();
                //echo $data['categories'];
            }


            $reports=[];

            //barang dipakai
            $usage_totals = $this->getTotal($date, $gudang_id, $barang_id, $kategori_id,"App\Model\Gudpakaidetail","gudpakai","gudang_id");
            //barang diterima
            $receive_totals = $this->getTotal($date, $gudang_id, $barang_id, $kategori_id,"App\Model\Gudterimadetail","gudterima","gudang_id");
            // var_dump($receive_totals); return $response;


            $mutationIn_totals = [];
            $mutationOut_totals = [];
            if($gudang_id != 0){
                //mutasi keluar gudang
                $mutationIn_totals = $this->getTotal($date, $gudang_id, $barang_id, $kategori_id,"App\Model\Gudpindahdetail","gudpindah","gudang_id2");
                //mutasi masuk gudang
                $mutationOut_totals = $this->getTotal($date, $gudang_id, $barang_id, $kategori_id,"App\Model\Gudpindahdetail","gudpindah","gudang_id1");
            }

            //barang hilang
            $losse_totals = $this->getTotal($date, $gudang_id, $barang_id, $kategori_id,"App\Model\Gudhilangdetail","gudhilang","gudang_id");

            //revisis stok
            $revision_totals = $this->getTotal($date, $gudang_id, $barang_id, $kategori_id,"App\Model\Gudrevisidetail","gudrevisi","gudang_id");

            //retur
            $return_totals = $this->getReturnTotal($date, $gudang_id, $barang_id, $kategori_id);

            //resto
            $resto_totals = $this->getRestoTotal($date, $gudang_id, $barang_id, $kategori_id);

            // return $response;

            //join semua array di atas
            $report_totals = array_merge($usage_totals,$receive_totals,$mutationIn_totals,$mutationOut_totals,$losse_totals,$revision_totals,$return_totals,$resto_totals);
            // var_dump($report_totals); return $response;


            //pindahkan pada array dengan key menggunakan id barang

            //echo "<pre>".print_r($report_totals,true)."</pre>";



            // var_dump($report_totals);
            $arr=[];
            foreach($report_totals as $rep){
                // var_dump($rep);
                if(!isset($arr[$rep['barang_id']])) {
                    $arr[$rep['barang_id']]["total"]=$rep['total'];
                    $arr[$rep['barang_id']]["minimal"]=$rep['minimal'];
                }else{
                // if()
                $arr[$rep['barang_id']]["total"]+=$rep['total'];
                $arr[$rep['barang_id']]["minimal"]=$rep['minimal'];
                }
            }
            // var_dump($arr);
            // return false;

            //filter stok
            foreach($arr as $key=>$ele){
                switch ($stok){
                    case 0:
                        if($ele["total"] > 0 ) unset($arr[$key]); // stok yang kosong
                    break;
                    case 1:
                        if($ele["total"] > $ele["minimal"] ) unset($arr[$key]); //stok minimal
                    break;
                    default:
                        if($ele["total"] <= 0 ) unset($arr[$key]);  //stok lebih besar dari 0
                }
            }


            $data['totals'] = $arr;
            $data['barang_id'] = $barang_id;
            $data['stok'] = $stok;


            // var_dump($data['totals']);
            // return false;

            return $data;


    }

    private function getTotal($date, $gudang_id, $barang_id, $kategori_id, $model, $parent, $gudang){
        $trans = $model::select(DB::raw("barang_id, sum(kuantitas) as total"))
            ->whereHas($parent,function($q) use($date,$gudang_id,$gudang){
                $query = $q->where('tanggal','<=',$date);
                if(@$gudang_id > 0) $query = $query->where($gudang,"=",$gudang_id);

            });
        if($kategori_id > 0){
            //before
            //$trans->whereHas('good',function($q) use($data){
            //after
            $trans->whereHas('good',function($q) use($kategori_id){
                $query = $q->where('brgkategori_id',"=",$kategori_id);
            });
        }
        $trans->groupBy('barang_id');
        if(@$barang_id > 0) $trans = $trans->where("barang_id","=",$barang_id);
        $arr = [];

        //var_dump($trans->get());
        foreach($trans->get() as $key => $ele){
            if($parent == 'gudpakai' || $parent == 'gudhilang'){
                $ele['total'] = -$ele['total'];
            }elseif($parent == 'gudpindah'){
                if($gudang == 'gudang_id1') $ele['total'] = -$ele['total'];
            }
            $arr[]=[
                'barang_id'=>$ele->barang_id,
                'total'=>$ele->total,
                'parent'=>$parent,
                'kategori'=>@$ele->good->brgkategori_id,
                'minimal'=>@$ele->good->minimal,
            ];

        }

        return $arr;
    }


    private function getReturnTotal($date, $gudang_id, $barang_id, $kategori_id){
        $returns = DB::table('pembelianreturdetail')
            ->select(DB::raw("`pembelianreturdetail`.`barang_id`, sum(`pembelianreturdetail`.`kuantitas`) as `total`, `barang`.`brgkategori_id`, `barang`.`minimal`"))
            ->join('pembelianretur','pembelianreturdetail.pembelianretur_id','=','pembelianretur.id')
            ->join('gudterima','pembelianretur.terima_id','=','gudterima.id')
            ->join('barang','pembelianreturdetail.barang_id','=','barang.id')
            ->join('brgsatuan','pembelianreturdetail.satuan_id','=','brgsatuan.id')
            ->where('pembelianretur.tanggal','<=',$date);

        if(@$kategori_id > 0)
            $returns->where(DB::raw('`barang`.`brgkategori_id`'),'=',$kategori_id);

        if(@$gudang_id!=0)
            $returns->where(DB::raw('`gudterima`.`gudang_id`'),'=',$gudang_id);

        if($barang_id!=0)
            $returns->where(DB::raw('`pembelianreturdetail`.`barang_id`'),'=',$barang_id);

        $returns->groupBy(DB::raw('`pembelianreturdetail`.`barang_id`'));
        $res=$returns->get();

        $trans = [];
        foreach($res as $return){
            $trans[] = [
                "barang_id"=>$return->barang_id,
                "total"=>-$return->total,
                "parent"=>'pembelianretur',
                "kategori"=>$return->brgkategori_id,
                "minimal"=>$return->minimal,
            ];
        }

        return $trans;
    }



    private function getRestoTotal($date, $gudang_id, $barang_id, $kategori_id){
        $returns = DB::table('barang')
            ->select(DB::raw("
            `barang`.`id`,
            `barang`.`brgkategori_id`,
            `barang`.`minimal`,
            sum(`respesanandetail`.`kuantitas` * `resmenudetail`.`kuantitas`) as `kuantitas_`
            "))
            ->join('resmenudetail','resmenudetail.barangid','=','barang.id')
            ->join('resmenu','resmenu.id','=','resmenudetail.id2')
            ->join('respesanandetail','resmenu.id','=','respesanandetail.menuid')
            ->join('respesanan','respesanan.id','=','respesanandetail.id2')
            ->join('reskasirdetail','respesanan.id','=','reskasirdetail.pesananid')
            ->join('reskasir','reskasir.id','=','reskasirdetail.id2')
            ->join('resgudang','resgudang.id','=','resmenudetail.gudangid')
            ->where('reskasir.tanggal','<=',$date);

        if(@$kategori_id > 0)
            $returns->where(DB::raw('`barang`.`brgkategori_id`'),'=',$kategori_id);

        if($gudang_id!=0)
            $returns->where(DB::raw('`resgudang`.`gudangid`'),'=',$gudang_id);

        if($barang_id!=0)
            $returns->where(DB::raw('`barang`.`id`'),'=',$barang_id);

        $returns->groupBy(DB::raw('`barang`.`id`'));
        $res=$returns->get();

        $trans = [];
        foreach($res as $return){
            $trans[] = [
                "barang_id"=>$return->id,
                "total"=>-$return->kuantitas_,
                "parent"=>'reskasir',
                "kategori"=>$return->brgkategori_id,
                "minimal"=>$return->minimal,
            ];
        }

        return $trans;
    }

}
