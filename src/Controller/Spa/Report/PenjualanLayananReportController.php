<?php

namespace App\Controller\Spa\Report;

use Illuminate\Database\Capsule\Manager as Capsule;
use Slim\Http\Request;
use Slim\Http\Response;
use App\Controller\Controller;
use App\Model\Spalayanan;
use App\Model\Option;
//use Kulkul\Options;
class PenjualanLayananReportController extends Controller
{
    public function __invoke(Request $request, Response $response, $args)
    {   
            $postData = $request->getParsedBody();
            $tglawal=$postData['d_start'];
            $tglakhir=$postData['d_end'];
            $data['layanan']= $this->db->table('respesanan')
                        ->leftjoin('respesanandetail', 'respesanandetail.id2', '=', 'respesanan.id')
                        ->leftjoin('spalayanan', 'spalayanan.id', '=', 'respesanandetail.layananid')
                        ->select('spalayanan.nama_layanan','spalayanan.kode','spalayanan.hargajual',Capsule::raw('count(respesanandetail.layananid) as jumlahmenu'))
                        ->where(Capsule::raw('SUBSTR(respesanan.created_at,1,10)'),'<=',$tglakhir)
                        ->where(Capsule::raw('SUBSTR(respesanan.created_at,1,10)'),'>=',$tglawal)
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
