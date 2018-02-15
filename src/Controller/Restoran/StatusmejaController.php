<?php

namespace App\Controller\Restoran;

use Slim\Http\Request;
use Slim\Http\Response;
use App\Controller\Controller;
use App\Model\Reskategori;
use App\Model\Resmeja;
use Illuminate\Database\Capsule\Manager as Capsule;
class StatusMejaController extends Controller
{
    public function __invoke(Request $request, Response $response, Array $args)
    {
        //$data=["menu_kategoris"=>Reskategori::all()];
        $data['app_profile'] = $this->app_profile;
        $data['Resmejas'] =$this->db->table('resmeja')
                            ->leftjoin('respesanan','resmeja.id','=','respesanan.mejaid')
                            ->select(Capsule::raw('resmeja.*,respesanan.cetak'))
                            ->where('resmeja.aktif','=','1')
                            ->where('respesanan.cetak','=','0')
                            ->orWhere('respesanan.cetak','=',Capsule::raw('null'))
                            //->groupBy('resmeja.id')
                            ->orderBy("respesanan.created_at","decs")->get();

        $data['Resmejas'] =Capsule::select('select A.*,( select cetak from respesanan where respesanan.mejaid =A.id and cetak=0  ) as cetak from resmeja A order by created_at desc ');
        $data['statuscetak']=$args['statuscetak'];
        return $this->renderer->render($response, 'restoran/statusmeja', $data);
    }


    public function form(Request $request, Response $response, Array $args)
    {
       
        if (isset($args['id'])) $data['menu'] = Reskategori::find($args['id']);
        $data['app_profile'] = $this->app_profile;
        

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
            'name|Nama Kategori' => [$postData['name'], 'required'],
           
        ]);
        if (!$this->validation->passes()) {

            $this->session->setFlash('error_messages', $this->validation->errors()->all());
            $this->session->setFlash('post_data', $postData);

            if ($postData['id'] == '') {
                return $response->withRedirect($this->router->pathFor('menukategori-add'));
            } else {
                return $response->withRedirect($this->router->pathFor('menukategori-edit'));
            }
        }

        $validasiRowG=Reskategori::where('kode','=',$postData['kode'])->get()->count();//Validasi Cek Data Kode
        $validasiKodes= $this->db->table('reskategori')//Validasi Cek Kode
                        ->select('id','kode')
                        ->where('deleted_at','=',null)->get();

        if($validasiRowG && $postData['id'] ==''){
                $this->session->setFlash('error_messages', array('Data Sudah Ada' ));
                return $response->withRedirect($this->router->pathFor('menukategori-add'));
        }else if($postData['id']!='' && $validasiRowG>0 ){

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
                $MenuKategori->updated_at ='';
            
        } else {
        // update
            $this->session->setFlash('success', 'Data Menu Katagori diperbarui');
            $MenuKategori = Reskategori::find($postData['id']);
            $MenuKategori->updated_at = date('Y-m-d H:i:s');
        }
        $MenuKategori->nama = $postData['name'];
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
