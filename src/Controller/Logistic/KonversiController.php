<?php

namespace App\Controller\Logistic;

use Slim\Http\Request;
use Slim\Http\Response;
use App\Controller\Controller;
use App\Model\Brgsatuan;
use App\Model\Konversi;

class Konversicontroller extends Controller 
{
    public function __invoke(Request $request, Response $response, Array $args)
    {
        $data['conversions'] = Konversi::orderBy('id','desc')->get();
        return $this->renderer->render($response, 'logistic/conversion', $data);   
    }

    public function form(Request $request, Response $response, Array $args)
    {
        $data['units'] = Brgsatuan::all();

        if(@$args["id"] != ""){
            $data['conversion'] = Konversi::find($args["id"]);
        }

        $data['errors'] = $this->session->getFlash('error_messages');
        if (!is_null($data['errors'])) {
            $data['conversion'] = (object) $this->session->getFlash('post_data');
        }
        
        $data['app_profile'] = $this->app_profile;
        return $this->renderer->render($response, 'logistic/conversion-form', $data);   
    }

    public function save(Request $request, Response $response, Array $args)
    {
        $postData = $request->getParsedBody();
        // validation
        $this->validation->validate([
            'nilai|Nilai konversi' => [$postData['nilai'], 'required'],
            'brgsatuan_id1|Satuan 1' => [$postData['brgsatuan_id1'], 'required'],
            'brgsatuan_id2|Satuan 2' => [$postData['brgsatuan_id2'], 'required'],
        ]);
        if (!$this->validation->passes()) {

            $this->session->setFlash('error_messages', $this->validation->errors()->all());
            $this->session->setFlash('post_data', $postData);

            if ($postData['id'] == '') {
                return $response->withRedirect($this->router->pathFor('logistic-conversion-add'));
            } else {
                return $response->withRedirect($this->router->pathFor('logistic-conversion-edit'));
            }
        }
        
        if($postData['id'] != ""){
            $conversion = Konversi::find($postData['id']);
            $conversion->updated_at = date("Y-m-d H:i:s");
        } else {
            $conversion = new Konversi();
        }
        
        $conversion->brgsatuan_id1 = $postData['brgsatuan_id1'];
        $conversion->nilai = $postData['nilai'];
        $conversion->brgsatuan_id2 = $postData['brgsatuan_id2'];
        $conversion->users_id = $this->session->get('activeUser')["id"];
        $conversion->save();
        
        $this->session->setFlash('success', 'Data telah tersimpan');
        return $response->withRedirect($this->router->pathFor('logistic-conversion'));
    }

    public function delete(Request $request, Response $response, Array $args)
    {
        if(@$args["id"] != ""){
            $conversion = Konversi::find($args["id"]);
        }
        if($conversion != null){
            $conversion->delete();
        }

        $this->session->setFlash('success', 'Data telah terhapus');
        return $response->withRedirect($this->router->pathFor('logistic-conversion'));
    }
}