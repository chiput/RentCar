<?php

namespace App\Controller\Accounting;

use Slim\Http\Request;
use Slim\Http\Response;
use App\Model\Accjurnal;
use App\Model\Accjurnaldetail;
use App\Model\Accaktiva;
use App\Model\Accaktivagroup;
use App\Model\Accaktivajurnal;
use App\Model\Accaktivajurnaldetail;
use App\Model\Account;
use App\Controller\Controller;
use Kulkul\Accounting\AccountingServiceProvider;
use Kulkul\CurrencyFormater\FormaterAdapter;
use Kulkul\Authentication\Session;


class AktivaController extends Controller
{
    

    public function __invoke(Request $request, Response $response, Array $args)
    {

        $data=["aktivas"=>Accaktiva::all()];//$this->getData()->get()];
        $data['app_profile'] = $this->app_profile;
        return $this->renderer->render($response, 'accounting/aktiva', $data);

    }

    public function form(Request $request, Response $response, Array $args)
    {
        
        $data['app_profile'] = $this->app_profile;
        $data=["accounts"=>Account::all(),
                "accaktivagroups"=>Accaktivagroup::all()];
        $data['app_profile'] = $this->app_profile;

        $data['errors'] = $this->session->getFlash('error_messages');
        if (!is_null($data['errors'])) {
            $data['aktiva'] = (object) $this->session->getFlash('post_data');
        }

        if(isset($args["id"])){
            $data["aktiva"]=Accaktiva::where("id",$args["id"])->first();   
        }

        return $this->renderer->render($response, 'accounting/aktiva-form', $data);
        
    }

    public function save(Request $request, Response $response, Array $args)
    {
        $user = Session::getActiveUser();
        
        $postData = $request->getParsedBody();

        function convert_date($date){
                    $exp = explode('-', $date);
                    if (count($exp)==3) {
                        $date = $exp[2].'-'.$exp[1].'-'.$exp[0];
                    }
                    return $date;
                }

        //validation
        $this->validation->validate([
            'tanggal|Tanggal' => [convert_date($postData['tanggal']), 'required'],
            'nama|Nama' => [$postData['nama'], 'required'],
            'harga|Harga' => [$postData['harga'], 'required'],
            'residu|Residu' => [$postData['residu'], 'required'],
            'umur|Umur' => [$postData['umur'], 'required'],
            'accaktivagroups_id|Kelompok' => [convert_date($postData['accaktivagroups_id']), 'required'],
            'accaktiva_id|Acc. Aktiva' => [$postData['accaktiva_id'], 'required'],
            'acckas_id|Acc. Kas' => [$postData['acckas_id'], 'required'],
            'accakumulasi_id|Acc. Akumulasi' => [$postData['accakumulasi_id'], 'required'],
            'accpenyusutan_id|Acc. Penyusutan' => [$postData['accpenyusutan_id'], 'required'],
        ]);

        if (!$this->validation->passes()) 
        {
            $this->session->setFlash('error_messages', $this->validation->errors()->all());
            $this->session->setFlash('post_data', $postData);

            if ($postData['id'] == '') {
                return $response->withRedirect($this->router->pathFor('accounting-aktiva-add'));
            } else {
                return $response->withRedirect($this->router->pathFor('accounting-aktiva-update',["id"=>$postData['id']]));
            }
        }

        // entry jurnal
         $dataJurnal=[ 
            "id"=>$postData["accjurnals_id"],
            "code"=>"",
            "tanggal" => convert_date($postData['tanggal']),
            "keterangan" => "Pembelian aktiva ".$postData["nama"],
            "details"=>[]
        ];

        $dataJurnal["details"][]=["accounts_id"=>$postData['acckas_id'],
                            "debet"=>0,
                            "kredit"=>FormaterAdapter::reverse($postData['harga'])];
        
        $dataJurnal["details"][]=["accounts_id"=>$postData['accaktiva_id'],
                            "debet"=>FormaterAdapter::reverse($postData['harga']),
                            "kredit"=>0];

        $Accprovider=new AccountingServiceProvider();
        $res=$Accprovider->jurnal_save($dataJurnal);       

        //print_r($res);
        //return $response;

        if($postData['id']==""){
            // new
            $aktiva=new Accaktiva();
            $accjurnals_id=$res['accjurnals_id'];
        }else{
            // update
            $aktiva = Accaktiva::find($postData['id']);    
            $accjurnals_id=$postData['accjurnals_id'];
        }
                
        $aktiva->tanggal = convert_date($postData['tanggal']);
        $aktiva->accjurnals_id = $accjurnals_id;
        $aktiva->nama = $postData['nama'];        
        $aktiva->harga = FormaterAdapter::reverse($postData['harga']);
        $aktiva->residu = FormaterAdapter::reverse($postData['residu']);
        $aktiva->umur = $postData['umur'];
        $aktiva->metode = $postData['metode'];
        $aktiva->accaktivagroups_id = $postData['accaktivagroups_id'];
        $aktiva->accaktiva_id = $postData['accaktiva_id'];
        $aktiva->acckas_id = $postData['acckas_id'];
        $aktiva->accakumulasi_id = $postData['accakumulasi_id'];
        $aktiva->accpenyusutan_id = $postData['accpenyusutan_id'];
        $aktiva->users_id=$this->session->get('activeUser')["id"];

        $aktiva->save();

        return $response->withRedirect($this->router->pathFor('accounting-aktiva'));
    
    }

    

