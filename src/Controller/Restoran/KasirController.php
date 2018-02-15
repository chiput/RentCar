<?php

namespace App\Controller\Restoran;

use Slim\Http\Request;
use Slim\Http\Response;
use App\Controller\Controller;

use App\Model\Resmenu;
use App\Model\Respelanggan;
use App\Model\Respesanan;
use App\Model\Respesanandetail;
use App\Model\Option;
use App\Model\Reskasir;
use App\Model\Room;
use App\Model\Reskasirdetail;

use App\Model\Addcharge;
use App\Model\Addchargedetail;

use Kulkul\Accounting\AccountingServiceProvider;
use Illuminate\Database\Capsule\Manager as Capsule;

class KasirController extends Controller
{
    public function __invoke(Request $request, Response $response, Array $args)
    {

        
        $data['idpesanan'] = $this->db->table('respesanan')->select("respesanan.id")->where("respesanan.cetak",'=','0')->where("respesanan.mejaid",'=',$args['id'])->first()->id;
        $data['idmeja'] =  $args['id'];

        $data['LoadPesananRow'] = $this->db->table('respesanan')
                                ->leftjoin('rooms', 'rooms.id', '=', 'respesanan.pelangganid')
                                ->leftjoin('resmeja','resmeja.id','=','respesanan.mejaid')
                                ->leftjoin('users','users.id','=','respesanan.users_id')

                                ->leftjoin('respelanggan', 'respelanggan.id', '=', 'respesanan.pelangganid')
                                ->select('respesanan.*',Capsule::raw(' respelanggan.nama  as pelanggannama '),'rooms.number as nokamar','jenispelanggan as jenis','resmeja.kode as kodemeja','users.name as namauser')->where("respesanan.id",'=',$data['idpesanan'])->first();

        $data['app_profile'] = $this->app_profile;
        $data['Resmenus'] =Resmenu::all();
        $data['Respelanggans'] =Respelanggan::all();
        $data['Respesanans'] =$this->db->table('respesanan')
                                ->leftjoin('rooms', 'rooms.id', '=', 'respesanan.pelangganid')
                                ->leftjoin('resmeja','resmeja.id','=','respesanan.mejaid')
                                ->leftjoin('users','users.id','=','respesanan.users_id')

                                ->leftjoin('respelanggan', 'respelanggan.id', '=', 'respesanan.pelangganid')
                                ->select('respesanan.*',Capsule::raw(' respelanggan.nama  as pelanggannama '),'rooms.number as nokamar','jenispelanggan as jenis','resmeja.kode as kodemeja','users.name as namauser')->where("respesanan.cetak",'=','0')->get();

                    //Query Afternatif     // select * from (select A.*,B.number,D.nama,C.kode,E.name from respesanan A,rooms B,resmeja C,respelanggan D,users E where ( A.pelangganid=B.id or D.id=A.pelangganid) and C.id=A.mejaid and E.id=A.users_id and A.cetak='0')xx;
        $data['NoBukti'] =$this->GenericNoBukti(count($this->db->table('reskasir')->get()));

          $datapesanana = $this->db->table('respesanan')->select("*")->where("respesanan.cetak",'=','0')->where("respesanan.mejaid",'=',$args['id'])->first();
          $data['jenispelanggan']=$datapesanana->jenispelanggan;
          $data['pelangganid']=$datapesanana->pelangganid;

          $data['Rooms']=  Capsule::select("select C.*,(select name from guests where id=A.guests_id) as namapengunjung,B.id as reservationdetails_id  from reservations A,reservationdetails B,rooms C where  A.id=B.reservations_id and C.id=B.rooms_id and B.checkin_code is not null and B.checkout_at is null group by C.id");



        return $this->renderer->render($response, 'restoran/kasir-form', $data);
    }
     public function GenericNoBukti($NoBukti){
        $repalgs= $this->db->table('reskasir')->get();
        if ($NoBukti<10){
            $NoBuktitext="000".$NoBukti++;
        }else if ($NoBukti<100){
            $NoBuktitext="00".$NoBukti++;
        }else if ($NoBukti<1000){
            $NoBuktitext="0".$NoBukti++;
        }
        else if ($NoBukti<10000){
            $NoBuktitext=$NoBukti++;
        }
        $status=true;
         foreach ($repalgs as $reskasir ) {
            if(strtolower($reskasir->nobukti)==strtolower("RK.".date('y').date('m').$NoBuktitext)){
                //$NoBukti++;
                $status=false;
            }
        }
        if(!$status){
           return $this->GenericNoBukti($NoBukti);
        }
        else{
            return "RK.".date('y').date('m').$NoBuktitext ;
        }
    }
        public function GenericNoBuktiPesanan($NoBukti){
        $repesanans= $this->db->table('respesanan')->get();
        // if($NoBukti==0){
        //  // $NoBukti++;
        //     $NoBuktitext="000".$NoBukti++;
        // }else
        if ($NoBukti<10){
            $NoBuktitext="000".$NoBukti++;
        }else if ($NoBukti<100){
            $NoBuktitext="00".$NoBukti++;
        }else if ($NoBukti<1000){
            $NoBuktitext="0".$NoBukti++;
        }
        else if ($NoBukti<10000){
            $NoBuktitext=$NoBukti++;
        }
        $status=true;
         foreach ($repesanans as $repesanan ) {
            if(strtolower($repesanan->nobukti)==strtolower("RP.".date('y').date('m').$NoBuktitext)){
                //$NoBukti++;
                 $status=false;
            }
        }
        if(!$status){
           return $this->GenericNoBuktiPesanan($NoBukti);
        }
        else{
            return "RP.".date('y').date('m').$NoBuktitext ;
        }
    }
     public function getdata(Request $request, Response $response, Array $args)
    {
      
        $data['app_profile'] = $this->app_profile;
        $data['Resmenus'] =Resmenu::all();
        

         
        return $this->renderer->render($response, 'restoran/kasir-form', $data);
    }

