<?php

namespace App\Controller\Spa;

use Slim\Http\Request;
use Slim\Http\Response;
use App\Controller\Controller;
use App\Model\Spakategori;

class KategoriLayananController extends Controller
{
    public function __invoke(Request $request, Response $response, Array $args)
    {
        $data['app_profile'] = $this->app_profile;
        $data['kategori_layanan'] =Spakategori::all()->sortByDesc("created_at");

        return $this->renderer->render($response, 'spa/kategori_layanan', $data);
    }

    public function form(Request $request, Response $response, Array $args)
    {

        if (isset($args['id'])) $data['layanan'] = Spakategori::find($args['id']);
        $data['app_profile'] = $this->app_profile;
        if (!isset($args['id'])) $data['aktif']=2;


        $data['errors'] = $this->session->getFlash('error_messages');
        if (!is_null($data['errors'])) {
            $data['layanan'] = (object) $this->session->getFlash('post_data');
        }

        return $this->renderer->render($response, 'spa/kategori_layanan_add', $data);
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
                return $response->withRedirect($this->router->pathFor('kategorilayanan-add',['kode'=>$postData['kode'],'nama'=>$postData['nama']]));
            } else {
                return $response->withRedirect($this->router->pathFor('kategorilayanan-edit',['kode'=>$postData['kode'],'nama'=>$postData['nama']]));
            }
        }

        $validasiRowG=Spakategori::where('kode','=',$postData['kode'])->get()->count();//Validasi Cek Data Kode
        $validasiKodes= $this->db->table('spakategori')//Validasi Cek Kode
                        ->select('id','kode')
                        ->where('deleted_at','=',null)->get();

        if($validasiRowG && $postData['id'] ==''){
                $this->session->setFlash('error_messages', array('Data Sudah Ada' ));
                return $response->withRedirect($this->router->pathFor('kategorilayanan-add'));
        }
        else if($postData['id']!='' && $validasiRowG>0 ){
                foreach ($validasiKodes as $validasiKode) {//Mendapat Jumlah Data PAda Tabel
                    if(($validasiKode->kode==$postData['kode']) && ($postData['id']!=$validasiKode->id)){//Cek Jika id tidak sama dan kode sama
                        $this->session->setFlash('error_messages', array('Data Sudah Ada' ));
                        return $response->withRedirect($this->router->pathFor('kategorilayanan-edit',['id'=>$postData['id']]));
                    }
                }

        }

        // insert
        if ($postData['id'] == '') {
            $this->session->setFlash('success', 'Data Kategori Layanan ditambahkan');
            $KategoriLayanan = new Spakategori();
            $KategoriLayanan->created_at = date('Y-m-d H:i:s');

        } else {
        // update
            $this->session->setFlash('success', 'Data Kategori Layanan diperbarui');
            $KategoriLayanan = Spakategori::find($postData['id']);
            $KategoriLayanan->updated_at = date('Y-m-d H:i:s');
        }
        $KategoriLayanan->nama = $postData['nama'];
        $KategoriLayanan->kode = $postData['kode'];


        $KategoriLayanan->is_active = (@$postData['is_active']==""?0:1);

        $KategoriLayanan->users_id=$this->session->get('activeUser')["id"];
        $KategoriLayanan->save();

        return $response->withRedirect($this->router->pathFor('kategorilayanan'));
    }

    public function delete(Request $request, Response $response, Array $args)
    {
        $KategoriLayanan = Spakategori::find($args['id']);
        $KategoriLayanan->delete();
        $this->session->setFlash('success', 'Data Kategori Layanan telah dihapus');
        return $response->withRedirect($this->router->pathFor('kategorilayanan'));
    }
}
