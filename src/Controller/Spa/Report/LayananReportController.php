<?php

namespace App\Controller\Spa\Report;

use Slim\Http\Request;
use Slim\Http\Response;
use App\Controller\Controller;
use App\Model\Spalayanan;
use App\Model\Option;
//use Kulkul\Options;
class LayananReportController extends Controller
{
    public function __invoke(Request $request, Response $response, $args)
    {
        $data['layanan'] = Spalayanan::orderBy('id', 'asc')
                            ->get();
           $data['layanan']= $this->db->table('spalayanan')
                        ->leftjoin('spakategori', 'spalayanan.kategoriid', '=', 'spakategori.id')
                        ->select('spalayanan.nama_layanan','spakategori.nama as katnama','spalayanan.hargajual')
                        
                        ->orderBy('spalayanan.id', 'asc')->get();
                        
        ///// get option ///
        $opt = Option::all();
        $Options=[];
        foreach ($opt as $value) {
    		$Options[$value->name] = $value->value;
        }
        $data['options'] = $Options;
        ///// end get option ///
        return $this->renderer->render($response, 'spa/reports/daftarlayanan', $data);
    }
}
