<?php

namespace App\Controller\Restoran\Report;

use Slim\Http\Request;
use Slim\Http\Response;
use App\Controller\Controller;
use App\Model\Reswaiter;
use App\Model\Option;
use App\Model\Reskasirku;
use Illuminate\Database\Capsule\Manager as Capsule;
//use Kulkul\Options;
class WaitersReportController extends Controller
{
    public function __invoke(Request $request, Response $response, $args)
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
                                        ->select('waiters_id',Capsule::raw('count(id) as kuantitas'),Capsule::raw('sum(total) as total') )
                                        ->groupby('waiters_id')
                                        ->orderby('total', 'DESC')
                                        ->get();

        return $this->renderer->render($response, 'restoran/reports/waiters', $data);


    }

    public function printwaiter(Request $request, Response $response, $args)
    {
        $data['app_profile'] = $this->app_profile;
        $data['waiters'] =Reswaiter::all();

        ///// get option ///
        $opt = Option::all();

        $Options=[];
        foreach ($opt as $value) {
            $Options[$value->name] = $value->value;
        }
        $data['options'] = $Options;
        ///// end get option ///
        return $this->renderer->render($response, 'restoran/reports/waiters-print', $data);


    }

    public function printwaiterkinerja(Request $request, Response $response, $args)
    {
        $data['app_profile'] = $this->app_profile;
        $data['waiters'] =Reswaiter::all();

        ///// get option ///
        $opt = Option::all();

        $Options=[];
        foreach ($opt as $value) {
            $Options[$value->name] = $value->value;
        }
        $data['options'] = $Options;
        ///// end get option ///

        $data['kinerja'] = Reskasirku::whereBetween('tanggal',array($this->convert_date($args["start"]), $this->convert_date($args["end"])))
                                        ->select('waiters_id',Capsule::raw('count(id) as kuantitas'),Capsule::raw('sum(total) as total') )
                                        ->groupby('waiters_id')
                                        ->orderby('total', 'DESC')
                                        ->get();
        $data['start'] = $args['start'];
        return $this->renderer->render($response, 'restoran/reports/waiters-print', $data);


    }

    private function convert_date($date){
        $exp = explode('-', $date);
        if (count($exp)==3) {
            $date = $exp[2].'-'.$exp[1].'-'.$exp[0];
        }
        return $date;
    }
}
