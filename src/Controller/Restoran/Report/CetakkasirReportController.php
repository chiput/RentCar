<?php

namespace App\Controller\Restoran\Report;

use Slim\Http\Request;
use Slim\Http\Response;
use App\Controller\Controller;
use App\Model\Reskasir;
use App\Model\Reskasirdetail;
use App\Model\Respesanan;
use App\Model\Option;
//use Kulkul\Options;
use Illuminate\Database\Capsule\Manager as Capsule;
class CetakkasirReportController extends Controller
{
    public function __invoke(Request $request, Response $response, $args)
    {
            $idtrans=$args['id'];
            // $data['catakkasirs']=Capsule::select("SELECT xx.* FROM (SELECT A.id,C.id as idpesanan,D.id as idpesanandetail,A.tanggal,A.nobukti,A.bayar,A.kembalian,E.nama,E.hargajual as hargamenu,D.kuantitas FROM reskasir A,reskasirdetail B,respesanan C, respesanandetail D, resmenu E WHERE A.id=B.id2 AND B.pesananid=C.id AND C.id=D.id2 AND D.menuid = E.id )xx where xx.id='$idtrans'");



$data['catakkasirs']=Capsule::select("SELECT xx.*,sum(xx.kuantitas) as kuantitasa FROM (SELECT A.id,C.id as idpesanan,D.id as idpesanandetail,E.id as idmenu,A.tanggal,A.nobukti,A.bayar,A.kembalian,E.nama,E.hargajual as hargamenu,D.kuantitas FROM reskasir A,reskasirdetail B,respesanan C, respesanandetail D, resmenu E WHERE A.id=B.id2 AND B.pesananid=C.id AND C.id=D.id2 AND D.menuid = E.id )xx where xx.id='$idtrans' group by xx.idmenu");
            

             // ='8'
                        
        ///// get option ///
        $opt = Option::all();
        $Options=[];
        foreach ($opt as $value) {
    		$Options[$value->name] = $value->value;
        }
        $data['options'] = $Options;
        ///// end get option ///
        return $this->renderer->render($response, 'restoran/reports/cetakkasir', $data);
    }

    public function cetakfrompesnan(Request $request, Response $response, $args){


            $idpesanan=$args['idpesanan'];


            $idtransa=Capsule::select("SELECT A.id FROM reskasir A,reskasirdetail B WHERE A.id=B.id2 and  B.pesananid='$idpesanan' ");

           
                $idtrans=$idtransa[0]->id;
            


$data['catakkasirs']=Capsule::select("SELECT xx.*,sum(xx.kuantitas) as kuantitasa FROM (SELECT A.id,C.id as idpesanan,D.id as idpesanandetail,E.id as idmenu,A.tanggal,A.nobukti,A.bayar,A.kembalian,E.nama,E.hargajual as hargamenu,D.kuantitas FROM reskasir A,reskasirdetail B,respesanan C, respesanandetail D, resmenu E WHERE A.id=B.id2 AND B.pesananid=C.id AND C.id=D.id2 AND D.menuid = E.id )xx where xx.id='$idtrans' group by xx.idmenu");
            

             // ='8'
                        
        ///// get option ///
        $opt = Option::all();
        $Options=[];
        foreach ($opt as $value) {
            $Options[$value->name] = $value->value;
        }
        $data['options'] = $Options;
        ///// end get option ///
        return $this->renderer->render($response, 'restoran/reports/cetakkasir', $data);

    }
}
