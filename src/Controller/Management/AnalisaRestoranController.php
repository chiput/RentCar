<?php

namespace App\Controller\Management;

use Slim\Http\Request;
use Slim\Http\Response;
use App\Controller\Controller;
use App\Model\Reskasirku;
use App\Model\Reskasirkudetail;
use App\Model\Reswaiter;
use Illuminate\Database\Capsule\Manager as DB;

class AnalisaRestoranController extends Controller
{
  
    public function meja(Request $request, Response $response, Array $args){

        $postData = $request->getParsedBody();

        if($request->isPost()){        
            $start=$postData["start"];
            $end=$postData["end"];
        }else{
            $start=date("d-m-Y");
            $end=date("d-m-Y");
        }

        $data["start"]=$this->convert_date($start);
        $data['end']=$this->convert_date($end);

        $data['datas'] = Reskasirku::whereBetween("tanggal",[$this->convert_date($start),$this->convert_date($end)])
                                    ->select(DB::raw('SUM(total) as totalbelanjaan, reskasirku.*,count(*) as jumlah'))
                                    ->groupBy('meja')
                                    ->get();

        return $this->renderer->render($response, 'management/table-favorit', $data);
    }  

    public function menu(Request $request, Response $response, Array $args){

        $postData = $request->getParsedBody();

        if($request->isPost()){        
            $start=$postData["start"];
            $end=$postData["end"];
        }else{
            $start=date("d-m-Y");
            $end=date("d-m-Y");
        }

        $data["start"]=$this->convert_date($start);
        $data['end']=$this->convert_date($end);

        $data['datas'] = Reskasirkudetail::join('reskasirku','reskasirku.id','=','reskasirkudetail.reskasirku_id')
                                    ->whereBetween("reskasirku.tanggal",[$this->convert_date($start),$this->convert_date($end)])
                                    ->select(DB::raw('reskasirkudetail.*,sum(kuantitas) as jumlah, sum(harga) as harga, count(*) as bill'))
                                    ->groupBy('menuid')
                                    ->orderBy('jumlah','DESC')
                                    ->get();

        return $this->renderer->render($response, 'management/menu-favorit', $data);
    }

    public function waiter(Request $request, Response $response, $args)
    {
        
        $data['app_profile'] = $this->app_profile;
        $data['waiters'] =Reswaiter::all();

        if ($request->isPost()) {

            $postData = $request->getParsedBody();
            $data["d_start"]=$postData["start"];
            $data["d_end"]=$postData["end"];

        } else {
            $data["d_start"]=date("d-m-Y");
            $data["d_end"]=date("d-m-Y",strtotime("tomorrow"));
        }

        $data['kinerja'] = Reskasirku::whereBetween('tanggal',array($this->convert_date($data["d_start"]), $this->convert_date($data["d_end"])))
                                        ->select('waiters_id',DB::raw('count(id) as kuantitas'),DB::raw('sum(total) as total') )
                                        ->groupby('waiters_id')
                                        ->orderby('total', 'DESC')
                                        ->get();

        return $this->renderer->render($response, 'management/kinerja-waiter', $data);


    }

    private function convert_date($date){
        $exp = explode('-', $date);
        if (count($exp)==3) {
            $date = $exp[2].'-'.$exp[1].'-'.$exp[0];
        }
        return $date;
    }

}
