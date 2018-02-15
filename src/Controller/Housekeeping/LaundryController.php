<?php

namespace App\Controller\Housekeeping;

use Slim\Http\Request;
use Slim\Http\Response;
use App\Controller\Controller;
use App\Model\Laundry;
use App\Model\Laundrydetail;
use App\Model\Launtarif;
use App\Model\Laundrykasir;
use App\Model\Reservationdetail;
use App\Model\Supplier;
use App\Model\Option;
use Kulkul\CodeGenerator\LaundryCode;

class LaundryController extends Controller{
  public function __invoke(Request $request, Response $response, Array $args){
    $data = [
      "app_profile" => $this->app_profile,
      "menus" => Laundry::all()
      ];
      $this->renderer->render($response, "/housekeeping/laundry", $data);
  }
  public function form(Request $request, Response $response, Array $args)
  {
      if(@args["id"]!=""){
        $menu = Laundry::find($args['id']);
      }else{
        $menu = (object)[];
      }
      $menu1 = (object) $this->session->getFlash('post_data1');
      $data = [
          "app_profile" => $this->app_profile,
          "menus" => $menu,
          "tarif" => Launtarif::all(),
          "kamar" => Reservationdetail::all(),
          "supplier" => Supplier::all()
      ];
      if (!isset($args["id"])) $data['newCode'] = LaundryCode::generate();
      $data['errors'] = $this->session->getFlash('error_messages');
      $this->renderer->render($response, "/housekeeping/laundry-form", $data);
  }
  public function save(Request $request, Response $response, Array $args){
    $post = $request->getParsedBody();
    $this->session->setFlash('post_data1', $post);
    // validation
    $this->validation->addRuleMessage('required', ' - Kolom {field} Belum Terisi.');
    $this->validation->validate([
        'Kamar' => [$post['kamar'], 'required'],
        'Supplier' => [$post['supplier'], 'required'],
        'Kode' => [$post['kode'], 'required'],
        'Nama' => [$post['nama'], 'required'],
        'Layanan' => [$post['layanan'], 'required'],
        'Kuantitas' => [$post['kuantitas'], 'required'],
        'Harga' => [$post['harga'], 'required'],
        'Diskon' => [$post['diskon'], 'required'],
        'Jumlah' => [$post['jumlah'], 'required'],
        'Total Kuantitas' => [$post['totalkuantitas'], 'required'],
        'Total' => [$post['total'], 'required']
    ]);
    if (!$this->validation->passes()) {
        $this->session->setFlash('error_messages', $this->validation->errors()->all());

        if ($post['id'] == '') {
            return $response->withRedirect($this->router->pathFor('housekeeping-laundry-add'));
        } else {
            return $response->withRedirect($this->router->pathFor('housekeeping-laundry-edit', ['id' => $post['id']]));
        }
    }
      if($post['id'] != ""){
          $menu = Laundry::find($post['id']);
          $service = Laundrykasir::where("id","=",$post['id'])->delete();
          $service = Laundrydetail::where("id2","=",$post['id'])->delete();
      }else{
          $menu = new Laundry();
      }
      $menu->tanggal = $post['tanggal'];
      $menu->nobukti = $post['nobukti'];
      $menu->proses = $post['proses'];
      $menu->checkinid = $post['checkinid'];
      $menu->supplierid = $post['supplierid'];
      $menu->keterangan = $post['keterangan'];
      $menu->save();

      $id2 = $menu->id;
      foreach($post['kode'] as $key => $kode){
          $service = new Laundrydetail();
          $service->id2 = $id2;
          $service->tarifid = $post['tarifid'][$key];
          $service->keterangan = $post['keterangandetail'][$key];
          $service->kuantitas = $post['kuantitas'][$key];
          $service->harga = $post['harga'][$key];
          $service->diskon = $post['diskon'][$key];
          $service->save();
      }
      $this->session->setFlash('success', 'Data telah tersimpan');
      return $response->withRedirect($this->router->pathFor('housekeeping-laundry'));
  }
  public function delete(Request $request, Response $response, Array $args)
  {
    if(@$args["id"] != ""){
        $menu = Laundry::find($args["id"]);
    }
    $menu->delete();
    $kasir = Laundrykasir::where("id","=",$args['id'])->delete();
    $service = Laundrydetail::where("id2","=",$args['id'])->delete();
    $this->session->setFlash('success', 'Data telah terhapus');
    return $response->withRedirect($this->router->pathFor('housekeeping-laundry'));
  }
  public function kasir(Request $request, Response $response, Array $args){
    if(@args["id"]!=""){
      $menu = Laundry::find($args['id']);
    }else{
      $menu = (object)[];
    }
    $data = [
        "app_profile" => $this->app_profile,
        "menus" => $menu,
        "kamar" => Reservationdetail::all()
    ];
    $data['errors'] = $this->session->getFlash('error_messages');
    $this->renderer->render($response, "/housekeeping/laundry-kasir", $data);
  }
  public function kasirsave(Request $request, Response $response, Array $args){
    $post = $request->getParsedBody();
    $this->validation->addRuleMessage('required2', ' - Kolom {field} Pada Kasir Melebihi 100%.');
    $this->validation->addRuleMessage('required3', ' - Kembalian Tidak Boleh Kurang dari 0.');
    $this->validation->addRule('required2', function($value, $input, $args) {
        return $value < 101;
    });
    $this->validation->addRule('required3', function($value, $input, $args) {
        return $value >= 0;
    });
    $this->validation->addRuleMessage('required', ' - Kolom {field} Belum Terisi.');
    $this->validation->validate([
        'Diskon' => [$post['diskonpersen'], 'required2'],
        'Service' => [$post['service'], 'required2'],
        'Bayar' => [$post['bayar'], 'required'],
        'Kembalian' => [$post['kembalian'], 'required3']
    ]);
    if (!$this->validation->passes()) {
        $this->session->setFlash('error_messages', $this->validation->errors()->all());
        return $response->withRedirect($this->router->pathFor('housekeeping-laundry-kasir', ['id' => $post['id']]));
    }
    $kasir = Laundrykasir::find($post["id"]);
    $menu = Laundry::find($post['id']);
    if($kasir != ""){
      $kasir = Laundrykasir::find($post["id"]);
    }else{
      $kasir = new Laundrykasir();
    }
    $kasir->id = $post['id'];
    $kasir->tanggal = $post['tanggalkasir'];
    $kasir->nobukti = $post['nobukti'];
    $kasir->checkinid = $post['checkinid'];
    $kasir->diskon = $post['diskonpersen'];
    $kasir->service = $post['service'];
    $kasir->bayar = $post['bayar'];
    $kasir->kembalian = $post['kembalian'];
    $menu->keterangan = $post['keterangankasir'];
    $kasir->save();
    $menu->save();
    $this->session->setFlash('success', 'Data telah tersimpan');
    return $response->withRedirect($this->router->pathFor('housekeeping-laundry'));
  }
  public function cetak(Request $request, Response $response, Array $args)
  {
      if(@args["id"]!=""){
        $menu = Laundry::find($args['id']);
      }else{
        $menu = (object)[];
      }
      $data = [
          "app_profile" => $this->app_profile,
          "menus" => $menu,
          "tarif" => Launtarif::all(),
          "kamar" => Reservationdetail::all(),
          "supplier" => Supplier::all()
      ];
      $opt = Option::all();
      $Options=[];
      foreach ($opt as $value) {
        $Options[$value->name] = $value->value;
      }
      $data['options'] = $Options;
      $this->renderer->render($response, "/housekeeping/laundry-cetak", $data);
  }
}
