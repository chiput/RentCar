<?php

namespace App\Controller\Accounting;

use Slim\Http\Request;
use Slim\Http\Response;
use App\Model\Reskasirku;
use App\Model\Spakasir;
use App\Model\Addchargedetail;
use App\Model\CheckOut;
use App\Model\Accjurnaldetail;
use App\Controller\Controller;
use Kulkul\Accounting\AccountingServiceProvider;
use Illuminate\Database\Capsule\Manager as DB;
use Kulkul\Options;

class LabarugiController extends Controller
{

    public function __invoke(Request $request, Response $response, Array $args)
    {
        function convert_date($date){
            $exp = explode('-', $date);
            if (count($exp)==3) {
                $date = $exp[2].'-'.$exp[1].'-'.$exp[0];
            }
            return $date;
        }

        $data['app_profile'] = $this->app_profile;
        if($request->isPost()){
            $postData = $request->getParsedBody();
            $data['range'] = $postData;

            $start = convert_date($data['range']['start']);
            $end = convert_date($data['range']['end']);
            
            
            //print_r($details);
            $data['options'] = Options::all();

            //query total pengeluaran
            $data['data'] = Accjurnaldetail::selectRaw('SUM(accjurnaldetails.debet) as nominal, accjurnaldetails.*, accounts.name as jurname')
                                            ->join('accjurnals','accjurnals.id','=','accjurnaldetails.accjurnals_id')
                                            ->join('accounts','accounts.id','=','accjurnaldetails.accounts_id')
                                            ->join('accheaders','accounts.accheaders_id','=','accheaders.id')
                                            ->join('accgroups','accheaders.accgroups_id','=','accgroups.id')
                                            ->whereBetween("accjurnals.tanggal",[$start,$end])
                                            ->where('accgroups.id','=',9)
                                            ->where('accjurnals.posted','=','POSTED')
                                            ->groupBy('accjurnaldetails.accounts_id')
                                            ->get();

            // query total pendapatan
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

            return $this->renderer->render($response, 'accounting/labarugi-print', $data);

        }else{
            //show form

            return $this->renderer->render($response, 'accounting/labarugi', $data);
        }
    }

}


