<?php

namespace App\Controller\Inventory;

use Slim\Http\Request;
use Slim\Http\Response;
use App\Controller\Controller;
use App\Model\Menu;

class MenuController extends Controller
{
    public function __invoke(Request $request, Response $response, Array $args)
    {
        //$data=["menu_kategoris"=>Menu_kategori::all()];
        $data['app_profile'] = $this->app_profile;
        $data['Menus'] = Menu::all(); //array('Pizzar','Kue','Aa');
        $data['test'] = "Keren";
       // $data[''] = "Keren";
       // $data=['Menus'=>['Pizzar','Kue','Aa'],'test'=>'Keren','app_profile'=> $this->app_profile] ;


         
      //return $this->renderer->render($response, 'restoran/menu_kategori', $data);
       return $this->renderer->render($response, 'test', $data);

        //return $response->write("YOka");
        //echo "teaaast";
    }

     public function panggilmenu(Request $request, Response $response, Array $args)
    {
        
        echo "Hello ".$args['nama'];
    }
    public function form(Request $request, Response $response, Array $args)
    {   

        if (isset($args['id'])) $data['menu'] = Menu::find($args['id']);

        $data['app_profile'] = $this->app_profile;

        return $this->renderer->render($response, 'test-form', $data);
    }

    public function save(Request $request, Response $response, Array $args){
        $postData = $request->getParsedBody();
        //var_dump($postData);
        // validation
        $this->validation->validate([
            'name|Name Kategori' => [$postData['name'], 'required'],
            'price|Price' => [$postData['price'], 'required'],
        ]);
        if (!$this->validation->passes()) {

            $this->session->setFlash('error_messages', $this->validation->errors()->all());
            $this->session->setFlash('post_data', $postData);

            if ($postData['id'] == '') {
                return $response->withRedirect($this->router->pathFor('inventory-new'));
            } else {
                return $response->withRedirect($this->router->pathFor('frontdesk-agent-update'));
            }
        }

        // insert
        if ($postData['id'] == '') {
            $this->session->setFlash('success', 'Data Inventori ditambahkan');
            $menu = new Menu();
        } else {
        // update
            $this->session->setFlash('success', 'Data Inventori diperbarui');
            $menu = Menu::find($postData['id']);
        }
        $menu->name = $postData['name'];
        $menu->price = $postData['price'];
       // $menu->updated_at = '';
        //$menu->status = (@$postData['is_active']==""?0:1);
        
        //$agent->users_id=$this->session->get('activeUser')["id"];
        $menu->save();

        return $response->withRedirect($this->router->pathFor('inventory-menu'));
    }
    
    public function delete(Request $request, Response $response, Array $args)
    {
        $agent = Menu::find($args['id']);
        $agent->delete();
        $this->session->setFlash('success', 'Data Inventori telah dihapus');
        return $response->withRedirect($this->router->pathFor('inventory-menu'));
    }



}
