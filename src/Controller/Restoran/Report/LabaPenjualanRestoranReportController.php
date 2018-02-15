<?php

namespace App\Controller\Restoran\Report;

use Illuminate\Database\Capsule\Manager as Capsule;
use Slim\Http\Request;
use Slim\Http\Response;
use App\Controller\Controller;
use App\Model\Resmenu;
use App\Model\Option;
//use Kulkul\Options;
class LabaPenjualanRestoranReportController extends Controller
{
    public function __invoke(Request $request, Response $response, $args)
    {   
            $postData = $request->getParsedBody();
            $tglawal=$postData['d_start'];
            $tglakhir=$postData['d_end'];   
            $first = $this->db->table('resmenu')
                        ->leftjoin('respesanandetail', 'respesanandetail.menuid', '=', 'resmenu.id')
                        ->leftjoin('respesanan', 'respesanan.id', '=', 'respesanandetail.id2')
                        ->leftjoin('reskasirdetail', 'reskasirdetail.pesananid', '=', 'respesanan.id')
                       
                        ->join('reskasir', 'reskasir.id', '=', 'reskasirdetail.id')
                        ->select('reskasir.tanggal','reskasir.nobukti','resmenu.nama',Capsule::raw('count(respesanandetail.kuantitas) as kuantitas'),Capsule::raw('(0) as modal'),'resmenu.hargajual')
                         // ->where(Capsule::raw('SUBSTR(reskasir.created_at,1,10)'),'<=',$tglakhir)
                         // ->where(Capsule::raw('SUBSTR(reskasir.created_at,1,10)'),'>=',$tglawal)
                        //->where('respesanan.cetak','=','1')//Di Disable karena yuwan gaapapuntenng yg masuk ke reskasir pasti sudah bayar
                        ->groupBy('resmenu.id');

            $data['menus']= $this->db->table('barang')
                        ->leftjoin('resmenudetail', 'resmenudetail.barangid', '=', 'barang.id')
                        ->leftjoin('resmenu', 'resmenudetail.id2', '=', 'resmenu.id')
                        ->leftjoin('respesanandetail', 'respesanandetail.menuid', '=', 'resmenu.id')
                        ->leftjoin('respesanan', 'respesanan.id', '=', 'respesanandetail.id2')
                        ->leftjoin('reskasirdetail', 'reskasirdetail.pesananid', '=', 'respesanan.id')
                       
                        ->join('reskasir', 'reskasir.id', '=', 'reskasirdetail.id')
                        ->select('reskasir.tanggal','reskasir.nobukti','barang.nama',Capsule::raw('count(resmenudetail.kuantitas) as kuantitas'),Capsule::raw('(barang.hargastok) as modal'),'barang.hargajual')
                         // ->where(Capsule::raw('SUBSTR(reskasir.created_at,1,10)'),'<=',$tglakhir)
                         // ->where(Capsule::raw('SUBSTR(reskasir.created_at,1,10)'),'>=',$tglawal)
                        //->where('respesanan.cetak','=','1')//Di Disable karena yuwan gaapapuntenng yg masuk ke reskasir pasti sudah bayar

                        ->groupBy('resmenu.id')
                        ->union($first)->get();

                      
                        
        ///// get option ///
        $opt = Option::all();
        $Options=[];
        foreach ($opt as $value) {
    		$Options[$value->name] = $value->value;
        }
        $data['options'] = $Options;
        ///// end get option ///
        return $this->renderer->render($response, 'restoran/reports/labapenjualanrestoran', $data);
    }
}
