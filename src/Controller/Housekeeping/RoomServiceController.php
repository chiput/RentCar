<?php

namespace App\Controller\Housekeeping;

use Slim\Http\Request;
use Slim\Http\Response;
use App\Controller\Controller;
use App\Model\Hotservice;
use App\Model\Hotservicedetail2;
use App\Model\Hotservicebarang;
use App\Model\Room;
use App\Model\Barang;
use App\Model\Building;
use Kulkul\CodeGenerator\RoomserviceCode;

class RoomServiceController extends Controller{
    public function __invoke(Request $request, Response $response, Array $args)
    {
      function convert_date($date){
                    $exp = explode('-', $date);
                    if (count($exp)==3) {
                        $date = $exp[2].'-'.$exp[1].'-'.$exp[0];
                    }
                    return $date;
                }
     $postData = $request->getParsedBody();
        $start = $postData['start'];
        $end = $postData['end'];

         

     if($postData==""){
       $data = [
          "app_profile" => $this->app_profile,
          "menus"=>Hotservice::all()
       ];
     }else{
       $data = [
          "app_profile" => $this->app_profile,
          "menus"=>Hotservice::whereBetween('tanggal', [convert_date($start),convert_date($end)])->get()
       ];
     }

     if($request->isPost()){        
          $start=convert_date($postData["start"]);
          $end=convert_date($postData["end"]);
      }else{
          $start=date("Y-m-d");
          $end=date("Y-m-d");
      }

      $data['start'] = $start;
      $data['end'] = $end;
      
      $data['menus'] = Hotservice::orderBy('id','desc')->get();
      $data['app_profile'] = $this->app_profile;
      return $this->renderer->render($response, "/housekeeping/roomservice", $data);
    }
    public function form(Request $request, Response $response, Array $args)
    {
        if(@args["id"]!=""){
          $menu = Hotservice::find($args['id']);
        }else{
          $menu = (object)[];
        }
        $menu1 = (object) $this->session->getFlash('post_data1');
        $data = [
            "app_profile" => $this->app_profile,
            "menus" => $menu,
            "room" => Room::all(),
            "barang" => Barang::all(),
            "gedung" => Building::all()
        ];
        $data['errors'] = $this->session->getFlash('error_messages');
        if (!isset($args["id"])) $data['newCode'] = RoomserviceCode::generate();
        $this->renderer->render($response, "/housekeeping/roomservice-form", $data);
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
      $this->validation->addRuleMessage('required1', ' - Kolom {field} Belum Terisi pada bagian Kamar.');
      $this->validation->addRule('required1', function($value, $input, $args) {
          return $value != '';
      });
      $this->validation->validate([
          'Karyawan' => [$post['karyawanid'], 'required'],
          'Kamar' => [$post['kamar_id'], 'required1']
      ]);
      if (!$this->validation->passes()) {
          $this->session->setFlash('error_messages', $this->validation->errors()->all());

          if ($post['id'] == '') {
              return $response->withRedirect($this->router->pathFor('houskeeping-roomservice-form'));
          } else {
              return $response->withRedirect($this->router->pathFor('houskeeping-roomservice-edit', ['id' => $post['id']]));
          }
      }
        if($post['id'] != ""){
            $menu = Hotservice::find($post['id']);
            $menu->users_id_edit = $this->session->get('activeUser')["id"];
            $service = Hotservicedetail2::where("id2","=",$post['id'])->delete();
        } else {
            $menu = new Hotservice();
            $menu->users_id = $this->session->get('activeUser')["id"];
        }
        $menu->tanggal = convert_date($post['tanggal']);
        $menu->nobukti = $post['nobukti'];
        $menu->keterangan = $post['keterangan'];
        $menu->karyawanid = $post['karyawanid'];
        $menu->save();

        $id2 = $menu->id;
        foreach($post['kamar_id'] as $key => $kamarid){
            $service = new Hotservicedetail2();
            $service->id2 = $id2;
            $service->kamarid = $kamarid;
            $service->save();
        }
        $this->session->setFlash('success', 'Data telah tersimpan');
        return $response->withRedirect($this->router->pathFor('houskeeping-roomservice'));
    }
    public function delete(Request $request, Response $response, Array $args)
    {
        if(@$args["id"] != ""){
            $menu = Hotservice::find($args["id"]);
        }
        if($menu != null){
            $menu->delete();
            $service = Hotservicedetail2::where("id2","=",$args['id'])->delete();
        }
        return $response->withRedirect($this->router->pathFor('houskeeping-roomservice'));
    }
}
