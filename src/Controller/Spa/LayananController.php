<?php

namespace App\Controller\Spa;

use Slim\Http\Request;
use Slim\Http\Response;
use App\Controller\Controller;
use App\Model\Spalayanan;
use App\Model\Spakategori;
use App\Model\Barang;
use App\Model\Spalayanandetail;
use App\Model\Brgsatuan;
use App\Model\Konversi;
use Kulkul\CurrencyFormater\FormaterAdapter;
use Illuminate\Database\Capsule\Manager as Capsule;

class LayananController extends Controller
{
    public function __invoke(Request $request, Response $response, Array $args)
    {
        $data['app_profile'] = $this->app_profile;
        $data['Layanan'] = $this->db->table('spalayanan')
                        ->join('spakategori','spalayanan.kategoriid','=','spakategori.id')
                         ->select('spalayanan.*','spakategori.nama as namakategori' )
                        ->orderby("created_at","DESC")->get();

       return $this->renderer->render($response, 'spa/layanan', $data);
    }

    public function form(Request $request, Response $response, Array $args)
    {

        if (isset($args['id'])){
            $data['layanan'] = Spalayanan::find($args['id']);
            $layanan = Spalayanan::find($args['id']);
            $data['layanandetails'] = $this->db->table('spalayanandetail')
                        ->join('barang', 'spalayanandetail.barangid', '=', 'barang.id')
                        ->select('barang.kode','barang.id as barangid','barang.nama as barangnama','barang.brgsatuan_id as satuanbarang','barang.hargastok' ,"spalayanandetail.satuanid as satuan",'spalayanandetail.gudangid','spalayanandetail.kuantitas','spalayanandetail.id' )->where('spalayanandetail.deleted_at','=',null)->where('spalayanandetail.id2','=',$args['id'])->get();
            // $Accountdatas= $this->db->table('accounts')->select('id','code')->where('id','=',$layanan->accountid)->get();

            // foreach ($Accountdatas as $Accountdata) {
            //     $accountid = $Accountdata->id;
            //     $accountnama = $Accountdata->code;
            // }

            // $data['Accountid']=$accountid;
            // $data['Accountnama']=$accountnama;
            //Account::whered($data['menu']->accountid)->first();
           // Resmenudetail::all()->where('id2','=',$args['id']);
        }else{
              $data['layanandetails'] = $this->db->table('spalayanandetail')
                        ->join('barang', 'spalayanandetail.barangid', '=', 'barang.id')
                        ->select('barang.kode','barang.nama as barangnama','barang.brgsatuan_id as satuanbarang','barang.hargastok' ,"spalayanandetail.satuanid as satuan", 'spalayanandetail.kuantitas','spalayanandetail.id' )->where('id2','=','0')->get();

              $data['aktif']=2;
              $data['V_aktif']='2';
        }


        $data['app_profile'] = $this->app_profile;
        // $data['Accounts'] = Account::all();
        $data['Gudangs']= $this->db->table('spagudang')
                        ->join('gudang', 'spagudang.gudangid', '=', 'gudang.id')
                        ->join('departments', 'gudang.department_id', '=', 'departments.id')
                        ->select('spagudang.id','gudang.nama', 'departments.name')->get();
                        ////////////////////////////////////
        $data['Barangs'] = Capsule::select("
            select * from 
            (select 
                C.*,
                D.id as gudid,
                D.nama as namagud,
                F.nama as satuannama
            from 
                gudterima A,
                gudterimadetail B,
                barang C,
                gudang D, 
                departments E,
                brgsatuan F
            where 
                A.id=B.gudterima_id 
                and B.barang_id=C.id 
                and A.gudang_id=D.id 
                and E.id=D.department_id 
                and F.id=C.brgsatuan_id 
                and D.department_id=7
            )xx");
                        ////////////////////////////////////
        $data['Bargsatuans'] = $this->db->table('brgsatuan')->select('*')->get();
        $data['kategori_layanan'] = Spakategori::all()->where('is_active','=','1');
        $data['Konversi'] = Konversi::all();

        return $this->renderer->render($response, 'spa/layanan-form', $data);
    }

    public function save(Request $request, Response $response, Array $args){
        $postData = $request->getParsedBody();
        //var_dump($postData);
        // validation
        $this->validation->validate([
            'kategori|Kategori' => [$postData['kategoriid'], 'required'],
            'kode|Kode' => [$postData['kode'], 'required'],
            'nama|Nama' => [$postData['nama'], 'required']

        ]);
        if (!$this->validation->passes()) {

            $this->session->setFlash('error_messages', $this->validation->errors()->all());
            $this->session->setFlash('post_data', $postData);

            if ($postData['id'] == '') {
                return $response->withRedirect($this->router->pathFor('spa-layanan-new'));
            } else {
                return $response->withRedirect($this->router->pathFor('spa-layanan-edit',['id'=>$postData['id']]));
            }
        }

        // insert
        if ($postData['id'] == '' ) {
            if(true==$this->CekKode($postData['kode'])){
            $this->session->setFlash('success', 'Data Layanan ditambahkan');
            $layanan = new Spalayanan();
            $layanandetail = new Spalayanandetail();
            }else{
                $this->session->setFlash('error_messages', array('Kode Sudah Dipakai'));
                return $response->withRedirect($this->router->pathFor('spa-layanan-new'));
            }
        } else {
        // update
            $datakode=Spalayanan::whereId($postData['id'])->first();
            if(true==$this->CekKode($postData['kode'])||$datakode->kode==$postData['kode']){
            $this->session->setFlash('success', 'Data Layanan diperbarui');
            $layanan = Spalayanan::find($postData['id']);
            $layanandetail = Spalayanandetail::find($postData['id']);
            $layanan->updated_at = date('Y-m-d H:i:s');
            }else{
                 $this->session->setFlash('error_messages', array('Kode Sudah Dipakai'));
                return $response->withRedirect($this->router->pathFor('spa-layanan-edit',['id'=>$postData['id']]));
            }
        }
        if ($postData['biayalain']){
           $biayalain = FormaterAdapter::reverse($postData['biayalain']);
        }else{
             $biayalain=0;
        }


        $layanan->nama_layanan = $postData['nama'];
        $layanan->kategoriid = $postData['kategoriid'];
        $layanan->keterangan = '';
        $layanan->kode = $postData['kode'];
        $layanan->accountid = 0;
        $layanan->biayalain = FormaterAdapter::reverse($biayalain);// $postData['biayalain'];
        $layanan->hargajual = FormaterAdapter::reverse($postData['hargajual']);
        $layanan->aktif = (@$postData['is_active']==""?0:1);
        $layanan->diskon = $postData['diskon'];
        $layanan->users_id = $this->session->get('activeUser')["id"];
        $querymenu=$layanan->save();
        if($querymenu){
            $insertedId = $layanan->id;

            for ($i=0; $i < $postData['jumrow']; $i++) {

                if ($postData['id_'.$i]=="0"){

                $query= array('id2' =>$insertedId,
                'barangid' =>$postData['idbarang_'.$i],
                'satuanid' => $postData['satuanpakai_'.$i],
                'gudangid' => $postData['gudang_'.$i],
                'kuantitas' => $postData['kuantitas_'.$i]
                );

                 Spalayanandetail::insert($query);
                // return  $postData['id_'.$i];

                }else{

                  Spalayanandetail::where('id',$postData['id_'.$i])->update([
                                    // 'id2' =>$insertedId,
                                    'barangid' =>$postData['idbarang_'.$i],
                                    'satuanid' => $postData['satuanpakai_'.$i],
                                    'gudangid' => $postData['gudang_'.$i],
                                    'kuantitas' => $postData['kuantitas_'.$i]
                                    ]);


                  //return  "vvaa";
                }

            }
        }

        return $response->withRedirect($this->router->pathFor('layanan'));
    }

    public function delete(Request $request, Response $response, Array $args)
    {
        $layanan = Spalayanan::find($args['id']);
        $layanan->delete();
        $this->session->setFlash('success', 'Data Layanan telah dihapus');
        return $response->withRedirect($this->router->pathFor('layanan'));
    }

       private function getData()
    {
        $account = $this->db->table('barang')

                        ->where('barang.deleted_at','=',null);

        return $account;
    }

    public function ajax(Request $request, Response $response, Array $args)
    {
        return $response->write(json_encode($this->getData()->get()));
    }
    public function ajaxKonversi(Request $request, Response $response, Array $args)
    {
        $postData = $request->getParsedBody();
        $hasil=Capsule::select("select A.*,(select nama from brgsatuan where id=A.brgsatuan_id2) as nama from konversi A where A.brgsatuan_id1=".$postData['id']." or A.brgsatuan_id2=".$postData['id']." group by A.brgsatuan_id2");
        return $response->write(json_encode($hasil));
    }


    public function CekKode($id)
    {   $result=true;
         $CekKodes = $this->db->table('spalayanan')->get();
         foreach ($CekKodes as $CekKode) {
           if($CekKode->kode==$id){
                $result=false;
           }
         }
         return $result;
    }
}