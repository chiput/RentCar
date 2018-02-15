<?php

namespace App\Controller\FrontDesk;

use Slim\Http\Request;
use Slim\Http\Response;
use App\Controller\Controller;
use App\Model\Addcharge;
use App\Model\Addchargedetail;
use App\Model\Addchargetype;
use App\Model\Reservation;
use App\Model\Reservationdetail;
use App\Model\Option;
use Kulkul\Accounting\AccountingServiceProvider;
use Kulkul\CodeGenerator\AddchargeCode;
use Kulkul\CurrencyFormater\FormaterAdapter;

class AddchargeController extends Controller
{
    public function __invoke(Request $request, Response $response, Array $args)
    {
        $data['addcharges'] = Addcharge::orderBy('id','desc')->get();
        $data['app_profile'] = $this->app_profile;
        return $this->renderer->render($response, 'frontdesk/addcharge', $data);
    }

    public function form(Request $request, Response $response, Array $args)
    {
        $data = [];

        // if update

        $data["checkins"]=Reservationdetail::whereNotNull("checkin_at")
                          ->get();

        //$data["types"]=Addchargetype::where("is_active","=",1)->get();
        $data["types"]=Addchargetype::all();

        $data["addcharge"]=(object)["nobukti"=>AddchargeCode::generate(),"tanggal"=>date("Y-m-d")];

        if (isset($args['id'])){
            $data["addcharge"]=Addcharge::find($args["id"]);
        }

        // if error
        $data['errors'] = $this->session->getFlash('error_messages');
        if (!is_null($data['errors'])) {
            $data['type'] = (object) $this->session->getFlash('post_data');
        }

        return $this->renderer->render($response, 'frontdesk/addcharge-form', $data);
    }

    public function save(Request $request, Response $response, Array $args)
    {
        $postData = $request->getParsedBody();

        function convert_date($date){
            $exp = explode('-', $date);
            if (count($exp)==3) {
                $date = $exp[2].'-'.$exp[1].'-'.$exp[0];
            }
            return $date;
        }

        if (!$this->validation->passes()) {

            $this->session->setFlash('error_messages', $this->validation->errors()->all());
            $this->session->setFlash('post_data', $postData);

            if ($postData['id'] == '') {
                return $response->withRedirect($this->router->pathFor('frontdesk-addcharge-new'));
            } else {
                return $response->withRedirect($this->router->pathFor('frontdesk-addcharge-update'));
            }
        }

        // insert
        if ($postData['id'] == '') {
            $this->session->setFlash('success', 'Biaya tambahan ditambahkan');
            $addcharge = new Addcharge();
        } else {
        // update

            $this->session->setFlash('success', 'Biaya tambahan diperbarui');
            $addcharge = Addcharge::find($postData['id']);
            $addcharge->users_id_edit=$this->session->get('activeUser')["id"];

        }


        $addcharge->nobukti = $postData['nobukti'];
        $addcharge->tanggal = convert_date($postData['tanggal']);
        $addcharge->reservationdetails_id = $postData['reservationdetails_id'];
        $addcharge->remark=$postData["remark"];
        $addcharge->users_id=$this->session->get('activeUser')["id"];
        $addcharge->ntotal=FormaterAdapter::reverse($postData["total"]);
        $addcharge->save();

        $addcharge_id=$addcharge->id;

        $addchargdet=Addchargedetail::where("addcharges_id","=",$addcharge->id);
        foreach ($addchargdet->get() as $key => $det) {

            $Accprovider=new AccountingServiceProvider();
            $res=$Accprovider->jurnal_delete($det->accjurnals_id);
        }

        $addchargdet->delete();

        foreach ($postData["types_id"] as $key => $type_id)
        {
            // input jurnal
            if($type_id!=0)
            {
                $Accprovider=new AccountingServiceProvider();
                $type=Addchargetype::find($type_id);

                if($postData['reservationdetails_id'] == 0){

                    $jurnal=[
                        "id"=>"",
                        "code" => "",
                        "tanggal" => convert_date($postData['tanggal']),
                        "nobukti" => @$postData['nobukti'],
                        "keterangan" => "Biaya tambahan ".@$postData['nobukti']. " untuk ".$type->name." ($type->code) ",
                        "details"=>[]
                    ];


                    $value = Option::where("name","=","kas")->first()->value;

                    $jurnal["details"][]=[
                    "accounts_id"=>$value,
                    "debet"=>FormaterAdapter::reverse($postData['sell'][$key])*$postData['qty'][$key],
                    "kredit"=>0]; // simpan ke piutang

                    $jurnal["details"][]=["accounts_id"=>$type->accincome,
                    "debet"=>0,
                    "kredit"=>FormaterAdapter::reverse($postData['sell'][$key])*$postData['qty'][$key]
                    ]; // simpan ke pendapatan

                
                    $res=$Accprovider->jurnal_save($jurnal);

                }
                

                // input detail

                $addchargedet=new Addchargedetail();
                $addchargedet->addchargetypes_id=$type_id;
                $addchargedet->addcharges_id=$addcharge_id;
                $addchargedet->remark=$postData["remarks"][$key];
                $addchargedet->qty=$postData["qty"][$key];
                $addchargedet->buy=0;
                $addchargedet->sell=FormaterAdapter::reverse($postData["sell"][$key]);
                if($postData['reservationdetails_id'] == 0){
                    $addchargedet->accjurnals_id=$res["accjurnals_id"];
                }
                $addchargedet->users_id=$this->session->get('activeUser')["id"];
                $addchargedet->save();
            }
        }

        //return $response;
        return $response->withRedirect($this->router->pathFor('frontdesk-addcharge'));
    }

    public function delete(Request $request, Response $response, Array $args)
    {
        $Accprovider=new AccountingServiceProvider();

        $Addcharge = Addcharge::find($args['id']);
        $res=$Accprovider->jurnal_delete($Addcharge->accjurnals_id);
        $Addcharge->delete();

        $Addchargedetail = Addchargedetail::where("Addcharges_id","=",$args['id']);

        foreach ($Addchargedetail->get() as $key => $det) {
            $Accprovider=new AccountingServiceProvider();
            $res=$Accprovider->jurnal_delete($det->accjurnals_id);

        }
        $Addchargedetail->delete();

        $this->session->setFlash('success', 'Data biaya jenis telah dihapus');
        return $response->withRedirect($this->router->pathFor('frontdesk-addcharge'));
    }
}
