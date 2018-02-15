<?php

namespace App\Controller\Logistic;

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

class KartuStokController extends Controller 
{
    public function __invoke(Request $request, Response $response, Array $args)
    {
        $data['goods'] = Barang::all();
        $data['app_profile'] = $this->app_profile;
        return $this->renderer->render($response, 'logistic/good', $data);   
    }

    public function stock_card(Request $request, Response $response, Array $args)
    {
        if($request->isPost()){
            $post = $request->getParsedBody();
            foreach ($post as $key) {
                $awal = $post['d_start']; 
                $post['d_start'] = $this->convert_date($awal); 
                $akhir = $post['d_end'];
                $post['d_end'] = $this->convert_date($akhir);            
            }

            $data = $post;

            $data['options'] = Options::all();
            
            if($post['barang_id']>0){
                $data['goods'] = Barang::where('id',"=",$post['barang_id'])->get();
            }else{
                $data['goods'] = Barang::all();
            }
            

            $reports=[];
            
            //barang dipakai
            $usages = $this->getTrans($post,"App\Model\Gudpakaidetail","gudpakai","gudang_id"); 
            $usage_totals = $this->getTotal($post,"App\Model\Gudpakaidetail","gudpakai","gudang_id"); 
            //barang diterima
            $receives = $this->getTrans($post,"App\Model\Gudterimadetail","gudterima","gudang_id"); 
            $receive_totals = $this->getTotal($post,"App\Model\Gudterimadetail","gudterima","gudang_id"); 
            
            
            $mutationIns = [];
            $mutationIn_totals = [];
            $mutationOuts = [];
            $mutationOut_totals = [];
            if($post['gudang_id'] != 0){
                //mutasi keluar gudang
                $mutationIns = $this->getTrans($post,"App\Model\Gudpindahdetail","gudpindah","gudang_id2"); 
                $mutationIn_totals = $this->getTotal($post,"App\Model\Gudpindahdetail","gudpindah","gudang_id2"); 
                //mutasi masuk gudang
                $mutationOuts = $this->getTrans($post,"App\Model\Gudpindahdetail","gudpindah","gudang_id1"); 
                $mutationOut_totals = $this->getTotal($post,"App\Model\Gudpindahdetail","gudpindah","gudang_id1"); 
            }
            
            //barang hilang
            $losses = $this->getTrans($post,"App\Model\Gudhilangdetail","gudhilang","gudang_id"); 
            $losse_totals = $this->getTotal($post,"App\Model\Gudhilangdetail","gudhilang","gudang_id"); 
            
            //revisis stok
            $revisions = $this->getTrans($post,"App\Model\Gudrevisidetail","gudrevisi","gudang_id"); 
            $revision_totals = $this->getTotal($post,"App\Model\Gudrevisidetail","gudrevisi","gudang_id"); 

            //retur
            $returns = $this->getReturn($post); 
            $return_totals = $this->getReturnTotal($post);  

            //resto
            $restos = $this->getResto($post); 
            $resto_totals = $this->getRestoTotal($post);  

            // print_r($returns);
            // return $response;


            //join semua array di atas
            $reports = array_merge($usages,$receives,$mutationIns,$mutationOuts,$losses,$revisions,$returns,$restos);
            $report_totals = array_merge($usage_totals,$receive_totals,$mutationIn_totals,$mutationOut_totals,$losse_totals,$revision_totals,$return_totals,$resto_totals);

            //var_dump($reports);

            //sorting berdasarkan tanggal
            usort($reports,function($a,$b){
                if($a->tanggal == $b->tanggal){ return 0 ; }
                return ($a->tanggal < $b->tanggal) ? -1 : 1;
            });
            
            //pindahkan pada array dengan key menggunakan id barang
            $reps = [];
            foreach($reports as $key => $report){
                $reps[$report->id][]=$report;
            }
            // echo "<pre>".print_r($report_totals,true)."</pre>";
            // return false;
            
            $data["reports"] = $reps;
            $totals = [];
            foreach($report_totals as $total){
                @$totals[$total["barang_id"]]["total"]+=$total["total"];
            }
            $data['totals']=$totals;

            
            // echo "<pre>".print_r($report_totals,true)."</pre>";
            // return false;
            if($post['view'] == 0 ) { //kondisi milih view all/detail
                return $this->renderer->render($response, 'logistic/reports/stock-card-report', $data); 
            } else {
                $data['gud'] = $post['gudang_id'];
                $data['gudangnya'] = Gudang::where('id','=',$post['gudang_id'])->get();
                return $this->renderer->render($response, 'logistic/reports/stock-card-all-report', $data);
            }

        } else {

            $data['app_profile'] = $this->app_profile;
            $data['goods'] = Barang::all();
            $data['warehouses'] = Gudang::all();
            return $this->renderer->render($response, 'logistic/reports/stock-card-form', $data);   
        }
         
    }

