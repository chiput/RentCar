<?php

namespace App\Controller\Restoran;

use Slim\Http\Request;
use Slim\Http\Response;
use App\Controller\Controller;
use App\Model\Resmeja;
use App\Model\Respelanggan;
use App\Model\Respesanan;
use App\Model\Respesanandetail;
use App\Model\Resmenu;
use App\Model\Room;

use Illuminate\Database\Capsule\Manager as Capsule;

class PesananController extends Controller
{
    public function __invoke(Request $request, Response $response, Array $args)
    {
        //$data=["menu_kategoris"=>Reskategori::all()];
        $data['app_profile'] = $this->app_profile;

        //$data['respesanans'] =Respesanan::all();
        // $data['respesanans'] =$this->db->table('respesanan')
        //                         ->leftjoin('rooms', 'rooms.id', '=', 'respesanan.pelangganid')
        //                         ->leftjoin('resmeja','resmeja.id','=','respesanan.mejaid')
        //                         ->leftjoin('users','users.id','=','respesanan.users_id')

        //                         ->leftjoin('respelanggan', 'respelanggan.id', '=', 'respesanan.pelangganid')
        //                         ->select('respesanan.*','respelanggan.nama as pelanggannama','rooms.number as roomnama','resmeja.kode as kodemeja','users.name as namauser')->latest()->get();

                                // $data['respesanans'] =Capsule::select("select *,( select B.check_out_id from reservations I, reservationdetails O, addcharges P where I.id=O.reservations_id and P.reservationdetails_id=O.id and P.nobukti=(select nobukti from reskasir where id=id_kasir) and  check_out_id is  null) as isBAyar from (select A.*, C.kode as kodemeja , D.name as namauser,( select R.id from reskasir R,reskasirdetail T,respesanan Y where R.id=T.id2 and Y.id=T.pesananid and Y.id=A.id) as id_kasir,(select number from rooms where id=A.pelangganid) as roomnama,(select nama from respelanggan where id=A.pelangganid) as pelanggannama  from respesanan A,resmeja C,users D where  C.id=A.mejaid   )xx order by id desc");
                                $data['respesanans'] =Capsule::select("
                                    SELECT 
                                        *,
                                        (SELECT bayar from reskasir WHERE  id=id_kasir) as nominalBayar,
                                        IFNULL(( SELECT o.checkout_at from reservations I, reservationdetails o, addcharges P WHERE I.id=o.reservations_id and P.reservationdetails_id=o.id and P.nobukti=(SELECT nobukti from reskasir WHERE id=id_kasir LIMIT 1) ),'-') as isBAyar 
                                    from(
                                            SELECT A.*, C.kode as kodemeja , D.name as namauser,
                                            (SELECT R.id from reskasir R,reskasirdetail T,respesanan Y WHERE R.id=T.id2 and Y.id=T.pesananid and Y.id=A.id) as id_kasir,

                                       
                                            (SELECT number FROM rooms WHERE id=(SELECT rooms_id FROM reservationdetails WHERE id=A.pelangganid)) AS roomnama,
                                            (SELECT nama from respelanggan WHERE id=A.pelangganid) as pelanggannama 

                                         from respesanan A,resmeja C,users D WHERE  C.id=A.mejaid   

                                         )xx order by id desc

                                    ");



        return $this->renderer->render($response, 'restoran/pesanan', $data);
    }
        //select A.id from reskasir A,reskasirdetail B,respesanan C where A.id=B.id2 and C.id=B.pesananid and C.id=8

    public function form(Request $request, Response $response, Array $args)
    {
        if (isset($args['id'])){
            $data['Respesanan'] = Respesanan::find($args['id']);
            $data['pesanandetails'] = $this->db->table('respesanandetail')
                                ->join('resmenu', 'resmenu.id', '=', 'respesanandetail.menuid')
                                ->select('respesanandetail.*','resmenu.nama as namamenu','resmenu.kode as kodemenu','respesanandetail.kuantitas')->where('respesanandetail.id2','=',$args['id'])->get();
         $data['Resmejas'] =Capsule::select("select xx.* from (select A.*,IFNULL(( select cetak from respesanan where respesanan.mejaid =A.id and cetak=0  ),'-') as cetak from resmeja A)xx where cetak='-' or id=". $data['Respesanan']->mejaid);

        }
        else{
            $data['pesanandetails'] = $this->db->table('respesanandetail')
                                ->join('resmenu', 'resmenu.id', '=', 'respesanandetail.menuid')
                                ->select('respesanandetail.*','resmenu.nama as namamenu','resmenu.kode as kodemenu')->where('respesanandetail.id2','=','0')->get();
            $data['NoBukti'] =$this->GenericNoBukti(count($this->db->table('respesanan')->get()));
            $data['Resmejas'] =Capsule::select("select xx.* from (select A.*,IFNULL(( select cetak from respesanan where respesanan.mejaid =A.id and cetak=0  ),'-') as cetak from resmeja A)xx where cetak='-'");
            $data['checkedAdd']="checked='checked'";
        }

        $data['app_profile'] = $this->app_profile;

        $data['errors'] = $this->session->getFlash('error_messages');
        if (!is_null($data['errors'])) {
            $data['menu'] = (object) $this->session->getFlash('post_data');

        }

        $data['Resmenus'] =Resmenu::all();
        
        $data['Respelanggans'] =Respelanggan::all();

        // $data['Resmejas'] =$this->db->table('resmeja')->leftjoin('respesanan','respesanan.mejaid','=','resmeja.id')->select('resmeja.*')->where('resmeja.aktif','=','1')->whereNull('respesanan.cetak')->orwhere('respesanan.cetak','<>','0')->get();
      

       // $data['Rooms'] =Room::all();
        $data['Rooms']=  Capsule::select("select C.*,(select name from guests where id=A.guests_id) as namapengunjung,B.id as reservationdetails_id  from reservations A,reservationdetails B,rooms C where  A.id=B.reservations_id and C.id=B.rooms_id and B.checkin_code is not null and B.checkout_at is null group by C.id");

        $data['idmeja'] =$args['idmeja'];

        return $this->renderer->render($response, 'restoran/pesanan-form', $data);
    }

    public function GenericNoBukti($NoBukti){
        $repesanans= $this->db->table('respesanan')->get();
        // if($NoBukti==0){
        //  // $NoBukti++;
        //     $NoBuktitext="000".$NoBukti++;
        // }else
        $NoBukti=$NoBukti+1;
        if ($NoBukti<10){
            $NoBuktitext="000".$NoBukti;
        }else if ($NoBukti<100){
            $NoBuktitext="00".$NoBukti;
        }else if ($NoBukti<1000){
            $NoBuktitext="0".$NoBukti;
        }
        else if ($NoBukti<10000){
            $NoBuktitext=$NoBukti;
        }
        $status=true;
         foreach ($repesanans as $repesanan ) {
            if(strtolower($repesanan->nobukti)==strtolower("RP.".date('y').date('m').$NoBuktitext)){
                //$NoBukti++;
                 $status=false;
            }
        }
        if(!$status){
           return $this->GenericNoBukti($NoBukti);
        }
        else{
            return "RP.".date('y').date('m').$NoBuktitext ;
        }
    }

    public function save(Request $request, Response $response, Array $args)
    {
        $postData = $request->getParsedBody();

        // validation
        $this->validation->validate([
            'tanggal|Tanggal ' => [$postData['tanggal'], 'required'],
            'nobukti|No Bukti ' => [$postData['nobukti'], 'required'],
            'meja|Meja ' => [$postData['mejaid'], 'required'],
            'total|Total ' => [$postData['finaltotal'], 'required']

        ]);
        if(!$postData['mejaid']){
            $postData['mejaid']='0';
        }
        if (!$this->validation->passes()) {

            $this->session->setFlash('error_messages', $this->validation->errors()->all());
            $this->session->setFlash('post_data', $postData);

            if ($postData['id'] == '') {
                return $response->withRedirect($this->router->pathFor('pesanan-add',['idmeja'=>$postData['mejaid']]));
            } else {
                return $response->withRedirect($this->router->pathFor('pesanan-edit',['id'=>$postData['id']]));
            }
        }

        if(empty($postData['pelangganid']) && empty($postData['nokamarid'])){
            $this->session->setFlash('error_messages', array('Data Pelanggan atau No.Kamar Kosong'));
             if ($postData['id'] == '') {
                return $response->withRedirect($this->router->pathFor('pesanan-add',['idmeja'=>$postData['mejaid']]));
            } else {
                return $response->withRedirect($this->router->pathFor('pesanan-edit',['id'=>$postData['id']]));
            }
        }else{
            if(empty($postData['pelangganid'])){
                $jenispelanggan='1';
                $idpelanggan=$postData['nokamarid'];

            }else{
                $jenispelanggan='2';
                $idpelanggan=$postData['pelangganid'];
            }
        }

        // insert
        if ($postData['id'] == '') {
            $this->session->setFlash('success', 'Data Pesanan ditambahkan');
            $Respesanan = new Respesanan();
            $Respesanan->created_at = date('Y-m-d H:i:s');
        } else {
        // update
            $this->session->setFlash('success', 'Data Pesanan diperbarui');
            $Respesanan = Respesanan::find($postData['id']);
            $Respesanan->updated_at = date('Y-m-d H:i:s');
        }

        $Respesanan->tanggal = $postData['tanggal'];
        $Respesanan->nobukti = $postData['nobukti'];
        $Respesanan->pelangganid = $idpelanggan;
        $Respesanan->mejaid = $postData['mejaid'];
        $Respesanan->jenispelanggan = $jenispelanggan;
        $Respesanan->keterangan = $postData['Keterangan'];
        $Respesanan->proses = '0';
        $Respesanan->cetak = '0';

        $Respesanan->users_id=$this->session->get('activeUser')["id"];

        $querypesanan=$Respesanan->save();
        if($querypesanan){
            $insertedId = $Respesanan->id;
            for ($i=0; $i < $postData['jumrow']; $i++) {
                if ($postData['id_'.$i]=="0"){
                  $query= array('id2' =>$insertedId,
                  'menuid' =>$postData['idmenu_'.$i],
                  'kuantitas' => $postData['kuantitas_'.$i],
                  'harga' => $postData['harga_'.$i],
                  'tunggu' => '1',
                  'batal' => '0',
                  'masak' =>'0',
                  'saji' => '0',
                  );

                   Respesanandetail::insert($query);
                }
                else{
                   Respesanandetail::where('id',$postData['id_'.$i])->update([
                                    // 'id2' =>$insertedId,
                                    'menuid' =>$postData['idmenu_'.$i],
                                    'kuantitas' => $postData['kuantitas_'.$i],
                                    'harga' => $postData['harga_'.$i]
                                
                                    ]);
                }
            }
        }

        return $response->withRedirect($this->router->pathFor('pesanan'));
    }

    public function FindUser(Request $request, Response $response, Array $args)
    {
        $users = $this->db->table('users')->select('name')->where('id','=',$args['id'])->first();

        return $users->name;
    }

    public function delete(Request $request, Response $response, Array $args)
    {
        $Respesanan = Respesanan::find($args['id']);
        $Respesanan->delete();
        $this->session->setFlash('success', 'Data Pesanan telah dihapus');
        return $response->withRedirect($this->router->pathFor('pesanan'));
    }
}
