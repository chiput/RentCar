<?php

namespace App\Controller\Accounting;

use Slim\Http\Request;
use Slim\Http\Response;
use App\Model\Accneraca;
use App\Model\Accneracadetail;
use App\Model\Account;
use App\Model\Accjurnal;
use App\Controller\Controller;
use Kulkul\Accounting\AccountingServiceProvider;
use Illuminate\Database\Capsule\Manager as DB;

class NeracaController extends Controller
{
    public function __invoke(Request $request, Response $response, Array $args)
    {

        $data["neracas"]=Accneraca::all();//$this->getData()->get()];
        $data['app_profile'] = $this->app_profile;
        return $this->renderer->render($response, 'accounting/neraca', $data);

    }

    public function form(Request $request, Response $response, Array $args)
    {
        $data['app_profile'] = $this->app_profile;
        if($request->isPost()){

        }else{
            $data['errors'] = $this->session->getFlash('error_messages');
            if (!is_null($data['errors'])) {
                $postData = (object) $this->session->getFlash('post_data');
                $data['month'] = $postData->bulan;
                $data['year'] = $postData->tahun;
                $data['id'] = $postData->id;
                foreach ($postData->accounts_id as $key => $account) {
                    $data["details"][]=[
                    "id"=>$postData->accounts_id[$key],
                    "code"=>$postData->code[$key],
                    "name"=>$postData->name[$key],
                    "debet"=>$postData->debet[$key],
                    "kredit"=>$postData->kredit[$key],
                    "users_id"=>$this->session->get('activeUser')["id"]
                    ];
                
                }
            }else{
                $neraca = Accneraca::find(@$args['id']);

                if($neraca== null){
                    $accounts=Account::all();
                    foreach ($accounts as $key => $account) {
                        $data["details"][]=[
                                            "id"=>$account->id,
                                            "code"=>$account->code,
                                            "name"=>$account->name,
                                            "debet"=>0,
                                            "kredit"=>0,
                                            "users_id"=>$this->session->get('activeUser')["id"]
                        ];
                    }
                }else{
                    $data["month"] = date('m',strtotime($neraca->tanggal));
                    $data["year"] = date('Y',strtotime($neraca->tanggal));
                    $data["id"] = $args['id'];
                    foreach ($neraca->detail as $account) {
                        $data["details"][]=[
                                            "id"=>$account->accounts_id,
                                            "code"=>$account->account->code,
                                            "name"=>$account->account->name,
                                            "debet"=>$account->debet,
                                            "kredit"=>$account->kredit,
                                            "users_id"=>$this->session->get('activeUser')["id"]
                        ];
                    }
                }
            }
            

            return $this->renderer->render($response, 'accounting/neraca-form', $data);
        }
        
    }