    public function delete(Request $request, Response $response, Array $args)
    {

        $Accprovider=new AccountingServiceProvider();
        $aktiva = Accaktiva::find($args['id']);

        $res=$Accprovider->jurnal_delete($aktiva->accjurnals_id);
        $aktiva->delete(); //softdelete


        $this->session->setFlash('success', 'Aktiva terhapus');
        return $response->withRedirect($this->router->pathFor('accounting-aktiva'));
    }





    public function penyusutan(Request $request, Response $response, Array $args){
        $data['app_profile'] = $this->app_profile;
        $user = Session::getActiveUser();
        if($request->isPost()){
            $postData = $request->getParsedBody();
            $month=$postData["month"];
            $year=$postData["year"];
            $date=strtotime("$year-$month-01");
            $aktivas=Accaktiva::where("tanggal","<=",date("Y-m-t",$date))->get();

            //echo $aktivas;
            //return $response;
            $cek=Accaktivajurnal::where("tanggal","=",date("Y-m-t",$date))->count();
            
            if($cek>0){
                $this->session->setFlash('error', 'Akumulasi sudah dihitung');
                return $response->withRedirect($this->router->pathFor('accounting-aktiva-penyusutan'));
            }

            $aktivajurnal=new Accaktivajurnal();

            $aktivajurnal->tanggal=date("Y-m-t",$date);
            $aktivajurnal->users_id=$user["id"];
            $aktivajurnal->save();
            $aktivajurnal_id=$aktivajurnal->id;
            
            foreach ($aktivas as $aktiva) {

                $aktiva_end=strtotime($aktiva->tanggal." + $aktiva->umur years"); //waktu umur aktiva habis
                
                if(date("Y-m-d",$aktiva_end)>date("Y-m-t",$date)){
                    //echo date("Y-m-d",$aktiva_end)." ".date("Y-m-t",$date);
                    $penyusutan=($aktiva->harga-$aktiva->residu)/$aktiva->umur/12;
                    ///////// posting jurnal //////////////
                    $jurnal=[ 
                    "id"=>"",
                    "tanggal" => date("Y-m-t",$date), //di posting di akhir bulan bersangkutan
                    "code" => "", 
                    "keterangan" => "Penyusutan ".$aktiva->nama,
                    "details"=>[]
                    ];
                    
                    $jurnal["details"][]=["accounts_id"=>$aktiva->accpenyusutan_id,
                                        "debet"=>$penyusutan,
                                        "kredit"=>0];

                    $jurnal["details"][]=["accounts_id"=>$aktiva->accakumulasi_id,
                                        "debet"=>0,
                                        "kredit"=>$penyusutan];

                    $Accprovider=new AccountingServiceProvider();
                
                    $res=$Accprovider->jurnal_save($jurnal);
                    

                    ///////// simpan penyusutan //////////////
                    $susut=new Accaktivajurnaldetail();
                    $susut->accaktivas_id=$aktiva->id;
                    $susut->accaktivajurnals_id=$aktivajurnal_id;
                    $susut->nominal=$penyusutan;
                    $susut->users_id=$user["id"];
                    $susut->accjurnals_id=$res["accjurnals_id"];
                    $susut->save();
                }
            }
            $this->session->setFlash('success', 'Akumulasi tersimpan');
            return $response->withRedirect($this->router->pathFor('accounting-aktiva-penyusutan'));
            //return $response;
        }else{
            $data["aktivajurnals"]=Accaktivajurnal::orderBy("tanggal","asc")->get();
            return $this->renderer->render($response, 'accounting/aktiva-penyusutan-form', $data);
        }
    }

    public function penyusutan_delete(Request $request, Response $response, Array $args){
        $data['app_profile'] = $this->app_profile;
        $user = Session::getActiveUser();

    }
}


