<?php

namespace App\Controller\FrontDesk;

use Slim\Http\Request;
use Slim\Http\Response;
use App\Controller\Controller;
use App\Model\Reservation;
use App\Model\Reservationdetail;
use App\Model\Deposit;
use App\Model\Bank;
use App\Model\Option;
use App\Model\Creditcard;
use Kulkul\Reservation\RoomRate;
use Kulkul\CodeGenerator\CheckinCode;
use Kulkul\Accounting\AccountingServiceProvider;
use Kulkul\CurrencyFormater\FormaterAdapter;

use Illuminate\Database\Capsule\Manager as DB;

class DepositController extends Controller
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
        

        //$nobukti =$this->GenericNoBukti(count($this->db->table('deposits')->get()));
        $data['creditcards'] = Creditcard::all();
        
        if($request->isPost()){
            $postData = $request->getParsedBody();

            $jurnal=[ 
                "id"=>"",
                "code" => "",
                "tanggal" => convert_date($postData['tanggal']),
                "nobukti" => $postData["nobukti"],
                "keterangan" => "Deposit",
                "details"=>[]
            ];

            if($postData["type"]=="BANK")
            {
                $bank=Bank::find($postData["banks_id"]);  
                $jurnal["details"][]=["accounts_id"=>$bank->accounts_id,"debet"=>str_replace('.','',$postData['nominal']),"kredit"=>0]; // simpan ke bank
            }else{
                $jurnal["details"][]=["accounts_id"=>Option::where("name","=","kas")->first()->value,"debet"=>str_replace('.','',$postData['nominal']),"kredit"=>0]; // simpan ke kas    
            }
        

            $jurnal["details"][]=["accounts_id"=>Option::where("name","=","deposit")->first()->value,"debet"=>0,"kredit"=>str_replace('.','',$postData['nominal'])]; // simpan ke deposit
            
            $Accprovider=new AccountingServiceProvider();
                
            $res=$Accprovider->jurnal_save($jurnal);

            $deposit=new Deposit();

            $deposit->reservations_id=$postData["reservations_id"];
            $deposit->tanggal=convert_date($postData["tanggal"]);
            $deposit->nominal=FormaterAdapter::reverse($postData["nominal"]);
            $deposit->nobukti=$postData["nobukti"];
            $deposit->keterangan=$postData["keterangan"];
            $deposit->type=$postData["type"];
            $deposit->cards_id=@$postData["jeniskartukredit"];
            $deposit->banks_id=$postData["banks_id"];
            $deposit->creditcard=$postData["creditcard"];
            $deposit->creditcarddate=convert_date(@$postData["creditcarddate"]!=""?$postData["creditcarddate"]:null);
            $deposit->users_id=$this->session->get('activeUser')["id"];
            $deposit->accjurnals_id=$res["accjurnals_id"];
            
            $deposit->save();

            return $response->withRedirect($this->router->pathFor('frontdesk-deposit',["reservations_id"=>$args["reservations_id"]]));

        }else{
            $purReq = Deposit::where(DB::raw('left(nobukti,7)'), '=', 'DP.'.date('ym'))
                                    ->orderBy('nobukti',"desc")->first();
            if($purReq == NULL){
                $nobukti = 'DP.'.date('ym').substr('0000'.(substr($purReq->nobukti,-4)*1+1),-4);
            }else{
                $nobukti = substr($purReq->nobukti,0,7).substr('0000'.(substr($purReq->nobukti,-4)*1+1),-4);
            }

            $data['NoBukti'] = $nobukti;
            $data['app_profile'] = $this->app_profile;
            $data['deposits']=Deposit::where("reservations_id",$args["reservations_id"])->get();
            $data['reservation']=Reservation::find($args["reservations_id"]);
            $data['banks']=Bank::all();

            return $this->renderer->render($response, 'frontdesk/deposit', $data);
        }
        

    }

    public function delete (Request $request, Response $response, Array $args){
            $deposit=Deposit::find($args["id"]);
            
            $reservations_id=$deposit->reservations_id;
            $accjurnals_id=$deposit->accjurnals_id;

            $deposit->reservations_id=0;
            $deposit->save();

            $Accprovider=new AccountingServiceProvider();
            $res=$Accprovider->jurnal_delete($accjurnals_id);


            return $response->withRedirect($this->router->pathFor('frontdesk-deposit',["reservations_id"=>$reservations_id]));
    }

    public function reportKwitansi(Request $request, Response $response, Array $args)
    {
        $data['deposit']=Deposit::find($args["id"]);

        $deposit=Deposit::find($args["id"]);
        $reservations_id = $deposit->reservations_id;

        $data['reservation'] = Reservation::find($reservations_id);

        $data['rooms']=Reservationdetail::join('rooms','rooms.id','=','reservationdetails.rooms_id')
                        ->select('rooms.*')
                        ->where('reservationdetails.reservations_id','=',$reservations_id)
                        ->get();

        ///// get option ///
        $opt = Option::all();
        $Options=[];
        foreach ($opt as $value) {
            $Options[$value->name] = $value->value;
        }
        $data['options'] = $Options;
        ///// end get option ///
        
        return $this->renderer->render($response, 'frontdesk/reports/deposit-kwitansi', $data);
    }

}
