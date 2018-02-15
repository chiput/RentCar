<?php

namespace App\Controller\Restoran;

use Slim\Http\Request;
use Slim\Http\Response;
use App\Controller\Controller;
use App\Model\Reswaiter;
use App\Model\Kota;

class WaiterController extends Controller
{
    public function __invoke(Request $request, Response $response, Array $args)
    {
        $data['app_profile'] = $this->app_profile;
        $data['waiters'] =Reswaiter::all();

        return $this->renderer->render($response, 'restoran/waiter', $data);
    }


    public function form(Request $request, Response $response, Array $args)
    {
        if (isset($args['id'])) {
            $data['waiter'] = Reswaiter::find($args['id']);
            $data['kotaKu']=Kota::whereId($data['waiter']->kotaid)->first()->nama;
        }

        $data['app_profile'] = $this->app_profile;

        $data['errors'] = $this->session->getFlash('error_messages');
        if (!is_null($data['errors'])) {
            $data['waiter'] = (object) $this->session->getFlash('post_data');
        }
        $data['kotas'] = $this->db->table('kota')
                        ->join('propinsi', 'kota.propinsiid', '=', 'propinsi.id')
                        ->select('kota.id','kota.nama', 'propinsi.id as profid', 'propinsi.nama as profnama')
                        ->get();

                      if (isset($args['data'])) {

            $datasingle=explode('!',$args['data']);
            
                    $data['kodewaiter']=$datasingle[0];
                    $data['nama']=$datasingle[1];
                    $data['alamat']=$datasingle[3];
                    $data['telpon']=$datasingle[5];
            }
        return $this->renderer->render($response, 'restoran/waiter-form', $data);
    }

    public function save(Request $request, Response $response, Array $args)
    {
        $postData = $request->getParsedBody();

        // validation
        $this->validation->validate([
            'kode|Kode Waiter' => [$postData['kode'], 'required'],
            'nama|Nama Waiter' => [$postData['nama'], 'required'],
            'telpon|Telpon' => [$postData['telpon'], 'required|number'],

        ]);
        if (!$this->validation->passes()) {

            $this->session->setFlash('error_messages', $this->validation->errors()->all());
            $this->session->setFlash('post_data', $postData);

            if ($postData['id'] == '') {
                return $response->withRedirect($this->router->pathFor('waiter-data',['data'=>$postData['kode']."!".$postData['nama']."!".$postData['alamat']."!".$postData['telpon']]));
            } else {
                return $response->withRedirect($this->router->pathFor('waiter-data',['data'=>$postData['kode']."!".$postData['nama']."!".$postData['alamat']."!".$postData['telpon']]));
           }
        }

        // insert
        if ($postData['id'] == '') {
            $validasikode=$this->cekKode($postData['kode']);
                if($validasikode){
                $this->session->setFlash('success', 'Data waiter ditambahkan');
                $Meja = new Reswaiter();
                $Meja->created_at = date('Y-m-d H:i:s');
            }else{
                $this->session->setFlash('error_messages',array('Data Kode Sudah Ada'));
                return $response->withRedirect($this->router->pathFor('waiter-new'));
            }
        } else {
            // update
            $dataKode = Reswaiter::whereId($postData['id'])->first();
            $validasikode=$this->cekKode($postData['kode']);
             if($validasikode || $postData['kode']==$dataKode->kode){
            $this->session->setFlash('success', 'Data waiter diperbarui');
            $Meja = Reswaiter::find($postData['id']);
            $Meja->updated_at = date('Y-m-d H:i:s');
            }else{
                $this->session->setFlash('error_messages',array('Data Kode Sudah Ada'));
                return $response->withRedirect($this->router->pathFor('waiter-edit',['id'=>$postData['id']]));
            }
        }

        $Meja->kode = $postData['kode'];
        $Meja->nama = $postData['nama'];
        $Meja->alamat = $postData['alamat'];
        $Meja->telepon = $postData['telpon'];

        $Meja->users_id=$this->session->get('activeUser')["id"];
        $Meja->save();

        return $response->withRedirect($this->router->pathFor('waiter'));
    }

    public function delete(Request $request, Response $response, Array $args)
    {
        $Meja = Reswaiter::find($args['id']);
        $Meja->delete();
        $this->session->setFlash('success', 'Data waiter telah dihapus');
        return $response->withRedirect($this->router->pathFor('waiter'));
    }

    private function cekKode($id){
      $result=true;
      $datas = $this->db->table('reswaiter')->select('kode')->get();
      foreach ($datas as $data) {
        if(strtolower($id)==strtolower($data->kode)){
             $result=false;
        }
      }
      return $result;
    }

}
