<?php

namespace App\Controller\Management;

use Slim\Http\Request;
use Slim\Http\Response;
use App\Controller\Controller;
use App\Model\Storekasir;
use Illuminate\Database\Capsule\Manager as DB;

class StorePenjualanPerjamController extends Controller
{
  
    public function __invoke(Request $request, Response $response, Array $args){

        $postData = $request->getParsedBody();

        if($request->isPost()){        
            $start=$postData["start"];
            $end=$postData["end"];
        }else{
            $start=date("d-m-Y");
            $end=date("d-m-Y");
        }

        $data["start"]=$this->convert_date($start);
        $data['end']=$this->convert_date(date("d-m-Y",strtotime("tomorrow")));

        $data['datas'] = Storekasir::whereBetween("created_at",[$this->convert_date($start),$this->convert_date($end)])
                                                ->select(DB::raw('SUM(total) as jumlah, HOUR(created_at) as hour'))
                                                ->groupBy('hour')
                                                ->get();
        
        return $this->renderer->render($response, 'management/store-penjualan-perjam', $data);
    }  

    private function convert_date($date){
        $exp = explode('-', $date);
        if (count($exp)==3) {
            $date = $exp[2].'-'.$exp[1].'-'.$exp[0];
        }
        return $date;
    }

}
