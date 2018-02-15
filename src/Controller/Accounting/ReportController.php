<?php

namespace App\Controller\Accounting;

use Slim\Http\Request;
use Slim\Http\Response;
use App\Model\Accjurnal;
use App\Model\Accheader;
use App\Model\Accgroup;
use App\Model\Accaktiva;
use App\Model\Accjurnaldetail;
use App\Model\Account;
use App\Model\Acckastype;
use App\Model\Acckas;
use App\Model\Acckasdetail;

use App\Model\Reskasirku;
use App\Model\Addchargedetail;

use App\Controller\Controller;
use Kulkul\Accounting\AccountingServiceProvider;
use Illuminate\Database\Capsule\Manager as DB;
use Kulkul\Options;

class ReportController extends Controller
{


    public function __invoke(Request $request, Response $response, Array $args)
    {




    }

     private function convert_date($date){
                    $exp = explode('-', $date);
                    if (count($exp)==3) {
                        $date = $exp[2].'-'.$exp[1].'-'.$exp[0];
                    }
                    return $date;
                }

   public function account(Request $request, Response $response, Array $args)
    {
        // app profile
        $data['app_profile'] = $this->app_profile;
        $data['headers']=Accheader::orderBy('code','ASC')->get();

        $data['options'] = Options::all();

        return $this->renderer->render($response, 'accounting/report/account-report', $data);
    }

    public function aktiva(Request $request, Response $response, Array $args)
    {
        $data['app_profile'] = $this->app_profile;

        if($request->isPost()){

            //show report

            $postData = $request->getParsedBody();
            $date=strtotime($postData['year'].'-'.$postData["month"].'-01');
            $data['month'] = $postData['month'];
            $data['year'] = $postData['year'];

            $aktivas=DB::table("accaktivas")
                            ->join('accaktivajurnaldetails', 'accaktivas.id', '=', 'accaktivajurnaldetails.accaktivas_id')
                            ->join('accaktivajurnals', 'accaktivajurnals.id', '=', 'accaktivajurnaldetails.accaktivajurnals_id')
                            ->join('accaktivagroups', 'accaktivagroups.id', '=', 'accaktivas.accaktivagroups_id')
                            ->select(DB::raw("accaktivas.*, accaktivagroups.nama as group_name, sum(accaktivajurnaldetails.nominal) as total"))
                            ->where('accaktivajurnals.tanggal',"<=",date("Y-m-t",$date))
                            ->groupBy('accaktivas.id')
                            ;
            // echo $aktivas->toSql();
            // echo date("Y-m-t",$date);
            $data["aktivas"]=$aktivas->get();
            $data['options'] = Options::all();
            return $this->renderer->render($response, 'accounting/report/aktiva-report', $data);
            //return $response;
        }else{
            return $this->renderer->render($response, 'accounting/report/aktiva-form', $data);
        }

        
    }

    public function saldo(Request $request, Response $response, Array $args)
    {
                function convert_date($date){
                    $exp = explode('-', $date);
                    if (count($exp)==3) {
                        $date = $exp[2].'-'.$exp[1].'-'.$exp[0];
                    }
                    return $date;
                }

        // app profile
        $data['app_profile'] = $this->app_profile;
        if($request->isPost()){

            //show report

            $postData = $request->getParsedBody();
            $data['range'] = $postData;

            $start = convert_date($data['range']['start']);
            $end = convert_date($data['range']['end']);
            $data['accounts']=Account::all(); 
            $data['jurnaldetails']=[];
            $data['saldoawal']=[];

            $jurnaldetails=DB::table("accjurnaldetails")
                            ->join('accjurnals', 'accjurnals.id', '=', 'accjurnaldetails.accjurnals_id')
                            ->select(DB::raw("accjurnaldetails.accounts_id, sum(accjurnaldetails.debet) as t_debet, sum(accjurnaldetails.kredit) as t_kredit"))
                            ->whereBetween('accjurnals.tanggal',[$this->convert_date($postData["start"]),$this->convert_date($postData["end"])] )
                            ->where('accjurnals.posted','!=','UNPOSTED') //hanya posted dan closing
                            ->groupBy('accjurnaldetails.accounts_id')
                            ->get();

            foreach ($jurnaldetails as $detail) {
                $data['jurnaldetails'][$detail->accounts_id]=$detail;
            }

            $saldoawal=DB::table("accneracadetails")
                            ->join('accneracas', 'accneracas.id', '=', 'accneracadetails.accneracas_id')
                            ->select(DB::raw("accneracadetails.accounts_id, accneracadetails.debet, accneracadetails.kredit"))
                            ->where('accneracas.tanggal','=',substr($postData["start"],0,8).'01')
                            ->where('accneracas.type','=','AWAL')
                            ->get();

            foreach ($saldoawal as $awal) {
                $data['saldoawal'][$awal->accounts_id]=$awal;
            }
            $data['options'] = Options::all();
            return $this->renderer->render($response, 'accounting/report/saldo-report', $data);
        }else{
            return $this->renderer->render($response, 'accounting/report/saldo-form', $data);
        }
        
    }

