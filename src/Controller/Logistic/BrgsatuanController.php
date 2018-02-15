<?php

namespace App\Controller\Logistic;

use Slim\Http\Request;
use Slim\Http\Response;
use App\Controller\Controller;
use App\Model\Brgsatuan;

class BrgsatuanController extends Controller 
{
    public function __invoke(Request $request, Response $response, Array $args)
    {
        $data['units'] = Brgsatuan::orderBy('id','desc')->get();
        return $this->renderer->render($response, 'logistic/unit', $data);   
    }

    public function form(Request $request, Response $response, Array $args)
    {
        if(@$args["id"] != ""){
            $data['unit'] = Brgsatuan::find($args["id"]);
        }

        $data['errors'] = $this->session->getFlash('error_messages');
        if (!is_null($data['errors'])) {
            $data['unit'] = (object) $this->session->getFlash('post_data');
        }
        
        $data['app_profile'] = $this->app_profile;
        return $this->renderer->render($response, 'logistic/unit-form', $data);   
    }

    public function save(Request $request, Response $response, Array $args)
    {
        $postData = $request->getParsedBody();
        // validation
        $this->validation->validate([
            'nama|Nama Satuan' => [$postData['nama'], 'required'],
        ]);
        if (!$this->validation->passes()) {

            $this->session->setFlash('error_messages', $this->validation->errors()->all());
            $this->session->setFlash('post_data', $postData);

            if ($postData['id'] == '') {
                return $response->withRedirect($this->router->pathFor('logistic-unit-add'));
            } else {
                return $response->withRedirect($this->router->pathFor('logistic-unit-edit'));
            }
        }
        
        if($postData['id'] != ""){
            $unit = Brgsatuan::find($postData['id']);
        } else {
            $unit = new Brgsatuan();
        }
        
        $unit->nama = $postData['nama'];
        $unit->users_id = $this->session->get('activeUser')["id"];
        $unit->save();
        
        $this->session->setFlash('success', 'Data telah tersimpan');
        return $response->withRedirect($this->router->pathFor('logistic-unit'));
    }

    public function delete(Request $request, Response $response, Array $args)
    {
        if(@$args["id"] != ""){
            $unit = Brgsatuan::find($args["id"]);
        }
        if($unit != null){
            $unit->delete();
        }

        $this->session->setFlash('success', 'Data telah terhapus');
        return $response->withRedirect($this->router->pathFor('logistic-unit'));
    }
}