    private function getTrans($post, $model, $parent, $gudang){
        $trans = $model::whereHas($parent,function($q) use($post,$gudang){
            $query = $q->whereBetween('tanggal',[$post['d_start'],$post['d_end']]);
            if(@$post["gudang_id"] > 0) $query = $query->where($gudang,"=",$post['gudang_id']);
        });
        
        if(@$post["barang_id"] > 0) $trans = $trans->where("barang_id","=",$post['barang_id']);
        
        $trans = $trans->get();
        $arr = [];
        foreach($trans as $tran){
            $detail = (object)[
                            "id" => @$tran->good->id,
                            "kode" => @$tran->good->kode,
                            "nama" => @$tran->good->nama,
                            "nobukti" => $tran->$parent->nobukti,
                            "tanggal" => $tran->$parent->tanggal,
                            "keterangan" => $tran->$parent->keterangan,
                            "kuantitas" => $tran->kuantitas,
                            "satuan" => @$tran->unit->nama,
                            "parent" => $parent
                            ];
            if($parent == 'gudpakai' || $parent == 'gudhilang' || $parent == 'pembelianretur'){
                $detail->kuantitas = -$detail->kuantitas;
            }elseif($parent == 'gudpindah'){
                if($gudang == 'gudang_id1') $detail->kuantitas = -$detail->kuantitas;
            }
            
            $arr[]= $detail;
            
        }
        return $arr;
    }

    private function getTotal($post, $model, $parent, $gudang){
        $trans = $model::select(DB::raw("barang_id, sum(kuantitas) as total"))
            ->whereHas($parent,function($q) use($post,$gudang){
            $query = $q->where('tanggal','<',$post["d_start"]);
            if(@$post["gudang_id"] > 0) $query = $query->where($gudang,"=",$post['gudang_id']);
        })->groupBy('barang_id');
        if(@$post["barang_id"] > 0) $trans = $trans->where("barang_id","=",$post['barang_id']);
        $arr = $trans->get()->toArray();
        foreach($arr as $key => $ele){
            if($parent == 'gudpakai' || $parent == 'gudhilang'){
                $ele['total'] = -$ele['total'];
            }elseif($parent == 'gudpindah'){
                if($gudang == 'gudang_id1') $ele['total'] = -$ele['total'];
            }
            $arr[$key]=$ele;
        }

        return $arr;
    }