    public function closing(Request $request, Response $response, Array $args)
    {

        $data['app_profile'] = $this->app_profile;
        $data['success'] = $this->session->getFlash('success');
        $data['errors'] = $this->session->getFlash('error_messages');
        $count_neraca=Accneraca::where("type","=","AWAL")->get()->count();
        if($count_neraca<1){
            return $response->write("Saldo awal belum ditentukan");
        }


        if($request->isPost())
        {
            $postData = $request->getParsedBody();
            $month=substr($postData["bulan"],0,7);
            $year=substr($postData["tahun"],0,7);
            $lastDate=date("Y-m-t",strtotime("$year-$month-01")); //tanggal closing selalu di akhir bulan
            $saldoAwal=Accneraca::where("type","=","AWAL")->get()->first();
            $duplicate=Accneraca::where("tanggal","=",$lastDate)->get()->first(); //cek duplikat closing
            
            if($saldoAwal->tanggal>=$lastDate)
            {
                return $this->fail_closing($response, $postData,array("Tutup buku tidak boleh mendahului saldo awal"));

            }elseif(@$duplicate->tanggal==$lastDate){

                return $this->fail_closing($response, $postData,array("Pembukuan periode tersebut sudah ditutup."));

            }else{

                $total=DB::table("accjurnaldetails")
                            ->join('accjurnals', 'accjurnals.id', '=', 'accjurnaldetails.accjurnals_id')
                            ->join('accounts', 'accounts.id', '=', 'accjurnaldetails.accounts_id')
                            ->select(DB::raw("accjurnaldetails.accounts_id, sum(accjurnaldetails.debet) as t_debet, sum(accjurnaldetails.kredit) as t_kredit, accounts.type"))
                            ->where('accjurnals.tanggal', 'like', substr($lastDate,0,7)."%")
                            ->where('accjurnals.posted','=','POSTED') //hanya posted yang dihitung
                            ->groupBy('accjurnaldetails.accounts_id')
                            ->get();
                            


                $arrTotal=[];
                foreach ($total as $key => $value) {
                    $arrTotal[$value->accounts_id]=$value;
                }

                if(count($arrTotal)<1) return $this->fail_closing($response, $postData,array("Tidak ada posting di periode tersebut."));

                // save ke neraca
                $neraca= new Accneraca();
                $neraca->tanggal = $lastDate;
                $neraca->type = "CLOSING";
                $neraca->users_id=$this->session->get('activeUser')["id"];
                $neraca->save();
                $insertedNeracaId = $neraca->id;

                // save ke detail neraca
                $detail=[];
                $data = [];
                foreach ($arrTotal as $key => $account) {
                    $arr=[
                    'accounts_id' => $account->accounts_id,
                    'accneracas_id' => $insertedNeracaId,
                    'debet' => $account->t_debet,
                    'kredit' => $account->t_kredit,
                    'users_id'=>$this->session->get('activeUser')["id"]
                    ];
                    $data[]=$arr;
                }
                
                $neracaDetail = Accneracadetail::insert($data); 


                //set Jurnal Posted ke Closed
                Accjurnal::where('posted','=','POSTED')
                            ->where(DB::raw('left(tanggal,7)'),'like', substr($lastDate,0,7))
                            ->update(['posted' => 'CLOSED']);

                //redirect
                $this->session->setFlash('success', 'Pembukuan sudah ditutup.');
                return $response->withRedirect($this->router->pathFor('accounting-neraca-tutup-buku'));

                

            }
        }else{
            return $this->renderer->render($response, 'accounting/neraca-closing', $data);    
        }
        
        
    }

    public function save(Request $request, Response $response, Array $args)
    {
        
        $postData = $request->getParsedBody();

        //validation

        /*
        Jika validasi gagal
        */
        if (!$this->validation->passes()) 
        {
            return $this->fail_save($response, $postData,$this->validation->errors()->all());
        }

        /*
        Jika entry kosong
        */
        if(array_sum($postData['debet'])==0 || array_sum($postData['kredit'])==0){ 
            return $this->fail_save($response, $postData,array("Entry tidak boleh kosong !"));
        }

        /*
        Jika tidak balance
        */
        if(array_sum($postData['debet'])!=array_sum($postData['kredit']))
        {
            return $this->fail_save($response, $postData,array("Entry tidak balance !"));
        }

        $month=substr(('0'.$postData["bulan"]),-2);
        $year=$postData["tahun"];

        if(@$postData['id']==""){
            $neraca=Accneraca::where('tanggal', 'LIKE', $year.'-'.$month.'%')->get()->count();
        }else{
            $neraca=Accneraca::where('tanggal', 'LIKE', $year.'-'.$month.'%')->where('id','!=',$postData['id'])->get()->count();;
        }
        /*
        Jika sudah posting neraca dibulan yang sama
        */
        if($neraca>0){
            return $this->fail_save($response, $postData,array("Neraca sudah diposting di bulan yang sama !"));
        }


        /*
        Jika edit maka posting yang lama ditimpa dengan posting yang baru
        */
        
        $neraca=Accneraca::find($postData['id']);
        //$neraca->users_id_edit=$this->session->get('activeUser')["id"];
        if($neraca != null) $neraca->delete(); $this->delete_jurnal($neraca->accjurnals_id); //hapus jurnal

        $det = Accneracadetail::where('accneracas_id','=',$postData['id']);
        if($det != null) $det->delete();

        /*
        Posting ke jurnal
        */
        $jurnal_id = $this->post_jurnal($postData);

        /*
        Simpan neraca awal
        */
        $neraca= new Accneraca();
        $date=strtotime("$year-$month-01");
        $neraca->tanggal = date("Y-m-d",$date);
        $neraca->type = "AWAL";
        $neraca->accjurnals_id = $jurnal_id;
        $neraca->users_id=$this->session->get('activeUser')["id"];
        $neraca->save();
        $insertedNeracaId = $neraca->id;


        //hapus entry dengan jurnal id (jika edit)
        if ($postData['id'] != '') {
            $neracaDetail = Accneracadetail::where('accneracas_id','=',$postData['id']);
            $neracaDetail->delete();
        }

        //input entry
        $data = [];

        foreach ($postData['accounts_id'] as $key => $account) {
            $data[]=[
            'accounts_id' => $postData['accounts_id'][$key],
            'accneracas_id' => $insertedNeracaId,
            'debet' => $postData['debet'][$key],
            'kredit' => $postData['kredit'][$key],
            'users_id'=>$this->session->get('activeUser')["id"],
            ];
        }

        $neracaDetail = Accneracadetail::insert($data); // Eloquent

        return $response->withRedirect($this->router->pathFor('accounting-neraca-saldo-awal'));
    
    }