     public function changecetak(Request $request, Response $response, Array $args)
    {
         $dataquerys=$this->db->table('Reskasirdetail')
            ->select('Reskasirdetail.pesananid')
            ->where('Reskasirdetail.id2','=',$args['id'])->get();



         Reskasir::where('id',$args['id'])->update(['cetak' =>'2']);
         foreach ($dataquerys as $dataquery) {
             Respesanan::where('id',$dataquery->pesananid)->update(['cetak' =>'2']);
         }
         
        

         
         return $response->withRedirect($this->router->pathFor('statusmeja'));
    }



     public function save(Request $request, Response $response, Array $args){
        $postData = $request->getParsedBody();
        
        $jurnal_id =$this->post_jurnal($postData);
        // return $response;
        // validation
        $this->validation->validate([
            'tanggal|Tanggal' => [$postData['tanggal'], 'required'],
            'nobukti|No Bukti' => [$postData['nobukti'], 'required'],
            'pelanggan|Pelanggan' => [$postData['pelangganid'], 'required'],
            'pembayaran|Pembayaran' => [$postData['jenispembayaran'], 'required'],
            'subtotal|Sub Total' => [$postData['subtotal'], 'required'],
            'total|Total ' => [$postData['total'], 'required']
            //'tunai|Tunai ' => [$postData['tunai'], 'required']

        ]);
        if (!$this->validation->passes()) {

            $this->session->setFlash('error_messages', $this->validation->errors()->all());
            $this->session->setFlash('post_data', $postData);

            if ($postData['id'] == '') {
                 
                       return $response->withRedirect($this->router->pathFor('kasir',['id'=>$postData['pesanaidURL'],'idmeja'=>$postData['mejaidURL']]));
            }
        }

        // insert
       
            $this->session->setFlash('success', 'Sukses Transaksi');
            $kasir = new Reskasir();
            $kasirdetail = new Reskasirdetail();
            
            $tunai='0';
            $tempo='0';
            $nokamar='-';
            echo $postData['jenispembayaran'];
        if($postData['jenispembayaran']=='1'){
            $tunai='1';
        }else if($postData['jenispembayaran']=='2'){
            $tempo=$postData['tempohari'];
        }else if($postData['jenispembayaran']=='3'){
            $nokamar=$postData['nokamarid'];
        }
        //echo var_dump($postData);

        $kasir->tanggal = $postData['tanggal'];
        $kasir->nobukti = $postData['nobukti'];
        $kasir->pelangganid = $postData['pelangganid'];
        $kasir->mejaid2 = $postData['mejaidURL'];
        $kasir->pisah = (@$postData['pisah']==""?0:1);
        $kasir->diskonpersen = $postData['persendiskon'];
        $kasir->diskon = $postData['diskon'];
        $kasir->service = $postData['persenservice'];
        $kasir->nservice = $postData['service'];
        $kasir->ppn = $postData['persenppn'];
        $kasir->nppn = $postData['ppn'];
        $kasir->bayar = $postData['bayar'];
        $kasir->kembalian = $postData['kembali'];
        $kasir->tunai =  $tunai;
        $kasir->tempo = $tempo;
        $kasir->checkinid = $nokamar;
        $kasir->keterangan = $postData['keterangan'];
        $kasir->cetak = 1;
        $kasir->created_at = date('Y-m-d H:i:s');
        $kasir->jurnalid = $jurnal_id;
       echo  $nokamar;
       $querykasir=$kasir->save();
        if($querykasir){
            $insertedId = $kasir->id;

            for ($i=0; $i < $postData['jumlahrowpesanan']; $i++) {
                if(@$postData['idpesanan_'.$i]){
                    $query= array('id2' =>$insertedId,
                    'pesananid' =>@$postData['idpesanan_'.$i],
                    'created_at' =>date('Y-m-d H:i:s')
                    );
                    Reskasirdetail::insert($query);
                    Respesanan::where('id',$postData['idpesanan_'.$i])->update([
                                  'cetak' =>'1']);
                }
            }

            if($postData['jumrowmenu']>0 and @$postData['idpesanan_0']!=0){
              $pesananid=$this->tambahPesanan($postData['tanggal'],$postData['pelangganid'],$postData['mejaidURL'],$nokamar,$postData);
              $query= array('id2' =>$insertedId,
                    'pesananid' =>$pesananid,
                    'created_at' =>date('Y-m-d H:i:s')
                    );
                    Reskasirdetail::insert($query);
            }
            echo $nokamar;
            if ($nokamar!='-'){
                $Reservasidetail_id=0;
                $queryReservasidetails=  Capsule::select("select id from reservationdetails where checkin_code is not null  and check_out_id is null and rooms_id =".$nokamar);
                foreach ($queryReservasidetails as $queryReservasidetail) {
                    $Reservasidetail_id=$queryReservasidetail->id;
                }
                $Addcharge = new Addcharge();
                $Addcharge->tanggal=$postData['tanggal'];
                $Addcharge->nobukti=$postData['nobukti'];
                $Addcharge->reservationdetails_id=$Reservasidetail_id;
                $Addcharge->accjurnals_id=0;
                $Addcharge->service=0;
                $Addcharge->nservice=0;
                $Addcharge->nppn=0;
                $Addcharge->ntotal=$postData['total'];
                $Addcharge->remark='Restoran';
                $Addcharge->pisah=(@$postData['pisah']==""?0:1);
                $Addcharge->users_id=$this->session->get('activeUser')["id"];
                $AddchargeQuery=$Addcharge->save();
                if($AddchargeQuery){
                    $Addchargedetail = new Addchargedetail();
                    $Addchargedetail->addcharges_id=$Addcharge->id;
                    $Addchargedetail->addchargetypes_id=0;
                    $Addchargedetail->remark='Restoran';
                    $Addchargedetail->qty=0;
                    $Addchargedetail->sell=0;
                    $Addchargedetail->buy=0;
                    $Addchargedetail->users_id=$this->session->get('activeUser')["id"];
                    $Addchargedetail->save();
                }

            }

            


        }

       // return $response->withRedirect($this->router->pathFor('statusmejacetak',['statuscetak' => $insertedId]));
       return $response->withRedirect($this->router->pathFor('pesanan'));
    }


