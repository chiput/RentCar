<?php

namespace App\Controller\Logistic;

use Slim\Http\Request;
use Slim\Http\Response;
use App\Controller\Controller;
use App\Model\Brgkategori;

class BrgkategoriController extends Controller 
{
    public function __invoke(Request $request, Response $response, Array $args)
    {
        $data['categories'] = Brgkategori::orderBy('id','desc')->get();
        return $this->renderer->render($response, 'logistic/category', $data);   
    }

    public function form(Request $request, Response $response, Array $args)
    {
        if(@$args["id"] != ""){
            $data['category'] = Brgkategori::find($args["id"]);
        }

        $data['errors'] = $this->session->getFlash('error_messages');
        if (!is_null($data['errors'])) {
            $data['category'] = (object) $this->session->getFlash('post_data');
        }
        
        $data['app_profile'] = $this->app_profile;
        return $this->renderer->render($response, 'logistic/category-form', $data);   
    }

    public function save(Request $request, Response $response, Array $args)
    {
        $postData = $request->getParsedBody();
        // validation
        $this->validation->validate([
            'nama|Nama Kategori' => [$postData['nama'], 'required'],
        ]);
        if (!$this->validation->passes()) {

            $this->session->setFlash('error_messages', $this->validation->errors()->all());
            $this->session->setFlash('post_data', $postData);

            if ($postData['id'] == '') {
                return $response->withRedirect($this->router->pathFor('logistic-category-add'));
            } else {
                return $response->withRedirect($this->router->pathFor('logistic-category-edit'));
            }
        }
        
        if($postData['id'] != ""){
            $category = Brgkategori::find($postData['id']);
        } else {
            $category = new Brgkategori();
        }
        
        $category->nama = $postData['nama'];
        $category->users_id = $this->session->get('activeUser')["id"];
        $category->save();
        
        $this->session->setFlash('success', 'Data telah tersimpan');
        return $response->withRedirect($this->router->pathFor('logistic-category'));
    }

    public function delete(Request $request, Response $response, Array $args)
    {
        if(@$args["id"] != ""){
            $category = Brgkategori::find($args["id"]);
        }
        if($category != null){
            $category->delete();
        }

        $this->session->setFlash('success', 'Data telah terhapus');
        return $response->withRedirect($this->router->pathFor('logistic-category'));
    }
}