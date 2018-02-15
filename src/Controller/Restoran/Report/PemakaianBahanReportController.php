<?php

namespace App\Controller\Restoran\Report;

use Illuminate\Database\Capsule\Manager as Capsule;
use Slim\Http\Request;
use Slim\Http\Response;
use App\Controller\Controller;
use App\Model\Option;
//use Kulkul\Options;
class PemakaianBahanReportController extends Controller
{
    public function __invoke(Request $request, Response $response, $args)
    {   
            $postData = $request->getParsedBody();
            $tglawal=$postData['d_start'];
            $tglakhir=$postData['d_end'];
           $data['menus']= $this->db->table('respesanan')
                        ->leftjoin('respesanandetail', 'respesanandetail.id2', '=', 'respesanan.id')
                        ->leftjoin('resmenu', 'resmenu.id', '=', 'respesanandetail.menuid')
                        ->leftjoin('resmenudetail', 'resmenudetail.id2', '=', 'resmenu.id')
                        ->leftjoin('barang', 'barang.id', '=', 'resmenudetail.barangid')
                        ->leftjoin('brgsatuan', 'brgsatuan.id', '=', 'barang.brgsatuan_id')
                        ->select('barang.nama','barang.kode','resmenu.hargajual',Capsule::raw('count(resmenudetail.barangid) as jumlahmenu'),'brgsatuan.nama as satuanama')
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
        return $this->renderer->render($response, 'restoran/reports/pemakaianbahan', $data);
    }
}
