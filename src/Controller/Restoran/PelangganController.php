<?php

namespace App\Controller\Restoran;

use Slim\Http\Request;
use Slim\Http\Response;
use App\Controller\Controller;
use App\Model\Respelanggan;
use App\Model\Kota;

class PelangganController extends Controller
{
    public function __invoke(Request $request, Response $response, Array $args)
    {
        $data['app_profile'] = $this->app_profile;
        $data['pelanggans'] =Respelanggan::all();

        return $this->renderer->render($response, 'restoran/pelanggan', $data);
    }


    public function form(Request $request, Response $response, Array $args)
    {
        if (isset($args['id'])) {
            $data['pelanggan'] = Respelanggan::find($args['id']);
            // $data['kotaKu']=Kota::whereId($data['pelanggan']->kotaid)->first()->nama;
        }

        $data['app_profile'] = $this->app_profile;

        $data['errors'] = $this->session->getFlash('error_messages');
        if (!is_null($data['errors'])) {
            $data['pelanggan'] = (object) $this->session->getFlash('post_data');
        }
        // $data['kotas'] = $this->db->table('kota')
        //                 ->join('propinsi', 'kota.propinsiid', '=', 'propinsi.id')
        //                 ->select('kota.id','kota.nama', 'propinsi.id as profid', 'propinsi.nama as profnama')
        //                 ->get();

        //               if (isset($args['data'])) {

        //     $datasingle=explode('!',$args['data']);
            
        //             $data['kodepelanggan']=$datasingle[0];
        //             $data['nama']=$datasingle[1];
        //             $data['contact']=$datasingle[2];
        //             $data['alamat']=$datasingle[3];
        //             $data['kota']=$datasingle[4];
        //             $data['telpon']=$datasingle[5];
        //     }
        return $this->renderer->render($response, 'restoran/pelanggan-form', $data);
    }

    public function save(Request $request, Response $response, Array $args)
    {
        $postData = $request->getParsedBody();

        // validation
        $this->validation->validate([
            'kode_pelanggan|Kode Pelanggan' => [$postData['kode_pelanggan'], 'required'],
            'nama|Nama Pelanggan' => [$postData['nama_pelanggan'], 'required'],
            'telpon|Telpon' => [$postData['telpon'], 'required|number'],

        ]);
        if (!$this->validation->passes()) {

            $this->session->setFlash('error_messages', $this->validation->errors()->all());
            $this->session->setFlash('post_data', $postData);

            if ($postData['id'] == '') {
                return $response->withRedirect($this->router->pathFor('pelanggan-new'));
            } else {
                return $response->withRedirect($this->router->pathFor('pelanggan-edit',['id'=>$postData['id']]));
            }

        }

        // insert
        if ($postData['id'] == '') {
            $validasikode=$this->cekKode($postData['kode_pelanggan']);
                if($validasikode){
                $this->session->setFlash('success', 'Data Pelanggan ditambahkan');
                $Pelanggan = new Respelanggan();
                $Pelanggan->created_at = date('Y-m-d H:i:s');
            }else{
                $this->session->setFlash('error_messages',array('Data Kode Sudah Ada'));
                return $response->withRedirect($this->router->pathFor('pelanggan-new'));
            }
        } else {
            // update
            $dataKode = Respelanggan::whereId($postData['id'])->first();
            $validasikode=$this->cekKode($postData['kode_pelanggan']);
             if($validasikode || $postData['kode_pelanggan']==$dataKode->kode_pelanggan){
            $this->session->setFlash('success', 'Data Pelanggan diperbarui');
            $Pelanggan = Respelanggan::find($postData['id']);
            $Pelanggan->updated_at = date('Y-m-d H:i:s');
            }else{
                $this->session->setFlash('error_messages',array('Data Kode Sudah Ada'));
                return $response->withRedirect($this->router->pathFor('pelanggan-edit',['id'=>$postData['id']]));
            }
        }

        $Pelanggan->kode_pelanggan = $postData['kode_pelanggan'];
        $Pelanggan->nama = $postData['nama_pelanggan'];
        $Pelanggan->telepon = $postData['telpon'];
        $Pelanggan->users_id=$this->session->get('activeUser')["id"];
        $Pelanggan->save();

        return $response->withRedirect($this->router->pathFor('pelanggan'));
    }

    public function delete(Request $request, Response $response, Array $args)
    {
        $Pelanggan = Respelanggan::find($args['id']);
        $Pelanggan->delete();
        $this->session->setFlash('success', 'Data Pelanggan telah dihapus');
        return $response->withRedirect($this->router->pathFor('pelanggan'));
    }

    private function cekKode($id){
      $result=true;
      $datas = $this->db->table('respelanggan')->select('kode_pelanggan')->get();
      foreach ($datas as $data) {
        if(strtolower($id)==strtolower($data->kode_pelanggan)){
             $result=false;
        }
      }
      return $result;
    }
}
