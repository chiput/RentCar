<?php

namespace App\Controller\Restoran\Report;

use Slim\Http\Request;
use Slim\Http\Response;
use App\Controller\Controller;
use App\Model\Resmenu;
use App\Model\Option;
use App\Model\Reskasirku;
use App\Model\Reskasirkudetail;
use App\Model\Reskategori;
//use Kulkul\Options;
class MenuReportController extends Controller
{
    public function __invoke(Request $request, Response $response, $args)
    {
        $data['menus'] = Resmenu::orderBy('id', 'asc')
                            ->get();
           $data['menus']= $this->db->table('resmenu')
                        ->leftjoin('reskategori', 'resmenu.kategoriid', '=', 'reskategori.id')
                        ->select('resmenu.nama','reskategori.nama as katnama','resmenu.hargajual')
                        
                        ->orderBy('resmenu.id', 'asc')->get();
                        
        ///// get option ///
        $opt = Option::all();
        $Options=[];
        foreach ($opt as $value) {
    		$Options[$value->name] = $value->value;
        }
        $data['options'] = $Options;
        ///// end get option ///
        return $this->renderer->render($response, 'restoran/reports/menu', $data);
    }

    public function penjualanmenu(Request $request, Response $response, $args)
    {
        
        $postData = $request->getParsedBody();

        if($request->isPost()){
            $data["d_start"]=$postData["start"];
            $data["d_end"]=$postData["end"];
            $data['kategori'] =$postData["kategoriid"];

        } else {
            $data["d_start"]=date("d-m-Y");
            $data["d_end"]=date("d-m-Y",strtotime("tomorrow"));
            $data['kategori'] = 0;
        }

        $data['Menu_kategoris'] = Reskategori::all();
            $data['menus'] = Reskasirkudetail::groupBy('menuid')
                                ->join('resmenu','resmenu.id','=','reskasirkudetail.menuid')
                                ->join('reskasirku','reskasirku.id','=','reskasirkudetail.reskasirku_id')
                                ->selectRaw('SUM(reskasirkudetail.harga) as total, resmenu.*,reskasirku.tanggal')
                                ->whereBetween('reskasirku.tanggal',array($this->convert_date($data['d_start']),$this->convert_date($data['d_end'])))
                                ->get();

        if($postData["kategoriid"] > 0){
            $data['menus'] = Reskasirkudetail::groupBy('menuid')
                                ->join('resmenu','resmenu.id','=','reskasirkudetail.menuid')
                                ->join('reskasirku','reskasirku.id','=','reskasirkudetail.reskasirku_id')
                                ->selectRaw('SUM(reskasirkudetail.harga) as total, resmenu.*,reskasirku.tanggal')
                                ->where('resmenu.kategoriid','=',$postData["kategoriid"])
                                ->whereBetween('reskasirku.tanggal',array(convert_date($data['d_start']),convert_date($data['d_end'])))
                                ->get();
        }

        return $this->renderer->render($response, 'restoran/reports/penjualan-menu', $data);
    }

    public function penjualanmenureport(Request $request, Response $response, $args)
    {
        $data['start'] = $args['start'];
        $data['end'] = $args['end'];
        $data['menus'] = Reskasirkudetail::groupBy('menuid')
                                ->join('resmenu','resmenu.id','=','reskasirkudetail.menuid')
                                ->join('reskasirku','reskasirku.id','=','reskasirkudetail.reskasirku_id')
                                ->selectRaw('SUM(reskasirkudetail.harga) as total, resmenu.*,reskasirku.tanggal')
                                ->whereBetween('reskasirku.tanggal',array($this->convert_date($args['start']),$this->convert_date($args['end'])))
                                ->get();

        if($args["cat"] > 0){
            $data['menus'] = Reskasirkudetail::groupBy('menuid')
                                ->join('resmenu','resmenu.id','=','reskasirkudetail.menuid')
                                ->join('reskasirku','reskasirku.id','=','reskasirkudetail.reskasirku_id')
                                ->selectRaw('SUM(reskasirkudetail.harga) as total, resmenu.kategoriid,reskasirku.tanggal')
                                ->where('resmenu.kategoriid','=',$args["cat"])
                                ->whereBetween('reskasirku.tanggal',array($this->convert_date($args['start']),$this->convert_date($args['end'])))
                                ->get();
        }

        ///// get option ///
        $opt = Option::all();
        $Options=[];
        foreach ($opt as $value) {
            $Options[$value->name] = $value->value;
        }
        $data['options'] = $Options;
        ///// end get option ///

        return $this->renderer->render($response, 'restoran/reports/penjualan-menu-print', $data);
    }

    private function convert_date($date){
        $exp = explode('-', $date);
        if (count($exp)==3) {
            $date = $exp[2].'-'.$exp[1].'-'.$exp[0];
        }
        return $date;
    }
}