     public function ajax(Request $request, Response $response, Array $args)
    {
        
        $postData = $request->getParsedBody();
        $id=$postData['id'];
     

        $data=$this->db->table('respesanan')
            ->leftjoin('respesanandetail', 'respesanandetail.id2', '=', 'respesanan.id')
            ->leftjoin('resmenu','resmenu.id','=','respesanandetail.menuid')
            ->select('resmenu.*','respesanandetail.kuantitas as kuantitaspesanan')->where('respesanan.id','=',$id)->get();


         return json_encode($data);

    }

       public function ajaxupdate(Request $request, Response $response, Array $args)
    {
        
        $postData = $request->getParsedBody();
        $idmenu=$postData['idmenu'];
        $idpesanan=$postData['idpesanan'];
        $kuantitas=$postData['kuantitas'];
     
        Respesanandetail::where('menuid',$idmenu)->where('id2',$idpesanan)->update([
                                  'kuantitas' =>$kuantitas]);
    }
  
    function tambahPesanan($tanggal,$idpelanggan,$mejaid,$room,$postData){
        if($idpelanggan!='-'){
            $jenispelanggan=2;
        }else{
            $jenispelanggan=1;
            $idpelanggan=@$room;
        }
        $Respesanan = new Respesanan();
        $Respesanan->tanggal = $tanggal;
        $Respesanan->nobukti = $this->GenericNoBuktiPesanan(count($this->db->table('respesanan')->get()));
        $Respesanan->pelangganid = $idpelanggan;
        $Respesanan->mejaid = $mejaid;
        $Respesanan->jenispelanggan = $jenispelanggan;
        $Respesanan->keterangan = 'tambah di kasir';
        $Respesanan->proses = '0';
        $Respesanan->cetak = '1';

        $Respesanan->users_id=$this->session->get('activeUser')["id"];

        $querypesanan=$Respesanan->save();
        if($querypesanan){
            $insertedId = $Respesanan->id;
            for ($i=0; $i < $postData['jumrowmenu']; $i++) {
                if($postData['pesananid_'.$i]==0){
                    $query= array('id2' =>$insertedId,
                  'menuid' =>$postData['id_'.$i],
                  'kuantitas' => $postData['kuantitas_'.$i],
                  'harga' => $postData['harga_'.$i],
                  'tunggu' => '1',
                  'batal' => '0',
                  'masak' =>'0',
                  'saji' => '0',
                  );

                   Respesanandetail::insert($query);
                }
                  
             
            }
        }
        return $insertedId ;
    }

 
    



private function post_jurnal($postData){
		$jurnal=[
	            "id"=>"",
	            "code" => "",
	            "tanggal" => date('Y-m-d', strtotime($postData['tanggal'])),
	            "nobukti" => "",
	            "keterangan" => "Penjualan restoran ".$postData['nobukti'] ,
	            "details"=>[]
	        ];

        $penjualan_bersih = $postData['bayar']-$postData['kembali']-$postData['ppn']-$postData['service']-$postData['diskon'];


        $jurnal["details"][]=[
            "accounts_id"=>Option::where("name","=","kas")->first()->value,
            "debet"=>$penjualan_bersih+$postData['service']-($postData['ppn']+$postData['diskon']),
            "kredit"=>0
        ]; // simpan ke kas

	        
        $jurnal["details"][]=[
            "accounts_id"=>Option::where("name","=","pend_restoran")->first()->value,
            "debet"=>0,
            "kredit"=>$penjualan_bersih
        ]; // simpan pendapatan resto

        $jurnal["details"][]=[
            "accounts_id"=>Option::where("name","=","ppn_jual")->first()->value,
            "debet"=>$postData['ppn']*1,
            "kredit"=>0
        ]; // simpan biaya ppn

        $jurnal["details"][]=[
            "accounts_id"=>Option::where("name","=","pend_service")->first()->value,
            "debet"=>0,
            "kredit"=>$postData['service']*1
        ]; // simpan pendapatan service

        $jurnal["details"][]=[
            "accounts_id"=>Option::where("name","=","b_diskon")->first()->value,
            "debet"=>$postData['diskon']*1,
            "kredit"=>0
        ]; // simpan biaya diskon

        $Accprovider=new AccountingServiceProvider();

        $accounting=$Accprovider->jurnal_save($jurnal);

        if($accounting["stat"]=="error"){
        	echo $accounting["mess"];
        	return false;
        }

        //print_r($accounting);
        return $accounting["accjurnals_id"];
	}

    


	public function print_preview(Request $request, Response $response, Array $args){
		
	}
}
