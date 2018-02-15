<?php

namespace App\Controller\Housekeeping;

use Slim\Http\Request;
use Slim\Http\Response;
use App\Controller\Controller;
use App\Model\Launlayanan;

class LaundryserviceController extends Controller{
  public function __invoke(Request $request, Response $response, Array $args){
    $data = [
      "app_profile" => $this->app_profile,
      "menus"=>Launlayanan::all()];
      $this->renderer->render($response, "/housekeeping/laundry-layanan", $data);
  }
  public function form(Request $request, Response $response, Array $args)
  {
      if(@args["id"]!=""){
        $menu = Launlayanan::find($args['id']);
      }else{
        $menu = (object)[];
      }
      $menu1 = (object) $this->session->getFlash('post_data1');
      $data = [
          "app_profile" => $this->app_profile,
          "menus" => $menu,
          "lama" => $menu1
      ];
      $data['errors'] = $this->session->getFlash('error_messages');
      $this->renderer->render($response, "/housekeeping/laundry-layanan-form", $data);
  }
  public function save(Request $request, Response $response, Array $args){
      $post = $request->getParsedBody();
      $this->session->setFlash('post_data1', $post);
      // validation
      $this->validation->addRuleMessage('required', ' - Kolom {field} Belum Terisi.');
      $this->validation->validate([
          'Kode' => [$post['kode'], 'required'],
          'Nama' => [$post['nama'], 'required']
      ]);
      if (!$this->validation->passes()) {
          $this->session->setFlash('error_messages', $this->validation->errors()->all());

          if ($post['id'] == '') {
              return $response->withRedirect($this->router->pathFor('housekeeping-laundry-layanan-add'));
          } else {
              return $response->withRedirect($this->router->pathFor('housekeeping-laundry-layanan-edit', ['id' => $post['id']]));
          }
      }
      if($post["id"]==""){
        //apabila id kosong akan membuat record baru
        $menu = new Launlayanan();
      }else{
        //akan mencari record dan melakukan update terhadap record
        $menu = Launlayanan::find($post["id"]);
      }
      $menu->kode = $post["kode"];
      $menu->nama = $post["nama"];
      $menu->aktif = (!isset($post['aktif']) ? 0 : 1);
      $menu->user = $post["user"];
      $menu->save();
      $this->session->setFlash('success', 'Data telah tersimpan');
      return $response->withRedirect($this->router->pathFor('housekeeping-laundry-layanan'));
  }
  public function delete(Request $request, Response $response, Array $args)
  {
      $menu = Launlayanan::find($args['id']);
      $menu->delete();
      $this->session->setFlash('success', 'Data telah terhapus');
      return $response->withRedirect($this->router->pathFor('housekeeping-laundry-layanan'));
  }
}