    public function jurnal(Request $request, Response $response, Array $args)
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
            //query
            $data["jurnals"]=Accjurnal::whereBetween("tanggal",[$start,$end])
                            ->where("posted","!=","UNPOSTED")
                            ->get();
            $data['options'] = Options::all();
            return $this->renderer->render($response, 'accounting/report/jurnal-report', $data);
            
        }else{
            //show form            
            return $this->renderer->render($response, 'accounting/report/jurnal-form', $data);
        }
    }

    public function bukubesar(Request $request, Response $response, Array $args)
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
            $details=DB::table("accjurnaldetails")
                            ->join('accjurnals', 'accjurnals.id', '=', 'accjurnaldetails.accjurnals_id')
                            ->join('accounts', 'accounts.id', '=', 'accjurnaldetails.accounts_id')
                            ->select(DB::raw("accounts.id, accounts.code, accounts.type, accounts.name, accjurnals.code as jurnal_code, accjurnals.tanggal, accjurnals.keterangan, accjurnaldetails.debet, accjurnaldetails.kredit"))
                            ->where('accjurnals.posted','!=','UNPOSTED') //hanya posted dan closing
                            ->whereBetween('accjurnals.tanggal',[$this->convert_date($postData["start"]),$this->convert_date($postData["end"])]);
            if($postData["id"]!=""){
                $details=$details->where("accounts.id","=",$postData["id"]);
            }
            $details=$details->orderBy('accounts.id', 'asc')
                            ->orderBy('accjurnals.tanggal', 'asc')
                            ->get();
            $data["details"]=$details;
            $data['options'] = Options::all();
            return $this->renderer->render($response, 'accounting/report/bukubesar-report', $data);

        }else{
            //show form            
            $data["accounts"]=Account::all();
            return $this->renderer->render($response, 'accounting/report/bukubesar-form', $data);
        }
    }

    public function labarugi(Request $request, Response $response, Array $args)
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
            
            $details=DB::table("accjurnaldetails")
                            ->join('accjurnals', 'accjurnals.id', '=', 'accjurnaldetails.accjurnals_id')
                            ->join('accounts', 'accounts.id', '=', 'accjurnaldetails.accounts_id')
                            ->join('accheaders', 'accheaders.id', '=', 'accounts.accheaders_id')
                            ->join('accgroups', 'accgroups.id', '=', 'accheaders.accgroups_id')
                            ->select(DB::raw("accgroups.id, accheaders.name, accgroups.name as group_name, sum(accjurnaldetails.debet) as t_debet, sum(accjurnaldetails.kredit) as t_kredit"))
                            ->where('accjurnals.posted','!=','UNPOSTED') //hanya posted dan closing
                            ->where(function($query){
                                $query->where("accgroups.name","=","PENDAPATAN")
                                      ->orWhere("accgroups.name","=","HPP")
                                      ->orWhere("accgroups.name","=","BIAYA");
                            })
                            ->whereBetween('accjurnals.tanggal',[$this->convert_date($postData["start"]),$this->convert_date($postData["end"])] )
                            ->groupBy('accounts.accheaders_id')
                            ->get();

            //print_r($details);
            $data["details"]=$details;
            //print_r($details);
            $data['options'] = Options::all();
            return $this->renderer->render($response, 'accounting/report/labarugi-report', $data);

        }else{
            //show form

            return $this->renderer->render($response, 'accounting/report/labarugi-form', $data);
        }
    }

    public function labarugi_detail(Request $request, Response $response, Array $args)
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

            $details=DB::table("accjurnaldetails")
                            ->join('accjurnals', 'accjurnals.id', '=', 'accjurnaldetails.accjurnals_id')
                            ->join('accounts', 'accounts.id', '=', 'accjurnaldetails.accounts_id')
                            ->join('accheaders', 'accheaders.id', '=', 'accounts.accheaders_id')
                            ->join('accgroups', 'accgroups.id', '=', 'accheaders.accgroups_id')
                            ->select(DB::raw("accounts.id, accounts.accheaders_id, accheaders.accgroups_id, accounts.type, accounts.name, accheaders.name as header_name, accheaders.name as header_name, accgroups.name as group_name, sum(accjurnaldetails.debet) as t_debet, sum(accjurnaldetails.kredit) as t_kredit"))
                            ->where('accjurnals.posted','!=','UNPOSTED') //hanya posted dan closing
                            ->where(function($query){
                                $query->where("accgroups.name","=","PENDAPATAN")
                                      ->orWhere("accgroups.name","=","HPP")
                                      ->orWhere("accgroups.name","=","BIAYA");
                            })
                            ->whereBetween('accjurnals.tanggal',[$this->convert_date($postData["start"]),$this->convert_date($postData["end"])] )
                            ->groupBy('accounts.id')
                            ->get();

            //print_r($details);
            $data["details"]=$details;
            $data['options'] = Options::all();
            return $this->renderer->render($response, 'accounting/report/labarugi_detail-report', $data);

        }else{
            //show form

            return $this->renderer->render($response, 'accounting/report/labarugi_detail-form', $data);
        }
    }

    public function neraca (Request $request, Response $response, Array $args)
    {
        $data['app_profile'] = $this->app_profile;
        if($request->isPost()){
            $postData = $request->getParsedBody();
            //print_r($postData); 
            //var_dump($postData);
            $date=strtotime($postData['year'].'-'.$postData["month"].'-01');

            $data['month'] = $postData['month'];
            $data['year'] = $postData['year'];

            $data["headers"]=Accheader::all();
            $data["groups"]=Accgroup::all();

            $details=DB::table("accjurnaldetails")
                            ->join('accjurnals', 'accjurnals.id', '=', 'accjurnaldetails.accjurnals_id')
                            ->join('accounts', 'accounts.id', '=', 'accjurnaldetails.accounts_id')
                            ->join('accheaders', 'accheaders.id', '=', 'accounts.accheaders_id')
                            ->select(DB::raw("accounts.accheaders_id, accheaders.name as header_name, sum(accjurnaldetails.debet) as t_debet, sum(accjurnaldetails.kredit) as t_kredit"))
                            ->where('accjurnals.posted','!=','UNPOSTED') //hanya posted dan closing
                            //->where(DB::raw('LEFT(accjurnals.tanggal,7)="'.$postData['year'].'-'.$postData["month"].'"'))
                            ->whereBetween('accjurnals.tanggal',[date("Y-m-d",$date),date("Y-m-t",$date)])
                            ->groupBy('accounts.accheaders_id')
                            ->get();      

            $data["details"]=[];
            foreach ($details as $detail) {
                $data["details"][$detail->accheaders_id]=$detail;
            }            
            $data['options'] = Options::all();
            return $this->renderer->render($response, 'accounting/report/neraca-report', $data);
        }else{
            return $this->renderer->render($response, 'accounting/report/neraca-form', $data);
        }
    }

    public function neraca_detail (Request $request, Response $response, Array $args)
    {
        $data['app_profile'] = $this->app_profile;
        if($request->isPost()){
            $postData = $request->getParsedBody();
            //print_r($postData); 
            $date=strtotime($postData['year'].'-'.$postData["month"].'-01');
            $data['month'] = $postData['month'];
            $data['year'] = $postData['year'];

            $data["headers"]=Accheader::all();
            $data["groups"]=Accgroup::all();
            $data["accounts"]=Account::all();

            $details=DB::table("accjurnaldetails")
                            ->join('accjurnals', 'accjurnals.id', '=', 'accjurnaldetails.accjurnals_id')
                            ->join('accounts', 'accounts.id', '=', 'accjurnaldetails.accounts_id')
                            ->join('accheaders', 'accheaders.id', '=', 'accounts.accheaders_id')
                            ->select(DB::raw("accounts.id, accounts.name, sum(accjurnaldetails.debet) as t_debet, sum(accjurnaldetails.kredit) as t_kredit"))
                            ->where('accjurnals.posted','!=','UNPOSTED') //hanya posted dan closing
                            //->where(DB::raw('LEFT(accjurnals.tanggal,7)="'.$postData['year'].'-'.$postData["month"].'"'))
                            ->whereBetween('accjurnals.tanggal',[date("Y-m-d",$date),date("Y-m-t",$date)])
                            ->groupBy('accounts.id')
                            //->toSql();      
                            ->get();
            $data["details"]=[];
            foreach ($details as $detail) {
                $data["details"][$detail->id]=$detail;
            }            
            $data['options'] = Options::all();
            return $this->renderer->render($response, 'accounting/report/neraca_detail-report', $data);
        }else{
            return $this->renderer->render($response, 'accounting/report/neraca_detail-form', $data);
        }
    }
    
    public function trans_kas (Request $request, Response $response, Array $args)
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
            $data["trans"]=Acckas::whereBetween("tanggal",[$this->convert_date($postData["start"]),$this->convert_date($postData["end"])])->get();
            $data['options'] = Options::all();
            return $this->renderer->render($response, 'accounting/report/trans-kas-report',$data);
        }else{
            return $this->renderer->render($response, 'accounting/report/trans-kas-form',$data);
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


