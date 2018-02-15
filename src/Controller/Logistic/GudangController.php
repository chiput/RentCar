<?php

namespace App\Controller\Logistic;

use Slim\Http\Request;
use Slim\Http\Response;
use App\Controller\Controller;
use App\Model\Department;
use App\Model\Gudang;

class GudangController extends Controller 
{
    public function __invoke(Request $request, Response $response, Array $args)
    {
        $data['warehouses'] = Gudang::orderBy('id','desc')->get();
        return $this->renderer->render($response, 'logistic/warehouse', $data);   
    }

    public function form(Request $request, Response $response, Array $args)
    {
        $data['departments'] = Department::all();

        if(@$args["id"] != ""){
            $data['warehouse'] = Gudang::find($args["id"]);
        }

        $data['errors'] = $this->session->getFlash('error_messages');
        if (!is_null($data['errors'])) {
            $data['warehouse'] = (object) $this->session->getFlash('post_data');
        }
        
        $data['app_profile'] = $this->app_profile;
        return $this->renderer->render($response, 'logistic/warehouse-form', $data);   
    }

    public function save(Request $request, Response $response, Array $args)
    {
        $postData = $request->getParsedBody();
        // validation
        $this->validation->validate([
            'nama|Nama Gudang' => [$postData['nama'], 'required'],
            'department_id|Departemen' => [$postData['department_id'], 'required'],
        ]);
        if (!$this->validation->passes()) {

            $this->session->setFlash('error_messages', $this->validation->errors()->all());
            $this->session->setFlash('post_data', $postData);

            if ($postData['id'] == '') {
                return $response->withRedirect($this->router->pathFor('logistic-warehouse-add'));
            } else {
                return $response->withRedirect($this->router->pathFor('logistic-warehouse-edit'));
            }
        }
        
        if($postData['id'] != ""){
            $warehouse = Gudang::find($postData['id']);
            $warehouse->updated_at = date("Y-m-d H:i:s");
        } else {
            $warehouse = new Gudang();
        }
        
        $warehouse->nama = $postData['nama'];
        $warehouse->department_id = $postData['department_id'];
        $warehouse->users_id = $this->session->get('activeUser')["id"];
        $warehouse->save();
        
        $this->session->setFlash('success', 'Data telah tersimpan');
        return $response->withRedirect($this->router->pathFor('logistic-warehouse'));
    }

    public function delete(Request $request, Response $response, Array $args)
    {
        if(@$args["id"] != ""){
            $warehouse = Gudang::find($args["id"]);
        }
        if($warehouse != null){
            $warehouse->delete();
        }

        $this->session->setFlash('success', 'Data telah terhapus');
        return $response->withRedirect($this->router->pathFor('logistic-warehouse'));
    }
}