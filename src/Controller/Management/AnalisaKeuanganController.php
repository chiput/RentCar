<?php

namespace App\Controller\Management;

use Slim\Http\Request;
use Slim\Http\Response;
use App\Controller\Controller;

use App\Model\Accjurnaldetail;

use Illuminate\Database\Capsule\Manager as DB;

class AnalisaKeuanganController extends Controller
{
  
    public function __invoke(Request $request, Response $response, Array $args)
    {
        
        // $data['app_profile'] = $this->app_profile;
        $data["analisa"] = Accjurnaldetail::first();
        
        if ($request->isPost()) {

            $postData = $request->getParsedBody();

            $data["d_start"]=$postData["start"];
            $data["d_end"]=$postData["end"];
            $data['status']=$postData['status'];

        } else {
            $data['status']=1;
            $data["d_start"]=date("d-m-Y");
            $data["d_end"]=date("d-m-Y",strtotime("tomorrow"));
            
        }

        return $this->renderer->render($response, 'management/grafik-keuangan', $data);
    } 

    private function convert_date($date){
        $exp = explode('-', $date);
        if (count($exp)==3) {
            $date = $exp[2].'-'.$exp[1].'-'.$exp[0];
        }
        return $date;
    }

}
