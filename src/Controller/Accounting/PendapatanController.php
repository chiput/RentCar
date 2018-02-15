<?php

namespace App\Controller\Accounting;

use Slim\Http\Request;
use Slim\Http\Response;
use App\Model\Reskasirku;
use App\Model\Spakasir;
use App\Model\Addchargedetail;
use App\Model\CheckOut;
use App\Controller\Controller;
use Kulkul\Accounting\AccountingServiceProvider;
use Illuminate\Database\Capsule\Manager as DB;
use Kulkul\Options;

class PendapatanController extends Controller
{
    public function restorante(Request $request, Response $response, $args)
    {
         // app profile
        $data['app_profile'] = $this->app_profile;


        if($request->isPost()){

            $postData = $request->getParsedBody();
                
            $data['d_start'] = $postData['start'];
            $data['d_end'] = $postData['end'];

            $start = $this->convert($postData['start']);
            $end = $this->convert($postData['end']);

            $data['options'] = Options::all();

            //Keterangan
            $data['judul'] = "Laporan Pendapatan Restorante Italia";
            $data['identitas'] = "restorante";

            $data['datas'] = Reskasirku::whereBetween("tanggal",[$start,$end])
                                                    ->where('resto','=',1)
                                                    ->get();

            return $this->renderer->render($response, 'accounting/report/pendapatan-report', $data);
        } else {
            
            $data['judul'] = "Laporan Pendapatan Restorante Italia";
            $data['pendapatan'] = 'restorante';

            return $this->renderer->render($response, 'accounting/report/pendapatan-form', $data);
        }
    }

    public function whitehouse(Request $request, Response $response, $args)
    {
        // app profile
        $data['app_profile'] = $this->app_profile;


        if($request->isPost()){

            $postData = $request->getParsedBody();
                
            $data['d_start'] = $postData['start'];
            $data['d_end'] = $postData['end'];

            $start = $this->convert($postData['start']);
            $end = $this->convert($postData['end']);

            $data['options'] = Options::all();

            //Keterangan
            $data['judul'] = "Laporan Pendapatan White Horse";
            $data['identitas'] = "whitehouse";

            $data['datas'] = Reskasirku::whereBetween("tanggal",[$start,$end])
                                                    ->where('resto','=',2)
                                                    ->get();

            return $this->renderer->render($response, 'accounting/report/pendapatan-report', $data);

        } else {

            $data['pendapatan'] = 'whitehouse';
            $data['judul'] = "Laporan Pendapatan White Horse";

            return $this->renderer->render($response, 'accounting/report/pendapatan-form', $data);
        } 
    }

    public function spa(Request $request, Response $response, $args)
    {
        // app profile
        $data['app_profile'] = $this->app_profile;


        if($request->isPost()){

            $postData = $request->getParsedBody();
                
            $data['d_start'] = $postData['start'];
            $data['d_end'] = $postData['end'];

            $start = $this->convert($postData['start']);
            $end = $this->convert($postData['end']);

            $data['options'] = Options::all();

            //Keterangan
            $data['judul'] = "Laporan Pendapatan SPA";
            $data['identitas'] = "spa";

            $data['datas'] = Spakasir::whereBetween("tanggal",[$start,$end])
                                            ->get();

            return $this->renderer->render($response, 'accounting/report/pendapatan-report', $data);

        } else {

            $data['pendapatan'] = 'spa';
            $data['judul'] = "Laporan Pendapatan SPA";

            return $this->renderer->render($response, 'accounting/report/pendapatan-form', $data);
        } 
    }

    public function checkout(Request $request, Response $response, $args)
    {
        // app profile
        $data['app_profile'] = $this->app_profile;


        if($request->isPost()){

            $postData = $request->getParsedBody();
                
            $data['d_start'] = $postData['start'];
            $data['d_end'] = $postData['end'];

            $start = $this->convert($postData['start']);
            $end = $this->convert($postData['end']);

            $data['options'] = Options::all();

            //Keterangan
            $data['judul'] = "Laporan Pendapatan CheckOut";
            $data['identitas'] = "checkout";

            $data['datas'] = CheckOut::whereBetween("checkout_date",[$start,$end])
                                            ->get();


            return $this->renderer->render($response, 'accounting/report/pendapatan-report', $data);

        } else {

            $data['pendapatan'] = 'checkout';
            $data['judul'] = "Laporan Pendapatan CheckOut";

            return $this->renderer->render($response, 'accounting/report/pendapatan-form', $data);
        } 
    }

    public function rekap(Request $request, Response $response, $args)
    {
        // app profile
        $data['app_profile'] = $this->app_profile;


        if($request->isPost()){

            $postData = $request->getParsedBody();
                
            $data['d_start'] = $postData['start'];
            $data['d_end'] = $postData['end'];

            $start = $this->convert($postData['start']);
            $end = $this->convert($postData['end']);

            $data['options'] = Options::all();

            //Keterangan
            $data['judul'] = "Laporan Rekap Pendapatan";
            $data['identitas'] = "rekap";

            $data['datas'] = CheckOut::whereBetween("checkout_date",[$start,$end])
                                            ->get();
            $data['ri'] = Reskasirku::whereBetween("tanggal",[$start,$end])
                                                    ->where('resto','=',1)
                                                    ->get();
            $data['wh'] = Reskasirku::whereBetween("tanggal",[$start,$end])
                                                    ->where('resto','=',2)
                                                    ->get();
            $data['sp'] = Spakasir::whereBetween("tanggal",[$start,$end])
                                                    ->get();

            return $this->renderer->render($response, 'accounting/report/pendapatan-report', $data);

        } else {

            $data['pendapatan'] = 'rekap';
            $data['judul'] = "Laporan Rekap Pendapatan";

            return $this->renderer->render($response, 'accounting/report/pendapatan-form', $data);
        } 
    }

    private function convert($date)
    {
        $exp = explode('-', $date);
            if (count($exp)==3) {
                $date = $exp[2].'-'.$exp[1].'-'.$exp[0];
            }
        return $date;
    }
}


