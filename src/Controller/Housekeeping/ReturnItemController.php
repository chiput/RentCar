<?php

namespace App\Controller\Housekeeping;

use Slim\Http\Request;
use Slim\Http\Response;
use App\Controller\Controller;
use App\Model\Hotpinjam;
use Kulkul\CodeGenerator\HousekeepingpinjamCode;

class ReturnItemController extends Controller{
    public function __invoke(Request $request, Response $response, Array $args){
        $data['menus'] = Hotpinjam::orderBy('id','desc')->get();
        $this->renderer->render($response, "/housekeeping/barangkembali", $data);
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
            "hotpinjam" => Hotpinjam::all(),
            "lama" => $menu1
        ];
        $data['errors'] = $this->session->getFlash('error_messages');
        if (!isset($args["id"])) $data['newCode'] = HousekeepingpinjamCode::generate();
        $this->renderer->render($response, "/housekeeping/barangkembali-form", $data);
    }

    public function save(Request $request, Response $response, Array $args){
        $post = $request->getParsedBody();
        
        $this->session->setFlash('post_data1', $post);
        function convert_date($date){
                    $exp = explode('-', $date);
                    if (count($exp)==3) {
                        $date = $exp[2].'-'.$exp[1].'-'.$exp[0];
                    }
                    return $date;
                }

        // validation
        $this->validation->addRuleMessage('required1', '- Barang Yang dikembalikan Belum Dipilih -');
        $this->validation->addRuleMessage('required', 'Kolom {field} Belum Terisi.');
        $this->validation->addRule('required1', function($value, $input, $args) {
            return $value != '';
        });
        $this->validation->validate([
            'ID' => [$post['id'], 'required1'],
            'No Bukti' => [$post['nobukti'], 'required'],
            'Barang' => [$post['namabarang'], 'required'],
            'Kamar' => [$post['kamar'], 'required'],
            'Pinjam' => [$post['pinjam'], 'required'],
            'Kuantitas' => [$post['kuantitas'], 'required']
        ]);
        if (!$this->validation->passes()) {
            $this->session->setFlash('error_messages', $this->validation->errors()->all());
            if ($post['id'] == '') {
                return $response->withRedirect($this->router->pathFor('housekeeping-barangkembali-add'));
            } else {
                return $response->withRedirect($this->router->pathFor('housekeeping-barangkembali-edit', ['id' => $post['id']]));
            }
        }
        $menu = Hotpinjam::find($post["id"]);
        $menu->users_id_edit = $this->session->get('activeUser')["id"];
        $menu->tanggalkembali = convert_date($post["tanggal"]);
        $menu->kuantitaskembali = $post["kuantitas"];
        $menu->aktif = (!isset($post['aktif']) ? 0 : 1);
        $menu->save();
        return $response->withRedirect($this->router->pathFor('housekeeping-barangkembali'));
    }
    public function delete(Request $request, Response $response, Array $args)
    {
        $guest = Hotpinjam::find($args['id']);
        $guest->tanggalkembali = 0;
        $guest->save();
        $this->session->setFlash('success', 'Data telah terhapus');
        return $response->withRedirect($this->router->pathFor('housekeeping-barangkembali'));
    }
}
