<?php

namespace App\Controller\Housekeeping;

use Slim\Http\Request;
use Slim\Http\Response;
use App\Controller\Controller;
use App\Model\Guest;
use App\Model\Hottemuan;
use App\Model\Reservationdetail;
use App\Model\Room;
use Kulkul\CodeGenerator\HousekeepingtemuanCode;

class FindItemController extends Controller{
    public function __invoke(Request $request, Response $response, Array $args)
    {
        $data['menus'] = Hottemuan::orderBy('id','desc')->get();
        $data['app_profile'] = $this->app_profile;
        return $this->renderer->render($response, "/housekeeping/barangtemuan", $data);
    }
    public function form(Request $request, Response $response, Array $args)
    {
        if(@args["id"]!=""){
          $menu = Hottemuan::find($args['id']);
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
        $data["reservationdetails"]=Room::all();
        if (!isset($args["id"])) $data['newCode'] = HousekeepingtemuanCode::generate();
        $this->renderer->render($response, "/housekeeping/barangtemuan-form", $data);
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
            'Barang' => [$post['barangid'], 'required'],
            'Ditemukan Oleh' => [$post['karyawanid'], 'required']
        ]);
        if (!$this->validation->passes()) {
            $this->session->setFlash('error_messages', $this->validation->errors()->all());

            if ($post['id'] == '') {
                return $response->withRedirect($this->router->pathFor('housekeeping-barangtemuan-add'));
            } else {
                return $response->withRedirect($this->router->pathFor('housekeeping-barangtemuan-edit', ['id' => $post['id']]));
            }
        }
        if($post["id"]==""){
          //apabila id kosong akan membuat record baru
          $menu = new Hottemuan();
          $menu->users_id = $this->session->get('activeUser')["id"];
        }else{
          //akan mencari record dan melakukan update terhadap record
            $menu = Hottemuan::find($post["id"]);
            $menu->users_id_edit = $this->session->get('activeUser')["id"];
        }
        $menu->tanggal = convert_date($post["tanggal"]);
        $menu->nobukti = $post["nobukti"];
        $menu->barangid = $post["barangid"];
        $menu->karyawanid = $post["karyawanid"];
        $menu->checkinid = $post["checkinid"];
        $menu->keterangan = $post["keterangan"];
        $menu->aktif = (!isset($post['aktif']) ? 0 : 1);
        //$menu->user = $post["user"];
        $menu->save();
        $this->session->setFlash('success', 'Data telah tersimpan');
        return $response->withRedirect($this->router->pathFor('housekeeping-barangtemuan'));
    }
    public function delete(Request $request, Response $response, Array $args)
    {
        $guest = Hottemuan::find($args['id']);
        $guest->delete();
        $this->session->setFlash('success', 'Data telah terhapus');
        return $response->withRedirect($this->router->pathFor('housekeeping-barangtemuan'));
    }
}
