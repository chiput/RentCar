<?php

namespace App\Controller\Housekeeping;

use Slim\Http\Request;
use Slim\Http\Response;
use App\Controller\Controller;
use App\Model\Hotjenispinjam;
use App\Model\Account;
use App\Model\Barang;

class BorrowTypeController extends Controller{
    public function __invoke(Request $request, Response $response, Array $args){
     $data = [
        "app_profile" => $this->app_profile,
        "menus"=>Hotjenispinjam::all()];
        $this->renderer->render($response, "/housekeeping/jenis-pinjam-barang", $data);
    }
    public function form(Request $request, Response $response, Array $args)
    {
        if(@args["id"]!=""){
          $menu = Hotjenispinjam::find($args['id']);
        }else{
          $menu = (object)[];
        }
        $menu1 = (object) $this->session->getFlash('post_data1');
        $data = [
            "app_profile" => $this->app_profile,
            "menus" => $menu,
            "barang" => Barang::all(),
            "akun" => Account::all(),
            "lama" => $menu1
        ];
        $data['errors'] = $this->session->getFlash('error_messages');
        $this->renderer->render($response, "/housekeeping/jenis-pinjam-barang-form", $data);
    }
    public function save(Request $request, Response $response, Array $args){
      $post = $request->getParsedBody();
      $this->session->setFlash('post_data1', $post);
      // validation
      $this->validation->addRuleMessage('required', ' - Kolom {field} Belum Terisi.');
      $this->validation->validate([
          'Barang' => [$post['namabarangid'], 'required'],
          'Harga' => [$post['harga'], 'required'],
          'Kuantitas' => [$post['kuantitas'], 'required'],
          'Harga Sewa' => [$post['sewa'], 'required']
      ]);
      if (!$this->validation->passes()) {
          $this->session->setFlash('error_messages', $this->validation->errors()->all());

          if ($post['id'] == '') {
              return $response->withRedirect($this->router->pathFor('houskeeping-jenis-pinjambarang-form'));
          } else {
              return $response->withRedirect($this->router->pathFor('houskeeping-jenis-pinjambarang-edit', ['id' => $post['id']]));
          }
      }
        if($post["id"]==""){
          //apabila id kosong akan membuat record baru
          $menu = new Hotjenispinjam();
        }else{
          //akan mencari record dan melakukan update terhadap record
          $menu = Hotjenispinjam::find($post["id"]);
        }
        $menu->barangid = $post["namabarangid"];
        $menu->kuantitas = $post["kuantitas"];
        $menu->sewa = $post["sewa"];
        $menu->aktif = (!isset($post['status']) ? 0 : 1);
        $menu->user = $post["user"];
        $menu->save();
        $this->session->setFlash('success', 'Data telah tersimpan');
        return $response->withRedirect($this->router->pathFor('houskeeping-jenis-pinjambarang'));
    }
    public function delete(Request $request, Response $response, Array $args)
    {
        $menu = Hotjenispinjam::find($args['id']);
        $menu->delete();
        $this->session->setFlash('success', 'Data telah terhapus');
        return $response->withRedirect($this->router->pathFor('houskeeping-jenis-pinjambarang'));
    }
}
