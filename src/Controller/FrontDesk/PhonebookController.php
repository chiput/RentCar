<?php

namespace App\Controller\FrontDesk;

use Slim\Http\Request;
use Slim\Http\Response;
use App\Controller\Controller;
use App\Model\Phonebook;
use App\Model\Kota;

class PhonebookController extends Controller
{
    public function __invoke(Request $request, Response $response, Array $args)
    {
        $data["phonebook"] =Phonebook::orderBy('id','desc')->get();
        return $this->renderer->render($response, 'frontdesk/phonebook', $data);
    }


    public function form(Request $request, Response $response, Array $args)
    {
        if (isset($args['id'])) {
            $data['phonebook'] = Phonebook::find($args['id']);
            $data['kotaKu']=Kota::whereId($data['phonebook']->kotaid)->first()->nama;
        }

        $data['app_profile'] = $this->app_profile;

        $data['errors'] = $this->session->getFlash('error_messages');
        if (!is_null($data['errors'])) {
            $data['phonebook'] = (object) $this->session->getFlash('post_data');
        }
        $data['kotas'] = $this->db->table('kota')
                        ->join('propinsi', 'kota.propinsiid', '=', 'propinsi.id')
                        ->select('kota.id','kota.nama', 'propinsi.id as profid', 'propinsi.nama as profnama')
                        ->get();

                      if (isset($args['data'])) {

            $datasingle=explode('!',$args['data']);
            

                    $data['nama']=$datasingle[1];
                    $data['keterangan']=$datasingle[3];
                    $data['telpon']=$datasingle[5];
            }

        $data['errors'] = $this->session->getFlash('error_messages');
        if (!is_null($data['errors'])) {
            $data['telpon'] = (object) $this->session->getFlash('post_data');
        }

        return $this->renderer->render($response, 'frontdesk/phonebook-form', $data);
    }

    public function save(Request $request, Response $response, Array $args)
    {
        $postData = $request->getParsedBody();

        // validation
        $this->validation->validate([
  
            'nama|Nama Phonebook' => [$postData['nama'], 'required'],
            'telpon|Telpon' => [$postData['telpon'], 'required|number'],

        ]);
        if (!$this->validation->passes()) {

            $this->session->setFlash('error_messages', $this->validation->errors()->all());
            $this->session->setFlash('post_data', $postData);

            if ($postData['id'] == '') {
                return $response->withRedirect($this->router->pathFor('phonebook-data',['data'=>$postData['nama']."!".$postData['keterangan']."!".$postData['telpon']]));
            } else {
                return $response->withRedirect($this->router->pathFor('phonebook-data',['data'=>$postData['nama']."!".$postData['keterangan']."!".$postData['telpon']]));
           }
        }

        // insert
        if ($postData['id'] == '') {
            $validasikode=$this->cekTelpon($postData['telpon']);
                if($validasikode){
                $this->session->setFlash('success', 'Data phone book ditambahkan');
                $phonebook = new Phonebook();
                $phonebook->created_at = date('Y-m-d H:i:s');
            }else{
                $this->session->setFlash('error_messages',array('Data Telpon Sudah Ada'));
                return $response->withRedirect($this->router->pathFor('phonebook-new'));
            }
        } else {
            // update
            $dataKode = Phonebook::whereId($postData['id'])->first();
            $validasikode=$this->cekTelpon($postData['telpon']);
             if($validasikode || $postData['telpon']==$dataKode->telepon){
            $this->session->setFlash('success', 'Data phone book diperbarui');
            $phonebook = Phonebook::find($postData['id']);
            $phonebook->updated_at = date('Y-m-d H:i:s');
            }else{
                $this->session->setFlash('error_messages',array('Data Telpon Sudah Ada'));
                return $response->withRedirect($this->router->pathFor('phonebook-edit',['id'=>$postData['id']]));
            }
        }
        $phonebook->nama = $postData['nama'];
        $phonebook->keterangan = $postData['keterangan'];
        $phonebook->telepon = $postData['telpon'];
        $phonebook->users_id=$this->session->get('activeUser')["id"];
        $phonebook->save();

        return $response->withRedirect($this->router->pathFor('phonebook'));
    }

    public function delete(Request $request, Response $response, Array $args)
    {
        $phonebook = Phonebook::find($args['id']);
        $phonebook->delete();
        $this->session->setFlash('success', 'Data phone book telah dihapus');
        return $response->withRedirect($this->router->pathFor('phonebook'));
    }

    private function cekTelpon($id){
      $result=true;
      $datas = $this->db->table('fronphonebook')->select('telepon')->get();
      foreach ($datas as $data) {
        if(strtolower($id)==strtolower($data->telepon)){
             $result=false;
        }
      }
      return $result;
    }


}