    public function fail_save($response, $postData,$mess)
    {

        $this->session->setFlash('error_messages',$mess);
        $this->session->setFlash('post_data', $postData);

        if($postData['id']==""){
            return $response->withRedirect($this->router->pathFor('accounting-neraca-saldo-awal-add'));
        }else{
            return $response->withRedirect($this->router->pathFor('accounting-neraca-saldo-awal-edit',['id'=>$postData['id']]));           
        }

    }

    public function fail_closing($response, $postData,$mess)
    {

        $this->session->setFlash('error_messages',$mess);
        $this->session->setFlash('post_data', $postData);
        return $response->withRedirect($this->router->pathFor('accounting-neraca-tutup-buku'));

    }
    

    public function delete(Request $request, Response $response, Array $args)
    {
        $neraca=Accneraca::find($args['id']);
        if($neraca != null) $neraca->delete(); $this->delete_jurnal($neraca->accjurnals_id); //hapus jurnal
        $det = Accneracadetail::where('accneracas_id','=',$args['id']);
        if($det != null) $det->delete();
        return $response->withRedirect($this->router->pathFor('accounting-neraca-saldo-awal'));
    }

    private function post_jurnal($postData){
        $month=substr(('0'.$postData["bulan"]),-2);
        $year=$postData["tahun"];
        $date=strtotime("$year-$month-01");

		$jurnal=[
	            "id"=>"",
	            "code" => "",
	            "tanggal" => date('Y-m-d',$date),
	            "nobukti" => "",
	            "posted" => "POSTED",
	            "keterangan" => "Saldo Awal ". date('F Y',$date),
	            "details"=>[]
	        ];

        foreach ($postData['accounts_id'] as $key => $account) {
            if($postData['debet'][$key] > 0 || $postData['kredit'][$key] > 0)
            {
                $jurnal["details"][]=[
                    'accounts_id' => $postData['accounts_id'][$key],
                    'debet' => $postData['debet'][$key],
                    'kredit' => $postData['kredit'][$key],
                    'users_id'=>$this->session->get('activeUser')["id"],
                ];
            }
        }

        $Accprovider=new AccountingServiceProvider();

        $accounting=$Accprovider->jurnal_save($jurnal);

        if($accounting["stat"]=="error"){
        	echo $accounting["mess"];
        	return false;
        }

        //print_r($accounting);
        return $accounting["accjurnals_id"];
	}

    private function delete_jurnal($jurnalid){
        $Accprovider = new AccountingServiceProvider();
        $res = $Accprovider->jurnal_delete($jurnalid);
    }

}



