<?php

namespace App\Controller\Spa\Report;

use Slim\Http\Request;
use Slim\Http\Response;
use App\Controller\Controller;
use App\Model\Spaterapis;
use App\Model\Option;
use App\Model\Spakasir;
use App\Model\Spakasirdetail;
use Illuminate\Database\Capsule\Manager as Capsule;

class TerapisReportController extends Controller
{
    public function __invoke(Request $request, Response $response, $args)
    {
        $data['app_profile'] = $this->app_profile;
        $data['terapis'] =Spaterapis::all();

        if ($request->isPost()) {

            $postData = $request->getParsedBody();
            $data["d_start"]=$postData["start"];
            $data["d_end"]=$postData["end"];

        } else {
            $data["d_start"]=date("d-m-Y");
            $data["d_end"]=date("d-m-Y",strtotime("tomorrow"));
        }

        $data['kinerjaterapis'] = Spakasirdetail::groupby('terapisid')
                                ->join('spakasir','spakasir.id','=','spakasirdetail.spakasir_id')
                                ->whereBetween('tanggal',array($this->convert_date($data["d_start"]), $this->convert_date($data["d_end"])))
                                ->select('terapisid',Capsule::raw('count(terapisid) as kuantitas'),Capsule::raw('sum(harga) as harga') )
                                ->orderby('harga', 'DESC')
                                ->get();
        return $this->renderer->render($response, 'spa/reports/terapis', $data);

    }

    public function printterapiskinerja(Request $request, Response $response, $args)
    {
        $data['app_profile'] = $this->app_profile;
        $data['terapis'] = Spaterapis::all();

        $opt = Option::all();

        $Option = [];
        foreach ($opt as $value) {
            $Option[$value->name] = $value->value;
        }
        $data['options'] = $Option;

        $data['kinerjaterapis'] = Spakasirdetail::groupby('terapisid')
                                ->join('spakasir','spakasir.id','=','spakasirdetail.spakasir_id')
                                ->whereBetween('tanggal',array($this->convert_date($args["start"]), $this->convert_date($args["end"])))
                                ->select('terapisid',Capsule::raw('count(terapisid) as kuantitas'),Capsule::raw('sum(harga) as harga') )
                                ->orderby('harga', 'DESC')
                                ->get();
        $data['start'] = $args['start'];
        return $this->renderer->render($response, 'spa/reports/terapis_print', $data);
    }

    public function printterapis(Request $request, Response $response, $args)
    {
        $data['app_profile'] = $this->app_profile;
        $data['terapis'] = Spaterapis::all();

        ///// get option ///
        $opt = Option::all();

        $Options=[];
        foreach ($opt as $value) {
            $Options[$value->name] = $value->value;
        }
        $data['options'] = $Options;
        ///// end get option ///
        return $this->renderer->render($response, 'spa/reports/terapis-print', $data);
    }

    private function convert_date($date){
        $exp = explode('-', $date);
        if (count($exp)==3) {
            $date = $exp[2].'-'.$exp[1].'-'.$exp[0];
        }
        return $date;
    }
}
