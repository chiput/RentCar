<?php

namespace App\Controller\Spa\Report;

use Illuminate\Database\Capsule\Manager as Capsule;
use Slim\Http\Request;
use Slim\Http\Response;
use App\Controller\Controller;
use App\Model\Spalayanan;
use App\Model\Option;
use App\Model\Spakasir;
use App\Model\Spakasirdetail;
use App\Model\Spakategori;
use Kulkul\Options;
use Illuminate\Database\Capsule\Manager as DB;

class PenjualanSpaReportController extends Controller
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
            $data['layanan']= $this->db->table('spakasir')
                        ->leftjoin('spakasirdetail', 'spakasirdetail.id2', '=', 'spakasir.id')
                        ->select('spakasir.tanggal','spakasir.nobukti','spakasir.tunai','spakasir.bayar','spakasir.nservice','spakasir.nppn',Capsule::raw('(spakasir.bayar+spakasir.nservice+spakasir.nppn) as total'))
                         ->where(Capsule::raw('SUBSTR(spakasir.created_at,1,10)'),'<=',convert_date($tglakhir))
                         ->where(Capsule::raw('SUBSTR(spakasir.created_at,1,10)'),'>=',convert_date($tglawal))
                        //->where('respesanan.cetak','=','1')//Di Disable karena yuwan gaapapuntenng yg masuk ke reskasir pasti sudah bayar
                        ->groupBy('spakasirdetail.id')->get();
                      
                        
       // get option //
        $opt = Option::all();
        $Options=[];
        foreach ($opt as $value) {
    		$Options[$value->name] = $value->value;
        }
        $data['options'] = $Options;
        // end get option //
        return $this->renderer->render($response, 'spa/reports/penjualanspa', $data);
    }

    public function rekappenjualanspa(Request $request, Response $response, $args)
    {
         function convert_date($date){
                    $exp = explode('-', $date);
                    if (count($exp)==3) {
                        $date = $exp[2].'-'.$exp[1].'-'.$exp[0];
                    }
                    return $date;
                }

         
        $postData = $request->getParsedBody();

        if($request->isPost()){        
            $date=$postData["date"];
        }else{
            $date=date("d-m-Y");
        }

        $data['tanggal'] = $date;


        $data['layanan'] = Spakasir::where('tanggal','=',$this->convert_date($date))->get();

        return $this->renderer->render($response, 'spa/reports/rekap-penjualan-spa', $data);
    } 

    public function rekappenjualanspaprint(Request $request, Response $response, $args)
    {
        $postData = $request->getParsedBody();

        function convert_date($date){
                    $exp = explode('-', $date);
                    if (count($exp)==3) {
                        $date = $exp[2].'-'.$exp[1].'-'.$exp[0];
                    }
                    return $date;
                }

        if($request->isPost()){        
            $date=$postData["date"];
        }else{
            $date=date("Y-m-d");
        }

        $data['tanggal'] = $date;

        $data['layanan'] = Spakasir::where('tanggal','=',$this->convert_date($date))->get();
        
        $data['options'] = Options::all();

        return $this->renderer->render($response, 'spa/reports/rekap-penjualan-spa-print', $data);
    } 

    public function laporanpenjualanspa(Request $request, Response $response, $args)
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
        $data['layanan_kategori'] = Spakategori::all();
        $data['layanan'] = Spakasirdetail::groupBy('layananid')
                                ->join('spalayanan','spalayanan.id','=','spakasirdetail.layananid')
                                ->join('spakasir','spakasir.id','=','spakasirdetail.spakasir_id')
                                ->selectRaw('SUM(spakasirdetail.kuantitas) as total, spalayanan.*,spakasir.tanggal')
                                ->where('spakasir.tanggal','=',$this->convert_date($date))
                                ->get();
        if($postData["kategoriid"] > 0){
        $data['layanan'] = spakasirdetail::groupBy('layananid')
                                ->join('spalayanan','spalayanan.id','=','spakasirdetail.layananid')
                                ->join('spakasir','spakasir.id','=','spakasirdetail.spakasir_id')
                                ->selectRaw('SUM(spakasirdetail.kuantitas) as total, spalayanan.*,spakasir.tanggal')
                                ->where('spalayanan.kategoriid','=',$postData["kategoriid"])
                                ->where('spakasir.tanggal','=',$this->convert_date($date))
                                ->get();
        }

        return $this->renderer->render($response, 'spa/reports/laporan-penjualan-spa', $data);
    } 
    public function laporanpenjualanspaprint(Request $request, Response $response, $args)
    {
        $data['tanggal']=$args['date']; 
        $data['options'] = Options::all();  
        
        $data['layanan'] = spakasirdetail::groupBy('layananid')
                                ->join('spalayanan','spalayanan.id','=','spakasirdetail.layananid')
                                ->join('spakasir','spakasir.id','=','spakasirdetail.spakasir_id')
                                ->selectRaw('SUM(spakasirdetail.kuantitas) as total, spalayanan.*,spakasir.tanggal, SUM(spakasir.diskon) as diskon')
                                ->where('spakasir.tanggal','=',$this->convert_date($args['date']))
                                ->get();
        if($args["id"] > 0){
        $data['layanan'] = spakasirdetail::groupBy('layananid')
                                ->join('spalayanan','spalayanan.id','=','spakasirdetail.layananid')
                                ->join('spakasir','spakasir.id','=','spakasirdetail.spakasir_id')
                                ->selectRaw('SUM(spakasirdetail.kuantitas) as total, spalayanan.*,spakasir.tanggal, SUM(spakasir.diskon) as diskon')
                                ->where('spalayanan.kategoriid','=',$args["id"])
                                ->where('spakasir.tanggal','=',$this->convert_date($args['date']))
                                ->get();
        }

        return $this->renderer->render($response, 'spa/reports/laporan-penjualan-spa-print', $data);
    }

    public function convert_date($date){
        $exp = explode('-', $date);
        if (count($exp)==3) {
            $date = $exp[2].'-'.$exp[1].'-'.$exp[0];
        }
        return $date;
    } 
}
