<?php

namespace App\Controller\Restoran;

use Slim\Http\Request;
use Slim\Http\Response;
use App\Controller\Controller;
use App\Model\Resmenu;
use App\Model\Reskategori;
use App\Model\Barang;
use App\Model\Account;
use App\Model\Resmenudetail;
use App\Model\Brgsatuan;
use App\Model\Konversi;
use Illuminate\Database\Capsule\Manager as Capsule;

class MenuController3 extends Controller
{
    public function __invoke(Request $request, Response $response, Array $args)
    {

        $data['app_profile'] = $this->app_profile;
        $data['Menus'] = $this->db->table('resmenu')
                        ->join('reskategori','resmenu.kategoriid','=','reskategori.id')
                         ->select('resmenu.*','reskategori.nama as namakategori' )
                        ->get()->sortByDesc("created_at");

       return $this->renderer->render($response, 'restoran/menu', $data);


    }

    public function form(Request $request, Response $response, Array $args)
    {

        if (isset($args['id'])){
            $data['menu'] = Resmenu::find($args['id']);
            $menu = Resmenu::find($args['id']);
            $data['menudetails'] = $this->db->table('resmenudetail')
                        ->join('barang', 'resmenudetail.barangid', '=', 'barang.id')
                        ->select('barang.kode','barang.id as barangid','barang.nama as barangnama','barang.brgsatuan_id as satuanbarang','barang.hargastok' ,"resmenudetail.satuanid as satuan",'resmenudetail.gudangid','resmenudetail.kuantitas','resmenudetail.id' )->where('resmenudetail.deleted_at','=',null)->where('resmenudetail.id2','=',$args['id'])->get();
            $Accountdatas= $this->db->table('accounts')->select('id','code')->where('id','=',$menu->accountid)->get();

            foreach ($Accountdatas as $Accountdata) {
                $accountid = $Accountdata->id;
                $accountnama = $Accountdata->code;
            }

            $data['Accountid']=$accountid;
            $data['Accountnama']=$accountnama;
            //Account::whered($data['menu']->accountid)->first();
           // Resmenudetail::all()->where('id2','=',$args['id']);
        }else{
              $data['menudetails'] = $this->db->table('resmenudetail')
                        ->join('barang', 'resmenudetail.barangid', '=', 'barang.id')
                        ->select('barang.kode','barang.nama as barangnama','barang.brgsatuan_id as satuanbarang','barang.hargastok' ,"resmenudetail.satuanid as satuan", 'resmenudetail.kuantitas','resmenudetail.id' )->where('id2','=','0')->get();

              $data['aktif']=2;
              $data['V_aktif']='2';
        }


        $data['app_profile'] = $this->app_profile;
        $data['Accounts'] = Account::all();
        $data['Gudangs']= $this->db->table('resgudang')
                        ->join('gudang', 'resgudang.gudangid', '=', 'gudang.id')
                        ->join('departments', 'gudang.department_id', '=', 'departments.id')
                        ->select('resgudang.id','gudang.nama', 'departments.name')->get();
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
                and D.department_id=3
            )xx");
                        ////////////////////////////////////
        $data['Bargsatuans'] = $this->db->table('brgsatuan')->select('*')->get();
        $data['Menu_kategoris'] = Reskategori::all()->where('is_active','=','1');
        $data['Konversi'] = Konversi::all();

        return $this->renderer->render($response, 'restoran/menu-form', $data);
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
                return $response->withRedirect($this->router->pathFor('restoran-menu-new'));
            } else {
                return $response->withRedirect($this->router->pathFor('restoran-menu-edit',['id'=>$postData['id']]));
            }
        }

        // insert
        if ($postData['id'] == '' ) {
            if(true==$this->CekKode($postData['kode'])){
            $this->session->setFlash('success', 'Data Menu ditambahkan');
            $menu = new Resmenu();
            $menudetail = new Resmenudetail();
            }else{
                $this->session->setFlash('error_messages', array('Kode Sudah Dipakai'));
                return $response->withRedirect($this->router->pathFor('restoran-menu-new'));
            }
        } else {
        // update
            $datakode=Resmenu::whereId($postData['id'])->first();
            if(true==$this->CekKode($postData['kode'])||$datakode->kode==$postData['kode']){
            $this->session->setFlash('success', 'Data Menu diperbarui');
            $menu = Resmenu::find($postData['id']);
            $menudetail = Resmenudetail::find($postData['id']);
            $menu->updated_at = date('Y-m-d H:i:s');
            }else{
                 $this->session->setFlash('error_messages', array('Kode Sudah Dipakai'));
                return $response->withRedirect($this->router->pathFor('restoran-menu-edit',['id'=>$postData['id']]));
            }
        }
        if ($postData['biayalain']){
           $biayalain=$postData['biayalain'];
        }else{
             $biayalain=0;
        }


        $menu->nama = $postData['nama'];
        $menu->kategoriid = $postData['kategoriid'];
        $menu->keterangan = $postData['pembuatan'];
        $menu->kode = $postData['kode'];
        $menu->accountid = $postData['Accountid'];
        $menu->biayalain =$biayalain;// $postData['biayalain'];
        $menu->hargajual = $postData['hargajual'];
        $menu->aktif = (@$postData['is_active']==""?0:1);
        $menu->users_id = $this->session->get('activeUser')["id"];
        $querymenu=$menu->save();
        if($querymenu){
            $insertedId = $menu->id;

            for ($i=0; $i < $postData['jumrow']; $i++) {

                if ($postData['id_'.$i]=="0"){

                $query= array('id2' =>$insertedId,
                'barangid' =>$postData['idbarang_'.$i],
                'satuanid' => $postData['satuanpakai_'.$i],
                'gudangid' => $postData['gudang_'.$i],
                'kuantitas' => $postData['kuantitas_'.$i]
                );

                 Resmenudetail::insert($query);
                // return  $postData['id_'.$i];

                }else{

                  Resmenudetail::where('id',$postData['id_'.$i])->update([
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

        return $response->withRedirect($this->router->pathFor('menu'));
    }

    public function delete(Request $request, Response $response, Array $args)
    {
        $menu = Resmenu::find($args['id']);
        $menu->delete();
        $this->session->setFlash('success', 'Data Menu telah dihapus');
        return $response->withRedirect($this->router->pathFor('menu'));
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
        $hasil=Capsule::select("select A.*,(select nama from brgsatuan where id=A.brgsatuan_id2) as nama from konversi A where A.brgsatuan_id1=".$postData['id']." or A.brgsatuan_id2=".$postData['id']);
        return $response->write(json_encode($hasil));
    }


    public function CekKode($id)
    {   $result=true;
         $CekKodes = $this->db->table('resmenu')->get();
         foreach ($CekKodes as $CekKode) {
           if($CekKode->kode==$id){
                $result=false;
           }
         }
         return $result;
    }

}
