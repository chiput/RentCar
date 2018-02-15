<?php

namespace App\Controller\Restoran;

use Slim\Http\Request;
use Slim\Http\Response;
use App\Controller\Controller;
use App\Model\Reskategori;

class MenuKategoriController extends Controller
{
    public function __invoke(Request $request, Response $response, Array $args)
    {
        //$data=["menu_kategoris"=>Reskategori::all()];
        $data['app_profile'] = $this->app_profile;
        $data['menu_kategoris'] =Reskategori::all()->sortByDesc("created_at");

        return $this->renderer->render($response, 'restoran/menu_kategori', $data);
    }

    public function form(Request $request, Response $response, Array $args)
    {

        if (isset($args['id'])) $data['menu'] = Reskategori::find($args['id']);
        $data['app_profile'] = $this->app_profile;
        if (!isset($args['id'])) $data['aktif']=2;


        $data['errors'] = $this->session->getFlash('error_messages');
        if (!is_null($data['errors'])) {
            $data['menu'] = (object) $this->session->getFlash('post_data');
        }

        return $this->renderer->render($response, 'restoran/menu_kategori_add', $data);
    }

    public function save(Request $request, Response $response, Array $args)
    {
        $postData = $request->getParsedBody();

        // validation
        $this->validation->validate([
            'nama|Nama ' => [$postData['nama'], 'required'],
            'kode|Kode ' => [$postData['kode'], 'required'],

        ]);
        if (!$this->validation->passes()) {

            $this->session->setFlash('error_messages', $this->validation->errors()->all());
            $this->session->setFlash('post_data', $postData);

            if ($postData['id'] == '') {
                return $response->withRedirect($this->router->pathFor('menukategori-add',['kode'=>$postData['kode'],'nama'=>$postData['nama']]));
            } else {
                return $response->withRedirect($this->router->pathFor('menukategori-edit',['kode'=>$postData['kode'],'nama'=>$postData['nama']]));
            }
        }

        $validasiRowG=Reskategori::where('kode','=',$postData['kode'])->get()->count();//Validasi Cek Data Kode
        $validasiKodes= $this->db->table('reskategori')//Validasi Cek Kode
                        ->select('id','kode')
                        ->where('deleted_at','=',null)->get();

        if($validasiRowG && $postData['id'] ==''){
                $this->session->setFlash('error_messages', array('Data Sudah Ada' ));
                return $response->withRedirect($this->router->pathFor('menukategori-add'));
        }
        else if($postData['id']!='' && $validasiRowG>0 ){
                foreach ($validasiKodes as $validasiKode) {//Mendapat Jumlah Data PAda Tabel
                    if(($validasiKode->kode==$postData['kode']) && ($postData['id']!=$validasiKode->id)){//Cek Jika id tidak sama dan kode sama
                        $this->session->setFlash('error_messages', array('Data Sudah Ada' ));
                        return $response->withRedirect($this->router->pathFor('menukategori-edit',['id'=>$postData['id']]));
                    }
                }

        }

        // insert
        if ($postData['id'] == '') {
            $this->session->setFlash('success', 'Data Menu Katagori ditambahkan');
            $MenuKategori = new Reskategori();
            $MenuKategori->created_at = date('Y-m-d H:i:s');

        } else {
        // update
            $this->session->setFlash('success', 'Data Menu Katagori diperbarui');
            $MenuKategori = Reskategori::find($postData['id']);
            $MenuKategori->updated_at = date('Y-m-d H:i:s');
        }
        $MenuKategori->nama = $postData['nama'];
        $MenuKategori->kode = $postData['kode'];


        $MenuKategori->is_active = (@$postData['is_active']==""?0:1);

        $MenuKategori->users_id=$this->session->get('activeUser')["id"];
        $MenuKategori->save();

        return $response->withRedirect($this->router->pathFor('menukategori'));
    }

    public function delete(Request $request, Response $response, Array $args)
    {
        $MenuKategori = Reskategori::find($args['id']);
        $MenuKategori->delete();
        $this->session->setFlash('success', 'Data Menu Kategori telah dihapus');
        return $response->withRedirect($this->router->pathFor('menukategori'));
    }
}
