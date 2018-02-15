<?php

namespace App\Controller\Spa;

use Slim\Http\Request;
use Slim\Http\Response;
use App\Controller\Controller;
use App\Model\Spaterapis;
use App\Model\Kota;

class SpaController extends Controller
{
    public function __invoke(Request $request, Response $response, Array $args)
    {
    $data['app_profile'] = $this->app_profile;
        $data['terapis'] =Spaterapis::all();

        return $this->renderer->render($response, 'spa/terapis', $data);
    }


    public function form(Request $request, Response $response, Array $args)
    {
        if (isset($args['id'])) {
            $data['terapi'] = Spaterapis::find($args['id']);
            $data['kotaKu']=Kota::whereId($data['terapi']->kotaid)->first()->nama;
        }

        $data['app_profile'] = $this->app_profile;

        $data['errors'] = $this->session->getFlash('error_messages');
        if (!is_null($data['errors'])) {
            $data['terapi'] = (object) $this->session->getFlash('post_data');
        }
        $data['kotas'] = $this->db->table('kota')
                        ->join('propinsi', 'kota.propinsiid', '=', 'propinsi.id')
                        ->select('kota.id','kota.nama', 'propinsi.id as profid', 'propinsi.nama as profnama')
                        ->get();

                      if (isset($args['data'])) {

            $datasingle=explode('!',$args['data']);
            
                    $data['kodeterapis']=$datasingle[0];
                    $data['nama']=$datasingle[1];
                    $data['alamat']=$datasingle[3];
                    $data['telpon']=$datasingle[5];
            }
        return $this->renderer->render($response, 'spa/terapis-form', $data);
    }

    public function save(Request $request, Response $response, Array $args)
    {
        $postData = $request->getParsedBody();

        // validation
        $this->validation->validate([
            'kode|Kode Terapis' => [$postData['kode'], 'required'],
            'nama|Nama Terapis' => [$postData['nama'], 'required'],
            'telpon|Telpon' => [$postData['telpon'], 'required|number'],

        ]);
        if (!$this->validation->passes()) {

            $this->session->setFlash('error_messages', $this->validation->errors()->all());
            $this->session->setFlash('post_data', $postData);

            if ($postData['id'] == '') {
                return $response->withRedirect($this->router->pathFor('terapis-data',['data'=>$postData['kode']."!".$postData['nama']."!".$postData['alamat']."!".$postData['telpon']]));
            } else {
                return $response->withRedirect($this->router->pathFor('terapis-data',['data'=>$postData['kode']."!".$postData['nama']."!".$postData['alamat']."!".$postData['telpon']]));
           }
        }

        // insert
        if ($postData['id'] == '') {
            $validasikode=$this->cekKode($postData['kode']);
                if($validasikode){
                $this->session->setFlash('success', 'Data terapis ditambahkan');
                $terapis = new Spaterapis();
                $terapis->created_at = date('Y-m-d H:i:s');
            }else{
                $this->session->setFlash('error_messages',array('Data Kode Sudah Ada'));
                return $response->withRedirect($this->router->pathFor('terapis-new'));
            }
        } else {
            // update
            $dataKode = Spaterapis::whereId($postData['id'])->first();
            $validasikode=$this->cekKode($postData['kode']);
             if($validasikode || $postData['kode']==$dataKode->kode){
            $this->session->setFlash('success', 'Data terapis diperbarui');
            $terapis = Spaterapis::find($postData['id']);
            $terapis->updated_at = date('Y-m-d H:i:s');
            }else{
                $this->session->setFlash('error_messages',array('Data Kode Sudah Ada'));
                return $response->withRedirect($this->router->pathFor('terapis-edit',['id'=>$postData['id']]));
            }
        }

        $terapis->kode = $postData['kode'];
        $terapis->nama = $postData['nama'];
        $terapis->alamat = $postData['alamat'];
        $terapis->telepon = $postData['telpon'];

        $terapis->users_id=$this->session->get('activeUser')["id"];
        $terapis->save();

        return $response->withRedirect($this->router->pathFor('terapis'));
    }

    public function delete(Request $request, Response $response, Array $args)
    {
        $terapis = Spaterapis::find($args['id']);
        $terapis->delete();
        $this->session->setFlash('success', 'Data terapis telah dihapus');
        return $response->withRedirect($this->router->pathFor('terapis'));
    }

    private function cekKode($id){
      $result=true;
      $datas = $this->db->table('spaterapis')->select('kode')->get();
      foreach ($datas as $data) {
        if(strtolower($id)==strtolower($data->kode)){
             $result=false;
        }
      }
      return $result;
    }


}
