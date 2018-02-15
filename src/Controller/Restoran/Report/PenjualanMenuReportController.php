<?php

namespace App\Controller\Restoran\Report;

use Illuminate\Database\Capsule\Manager as Capsule;
use Slim\Http\Request;
use Slim\Http\Response;
use App\Controller\Controller;
use App\Model\Resmenu;
use App\Model\Option;
//use Kulkul\Options;
class PenjualanMenuReportController extends Controller
{
    public function __invoke(Request $request, Response $response, $args)
    {   
         function convert_date($date){
                    $exp = explode('-', $date);
                    if (count($exp)==3) {
                        $date = $exp[2].'-'.$exp[1].'-'.$exp[0];
                    }
                    return $date;
                }

            $postData = $request->getParsedBody();
            $tglawal=$postData['d_start'];
            $tglakhir=$postData['d_end'];
           $data['menus']= $this->db->table('respesanan')
                        ->leftjoin('respesanandetail', 'respesanandetail.id2', '=', 'respesanan.id')
                        ->leftjoin('resmenu', 'resmenu.id', '=', 'respesanandetail.menuid')
                        ->select('resmenu.nama','resmenu.kode','resmenu.hargajual',Capsule::raw('count(respesanandetail.menuid) as jumlahmenu'))
                        ->where(Capsule::raw('SUBSTR(respesanan.created_at,1,10)'),'<=',convert_date($tglakhir))
                        ->where(Capsule::raw('SUBSTR(respesanan.created_at,1,10)'),'>=',convert_date($tglawal))
                        ->where('respesanan.cetak','=','1')
                        
                        ->groupBy('respesanandetail.menuid')->get();
                        
        ///// get option ///
        $opt = Option::all();
        $Options=[];
        foreach ($opt as $value) {
    		$Options[$value->name] = $value->value;
        }
        $data['options'] = $Options;
        ///// end get option ///
        return $this->renderer->render($response, 'restoran/reports/penjualanmenu', $data);
    }
}
