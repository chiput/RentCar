<?php

namespace App\Controller\Restoran\Report;

use Illuminate\Database\Capsule\Manager as Capsule;
use Slim\Http\Request;
use Slim\Http\Response;
use App\Controller\Controller;
use App\Model\Resmenu;
use App\Model\Option;
use App\Model\Reskasirku;
use App\Model\Reskasirkudetail;
use App\Model\Reskategori;
use Kulkul\Options;
use Illuminate\Database\Capsule\Manager as DB;

class PenjualanRestoranReportController extends Controller
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
           $data['menus']= $this->db->table('reskasir')
                        ->leftjoin('reskasirdetail', 'reskasirdetail.id2', '=', 'reskasir.id')
                        ->leftjoin('respesanan', 'respesanan.id', '=', 'reskasirdetail.pesananid')
                        ->select('reskasir.tanggal','reskasir.nobukti','reskasir.tunai','reskasir.bayar','reskasir.nservice','reskasir.nppn',Capsule::raw('(reskasir.bayar+reskasir.nservice+reskasir.nppn) as total'))
                         ->where(Capsule::raw('SUBSTR(reskasir.created_at,1,10)'),'<=',convert_date($tglakhir))
                         ->where(Capsule::raw('SUBSTR(reskasir.created_at,1,10)'),'>=',convert_date($tglawal))
                        //->where('respesanan.cetak','=','1')//Di Disable karena yuwan gaapapuntenng yg masuk ke reskasir pasti sudah bayar
                        ->groupBy('reskasirdetail.pesananid')->get();
                      
                   
        ///// get option ///
        $opt = Option::all();
        $Options=[];
        foreach ($opt as $value) {
    		$Options[$value->name] = $value->value;
        }
        $data['options'] = $Options;
        ///// end get option ///
        return $this->renderer->render($response, 'restoran/reports/penjualanrestoran', $data);
    }

    public function rekappenjualan(Request $request, Response $response, $args)
    {
        

        $postData = $request->getParsedBody();

        if($request->isPost()){        
            $date=$postData["date"];
        }else{
            $date=date("d-m-Y");
        }

        $data['tanggal'] = $date;

        $data['menus'] = Reskasirku::where('tanggal','=',$this->convert_date($date))->get();

        return $this->renderer->render($response, 'restoran/reports/rekap-penjualan', $data);
    } 

    public function rekappenjualanprint(Request $request, Response $response, $args)
    {
        $postData = $request->getParsedBody();

        if($request->isPost()){        
            $date=$postData["date"];
        }else{
            $date=date("Y-m-d");
        }

        $data['tanggal'] = $date;

        $data['menus'] = Reskasirku::where('tanggal','=',$this->convert_date($date))->get();
        $data['options'] = Options::all();

        return $this->renderer->render($response, 'restoran/reports/rekap-penjualan-print', $data);
    } 

    public function laporanpenjualan(Request $request, Response $response, $args)
    {

      
        $postData = $request->getParsedBody();

        

        if($request->isPost()){        
            $date=$postData["date"];
            $data['kategori'] =$postData["kategoriid"];
        }else{
            $date=date("d-m-Y");
            $data['kategori'] = 0;
        }

        $data['tanggal'] = $date;
        $data['Menu_kategoris'] = Reskategori::all();
        $data['menus'] = Reskasirkudetail::groupBy('menuid')
                                ->join('resmenu','resmenu.id','=','reskasirkudetail.menuid')
                                ->join('reskasirku','reskasirku.id','=','reskasirkudetail.reskasirku_id')
                                ->selectRaw('SUM(reskasirkudetail.kuantitas) as total, resmenu.*,reskasirku.tanggal, SUM(reskasirku.diskon) as diskon')
                                ->where('reskasirku.tanggal','=',$this->convert_date($date))
                                ->get();
        if($postData["kategoriid"] > 0){
        $data['menus'] = Reskasirkudetail::groupBy('menuid')
                                ->join('resmenu','resmenu.id','=','reskasirkudetail.menuid')
                                ->join('reskasirku','reskasirku.id','=','reskasirkudetail.reskasirku_id')
                                ->selectRaw('SUM(reskasirkudetail.kuantitas) as total, resmenu.*,reskasirku.tanggal, SUM(reskasirku.diskon) as diskon')
                                ->where('resmenu.kategoriid','=',$postData["kategoriid"])
                                ->where('reskasirku.tanggal','=',$this->convert_date($date))
                                ->get();
        }
        // Perulangan service (menu tambahan) di restoran
        $data['services'] = Reskasirkudetail::groupBy('menuid')
                                ->join('reskasirku','reskasirku.id','=','reskasirkudetail.reskasirku_id')
                                ->where('reskasirku.tanggal','=',$this->convert_date($date))
                                ->selectRaw('SUM(reskasirkudetail.kuantitas) as totalqty, reskasirkudetail.*, reskasirku.*, SUM(reskasirkudetail.harga) as harga')
                                ->where('reskasirku.users_id','=',$this->session->get('activeUser')["id"])
                                ->get();

        return $this->renderer->render($response, 'restoran/reports/laporan-penjualan', $data);
    } 
    public function laporanpenjualanprint(Request $request, Response $response, $args)
    {
        $data['options'] = Options::all();  
         
        $data['tanggal'] = $args['date'];
        $data['menus'] = Reskasirkudetail::groupBy('menuid')
                                ->join('resmenu','resmenu.id','=','reskasirkudetail.menuid')
                                ->join('reskasirku','reskasirku.id','=','reskasirkudetail.reskasirku_id')
                                ->selectRaw('SUM(reskasirkudetail.kuantitas) as total, resmenu.*,reskasirku.tanggal, SUM(reskasirku.diskon) as diskon')
                                ->where('reskasirku.tanggal','=',$this->convert_date($args['date']))
                                ->get();
        if($args["id"] > 0){
        $data['menus'] = Reskasirkudetail::groupBy('menuid')
                                ->join('resmenu','resmenu.id','=','reskasirkudetail.menuid')
                                ->join('reskasirku','reskasirku.id','=','reskasirkudetail.reskasirku_id')
                                ->selectRaw('SUM(reskasirkudetail.kuantitas) as total, resmenu.*,reskasirku.tanggal, SUM(reskasirku.diskon) as diskon')
                                ->where('resmenu.kategoriid','=',$args["id"])
                                ->where('reskasirku.tanggal','=',$this->convert_date($args['date']))
                                ->get();
        }
        // Perulangan service (menu tambahan) di restoran
        $data['services'] = Reskasirkudetail::groupBy('menuid')
                                ->join('reskasirku','reskasirku.id','=','reskasirkudetail.reskasirku_id')
                                ->where('reskasirku.tanggal','=',$this->convert_date($args['date']))
                                ->selectRaw('SUM(reskasirkudetail.kuantitas) as totalqty, reskasirkudetail.*, reskasirku.*, SUM(reskasirkudetail.harga) as harga')
                                ->where('reskasirku.users_id','=',$this->session->get('activeUser')["id"])
                                ->get();

        return $this->renderer->render($response, 'restoran/reports/laporan-penjualan-print', $data);
    } 

    private function convert_date($date){
        $exp = explode('-', $date);
        if (count($exp)==3) {
            $date = $exp[2].'-'.$exp[1].'-'.$exp[0];
        }
        return $date;
    }

}
