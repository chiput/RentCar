<?php

namespace App\Controller\Logistic;

use Slim\Http\Request;
use Slim\Http\Response;
use App\Controller\Controller;
use App\Model\Brgsatuan;
use App\Model\Account;
use App\Model\Brgkategori;
use App\Model\Barang;
use Kulkul\CurrencyFormater\FormaterAdapter; 

class BarangController extends Controller 
{
    public function __invoke(Request $request, Response $response, Array $args)
    {
        $data['goods'] = Barang::orderBy('id','desc')->get();
        return $this->renderer->render($response, 'logistic/good', $data);   
    }

    public function form(Request $request, Response $response, Array $args)
    {
        $data['categories'] = Brgkategori::all();
        $data['units'] = Brgsatuan::all();
        $data['accounts'] = Account::all();
        
        if(@$args["id"] != ""){
            $data['good'] = Barang::find($args["id"]);
        }

        $data['errors'] = $this->session->getFlash('error_messages');
        if (!is_null($data['errors'])) {
            $data['good'] = (object) $this->session->getFlash('post_data');
        }
        
        $data['app_profile'] = $this->app_profile;
        return $this->renderer->render($response, 'logistic/good-form', $data);   
    }

    public function save(Request $request, Response $response, Array $args)
    {
        $postData = $request->getParsedBody();
        // validation
        $this->validation->validate([
            'nama|Nama Satuan' => [$postData['nama'], 'required'],
            'hargajual|Harga Jual' => [$postData['hargajual'], 'required'],
            'hargastok|Harga Awal' => [$postData['hargastok'], 'required'],
            'minimal|Minimal Stok' => [$postData['minimal'], 'required'],
        ]);
        if (!$this->validation->passes()) {

            $this->session->setFlash('error_messages', $this->validation->errors()->all());
            $this->session->setFlash('post_data', $postData);

            if ($postData['id'] == '') {
                return $response->withRedirect($this->router->pathFor('logistic-good-add'));
            } else {
                return $response->withRedirect($this->router->pathFor('logistic-good-edit'));
            }
        }

        // validasi nama ber karakter
        if (preg_match('/[^-_@. 0-9A-Za-z]/',$postData['nama'])) { 

            $this->session->setFlash('error_messages', array('Inputan Nama Barang Tidak Valid'));
            $this->session->setFlash('post_data', $postData);
            if($postData['id'] == ""){
                return $response->withRedirect($this->router->pathFor('logistic-good-add'));
            } else {
                return $response->withRedirect($this->router->pathFor('logistic-good-edit',['id' => $postData['id']]));
            }
        }
        
        if($postData['id'] != ""){
            $good = Barang::find($postData['id']);
            $good->updated_at = date("Y-m-d H:i:s");
        } else {
            $good = new Barang();
        }
        
     
        $good->kode = $postData['kode'];
        $good->nama = $postData['nama'];
        $good->brgsatuan_id = @$postData['brgsatuan_id']*1;
        $good->brgkategori_id = @$postData['brgkategori_id']*1;
        $good->account_id = $postData['account_id'];
        $good->accpenjualan = $postData['accpenjualan'];
        $good->acchpp = $postData['acchpp'];
        $good->hargajual = FormaterAdapter::reverse($postData['hargajual']);
        $good->hargastok = FormaterAdapter::reverse($postData['hargastok']);
        $good->minimal = $postData['minimal'];
        $good->expired = @$postData['expired']*1;
        $good->inventaris = @$postData['inventaris']*1;
        $good->users_id = $this->session->get('activeUser')["id"];
        $good->save();
        
        $this->session->setFlash('success', 'Data telah tersimpan');
        return $response->withRedirect($this->router->pathFor('logistic-good'));
    }

    public function delete(Request $request, Response $response, Array $args)
    {
        if(@$args["id"] != ""){
            $unit = Barang::find($args["id"]);
        }
        if($unit != null){
            $unit->delete();
        }

        $this->session->setFlash('success', 'Data telah terhapus');
        return $response->withRedirect($this->router->pathFor('logistic-good'));
    }
}