<?php

namespace App\Controller\Housekeeping;

use Slim\Http\Request;
use Slim\Http\Response;
use App\Controller\Controller;
use App\Model\Hotjenispinjam;
use App\Model\Hotpinjam;
use App\Model\Barang;
use App\Model\Reservationdetail;
use Kulkul\CodeGenerator\HousekeepingpinjamCode;

class BorrowController extends Controller{
    public function __invoke(Request $request, Response $response, Array $args){
      $data['menus'] = Hotpinjam::orderBy('id','desc')->get();
      $data['app_profile'] = $this->app_profile;
     //$data = ["app_profile" => $this->app_profile,
        //"menus"=>Hotpinjam::all()];
      return $this->renderer->render($response, "/housekeeping/pinjambarang", $data);
    }
    public function form(Request $request, Response $response, Array $args)
    {
        if(@args["id"]!=""){
          $menu = Hotpinjam::find($args['id']);
        }else{
          $menu = (object)[];
        }
        $menu1 = (object) $this->session->getFlash('post_data1');
        $data = [
            "app_profile" => $this->app_profile,
            "menus" => $menu,
            "pinjam" => Hotjenispinjam::all(),
            "barang" => Barang::all(),
            "reservationdetail" => Reservationdetail::all(),
            "lama" => $menu1
        ];
        $data['errors'] = $this->session->getFlash('error_messages');
        if (!isset($args["id"])) $data['newCode'] = HousekeepingpinjamCode::generate();
        $this->renderer->render($response, "/housekeeping/pinjambarang-form", $data);
    }
    public function save(Request $request, Response $response, Array $args){
                function convert_date($date){
                    $exp = explode('-', $date);
                    if (count($exp)==3) {
                        $date = $exp[2].'-'.$exp[1].'-'.$exp[0];
                    }
                    return $date;
                }
      $post = $request->getParsedBody();
      $this->session->setFlash('post_data1', $post);
      // validation
      $this->validation->addRuleMessage('required', ' - Kolom {field} Belum Terisi.');
      $this->validation->validate([
          'Barang' => [$post['namabarangid'], 'required'],
          'Kamar' => [$post['namakamarid'], 'required'],
          'Kuantitas' => [$post['kuantitas'], 'required']
      ]);
      if (!$this->validation->passes()) {
          $this->session->setFlash('error_messages', $this->validation->errors()->all());

          if ($post['id'] == '') {
              return $response->withRedirect($this->router->pathFor('houskeeping-pinjambarang-form'));
          } else {
              return $response->withRedirect($this->router->pathFor('houskeeping-pinjambarang-edit', ['id' => $post['id']]));
          }
      }
        if($post["id"]==""){
          //apabila id kosong akan membuat record baru
          $menu = new Hotpinjam();
          $menu->users_id = $this->session->get('activeUser')["id"];
        }else{
          //akan mencari record dan melakukan update terhadap record
          $menu = Hotpinjam::find($post["id"]);
          $menu->users_id_edit = $this->session->get('activeUser')["id"];
        }
        $menu->tanggal = convert_date($post["tanggal"]);
        $menu->tanggalkembali = convert_date($post["tanggalkembali"]);
        $menu->nobukti = $post["nobukti"];
        $menu->barangid = $post["namabarangid"];
        $menu->checkinid = $post["namakamarid"];
        $menu->kuantitas = $post["kuantitas"];
        $menu->keterangan = $post["keterangan"];
        //$menu->user = $post["user"];
        $menu->aktif = (!isset($post['aktif']) ? 0 : 1);
        $menu->save();
        $this->session->setFlash('success', 'Data telah tersimpan');
        return $response->withRedirect($this->router->pathFor('houskeeping-pinjambarang'));
    }
    public function delete(Request $request, Response $response, Array $args)
    {
        $menu = Hotpinjam::find($args['id']);
        $menu->delete();
        $this->session->setFlash('success', 'Data telah terhapus');
        return $response->withRedirect($this->router->pathFor('houskeeping-pinjambarang'));
    }
}
