<?php

namespace App\Controller\Management;

use Slim\Http\Request;
use Slim\Http\Response;
use App\Controller\Controller;
use App\Model\Spakasirdetail;
use Illuminate\Database\Capsule\Manager as DB;

class AnalisaSpaController extends Controller
{
  
    public function terapis(Request $request, Response $response, $args)
    {
        
        $data['app_profile'] = $this->app_profile;

        if ($request->isPost()) {

            $postData = $request->getParsedBody();
            $data["d_start"]=$postData["start"];
            $data["d_end"]=$postData["end"];

        } else {
            $data["d_start"]=date("d-m-Y");
            $data["d_end"]=date("d-m-Y",strtotime("tomorrow"));
        }

        $data['kinerja'] = Spakasirdetail::join('spakasir','spakasir.id','=','spakasirdetail.spakasir_id')
                                        ->whereBetween('spakasir.tanggal',[$this->convert_date($data["d_start"]), $this->convert_date($data["d_end"])])
                                        ->select('spakasirdetail.*',DB::raw('count(spakasirdetail.id) as kuantitas, sum(spakasirdetail.harga) as total') )
                                        ->groupby('spakasirdetail.terapisid')
                                        ->orderby('total', 'DESC')
                                        ->get();

        return $this->renderer->render($response, 'management/kinerja-terapis', $data);
    }

    public function layanan(Request $request, Response $response, Array $args){

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

        $data['datas'] = Spakasirdetail::join('spakasir','spakasir.id','=','spakasirdetail.spakasir_id')
                                    ->whereBetween('spakasir.tanggal',[$this->convert_date($start), $this->convert_date($end)])
                                    ->select(DB::raw('spakasirdetail.*,sum(spakasirdetail.kuantitas) as jumlah, sum(spakasirdetail.harga) as harga'))
                                    ->groupBy('layananid')
                                    ->orderBy('jumlah','DESC')
                                    ->get();

        return $this->renderer->render($response, 'management/layanan-favorit', $data);
    }

    private function convert_date($date){
        $exp = explode('-', $date);
        if (count($exp)==3) {
            $date = $exp[2].'-'.$exp[1].'-'.$exp[0];
        }
        return $date;
    }

}