    private function getReturn($post){
        $returns = DB::table('pembelianreturdetail')
            ->select(DB::raw("`pembelianreturdetail`.`barang_id`,`barang`.`kode`, `barang`.`nama`,`pembelianreturdetail`.`kuantitas`, 
            `brgsatuan`.`nama` as satuan_nama,`pembelianretur`.`nobukti`, `pembelianretur`.`tanggal`, `pembelianretur`.`keterangan`"))
            ->join('pembelianretur','pembelianreturdetail.pembelianretur_id','=','pembelianretur.id')
            ->join('gudterima','pembelianretur.terima_id','=','gudterima.id')
            ->join('barang','pembelianreturdetail.barang_id','=','barang.id')
            ->join('brgsatuan','pembelianreturdetail.satuan_id','=','brgsatuan.id')
            ->whereBetween(DB::raw('`pembelianretur`.`tanggal`'),[$post['d_start'],$post['d_end']]);
        if($post["gudang_id"]!=0){
            $returns->where(DB::raw('`gudterima`.`gudang_id`'),'=',$post["gudang_id"]);
        }
        if($post["barang_id"]!=0){
            $returns->where(DB::raw('`pembelianreturdetail`.`barang_id`'),'=',$post["barang_id"]);
        }
        
        $trans = [];
        foreach($returns->get() as $tran){
            $detail = (object)[
                            "id" => $tran->barang_id,
                            "kode" => $tran->kode,
                            "nama" => $tran->nama,
                            "nobukti" => $tran->nobukti,
                            "tanggal" => $tran->tanggal,
                            "keterangan" => $tran->keterangan,
                            "kuantitas" => -$tran->kuantitas,
                            "satuan" => $tran->satuan_nama,
                            "parent" => 'pembelianretur'
                            ];
            $trans[] = $detail;
        }

        return $trans;
    }

    private function getReturnTotal($post){
        $returns = DB::table('pembelianreturdetail')
            ->select(DB::raw("`pembelianreturdetail`.`barang_id`, sum(`pembelianreturdetail`.`kuantitas`) as `total`"))
            ->join('pembelianretur','pembelianreturdetail.pembelianretur_id','=','pembelianretur.id')
            ->join('gudterima','pembelianretur.terima_id','=','gudterima.id')
            ->join('barang','pembelianreturdetail.barang_id','=','barang.id')
            ->join('brgsatuan','pembelianreturdetail.satuan_id','=','brgsatuan.id')
            ->where(DB::raw('`pembelianretur`.`tanggal`'),'<',$post['d_start']);
        if($post["gudang_id"]!=0){
            $returns->where(DB::raw('`gudterima`.`gudang_id`'),'=',$post["gudang_id"]);
        }
        if($post["barang_id"]!=0){
            $returns->where(DB::raw('`pembelianreturdetail`.`barang_id`'),'=',$post["barang_id"]);
        }
        $returns->groupBy(DB::raw('`pembelianreturdetail`.`barang_id`'));
        $res=$returns->get();
        
        $trans = [];
        foreach($res as $return){
            $trans[] = [
                "barang_id"=>$return->barang_id,
                "total"=>-$return->total
            ];
        }
        
        return $trans;
    }

    private function getResto($post){
        $returns = DB::table('barang')
            ->select(DB::raw("
            `barang`.`id`,
            `barang`.`kode`,
            `barang`.`nama`,
            `reskasir`.`nobukti`,
            `reskasir`.`tanggal`,
            `reskasir`.`keterangan`,
            (`respesanandetail`.`kuantitas` * `resmenudetail`.`kuantitas`) as `kuantitas_`,
            `brgsatuan`.`nama` as satuan_nama              
            "))
            ->join('brgsatuan','brgsatuan.id','=','barang.brgsatuan_id')
            ->join('resmenudetail','resmenudetail.barangid','=','barang.id')
            ->join('resmenu','resmenu.id','=','resmenudetail.id2')
            ->join('respesanandetail','resmenu.id','=','respesanandetail.menuid')
            ->join('respesanan','respesanan.id','=','respesanandetail.id2')
            ->join('reskasirdetail','respesanan.id','=','reskasirdetail.pesananid')
            ->join('reskasir','reskasir.id','=','reskasirdetail.id2')
            ->join('resgudang','resgudang.id','=','resmenudetail.gudangid')
            ->whereBetween(DB::raw('`reskasir`.`tanggal`'),[$post['d_start'],$post['d_end']]);
        
        if($post["gudang_id"]!=0){
            $returns->where(DB::raw('`resgudang`.`gudangid`'),'=',$post["gudang_id"]);
        }
        
        if($post["barang_id"]!=0){
            $returns->where(DB::raw('`barang`.`id`'),'=',$post["barang_id"]);
        }
        
        $trans = [];
        foreach($returns->get() as $tran){
            $detail = (object)[
                            "id" => $tran->id,
                            "kode" => $tran->kode,
                            "nama" => $tran->nama,
                            "nobukti" => $tran->nobukti,
                            "tanggal" => $tran->tanggal,
                            "keterangan" => $tran->keterangan,
                            "kuantitas" => -$tran->kuantitas_,
                            "satuan" => $tran->satuan_nama,
                            "parent" => 'pembelianretur'
                            ];
            $trans[] = $detail;
        }

        return $trans;
    }
    
    private function getRestoTotal($post){
        $returns = DB::table('barang')
            ->select(DB::raw("
            `barang`.`id`,
            sum(`respesanandetail`.`kuantitas` * `resmenudetail`.`kuantitas`) as `kuantitas_`
            "))
            ->join('resmenudetail','resmenudetail.barangid','=','barang.id')
            ->join('resmenu','resmenu.id','=','resmenudetail.id2')
            ->join('respesanandetail','resmenu.id','=','respesanandetail.menuid')
            ->join('respesanan','respesanan.id','=','respesanandetail.id2')
            ->join('reskasirdetail','respesanan.id','=','reskasirdetail.pesananid')
            ->join('reskasir','reskasir.id','=','reskasirdetail.id2')
            ->join('resgudang','resgudang.id','=','resmenudetail.gudangid')
            ->where(DB::raw('`reskasir`.`tanggal`'),'<',$post['d_start']);

        if($post["gudang_id"]!=0){
            $returns->where(DB::raw('`resgudang`.`gudangid`'),'=',$post["gudang_id"]);
        }
        
        if($post["barang_id"]!=0){
            $returns->where(DB::raw('`barang`.`id`'),'=',$post["barang_id"]);
        }

        $returns->groupBy(DB::raw('`barang`.`id`'));
        $res=$returns->get();
        
        $trans = [];
        foreach($res as $return){
            $trans[] = [
                "barang_id"=>$return->id,
                "total"=>-$return->kuantitas_
            ];
        }
        
        return $trans;
    }
    
    private function convert_date($date){
            $exp = explode('-', $date);
            if (count($exp)==3) {
                $date = $exp[2].'-'.$exp[1].'-'.$exp[0];
            }
            return $date;
        }
}