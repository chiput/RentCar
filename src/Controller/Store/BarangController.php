<?php

namespace App\Controller\Store;

use Slim\Http\Request;
use Slim\Http\Response;
use App\Controller\Controller;

use App\Model\Storebarang;
use App\Model\Department;
use App\Model\Setupgudang;

use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Database\Capsule\Manager as DB;
use Kulkul\CurrencyFormater\FormaterAdapter;
use Harmoni\LogAuditing\LogAuditingProvider;

class BarangController extends Controller
{
    public function __invoke(Request $request, Response $response, Array $args)
    {
        $data['barang'] = Storebarang::all();
        $data['app_profile'] = $this->app_profile;
        return $this->renderer->render($response, 'store/barang', $data);
    }

    public function form(Request $request, Response $response, Array $args)
    {
        $data['errors'] = $this->session->getFlash('error_messages');
        $setgud = Setupgudang::where('name','gud_store')->first();

        $data['barangs'] = Capsule::select("
                select * from 
                (select 
                    C.*,
                    C.id as barangidnya,
                    D.id as gudid,
                    D.nama as namagud,
                    F.nama as satuannama
                from 
                    gudterima A,
                    gudterimadetail B,
                    barang C,
                    gudang D, 
                    departments E,
                    brgsatuan F
                where 
                    A.id=B.gudterima_id 
                    and B.barang_id=C.id 
                    and A.gudang_id=D.id 
                    and F.id=C.brgsatuan_id 
                    and D.id=".$setgud->value."
                group by C.id
                ) x LEFT JOIN storebarang z ON x.id=z.barang_id Where z.barang_id IS NULL");

        if (isset($args['id'])){
            $data['barangnya'] = Storebarang::find($args['id']);
            $data['barangs'] = Capsule::select("
                select * from 
                (select 
                    C.*,
                    C.id as barangidnya,
                    D.id as gudid,
                    D.nama as namagud,
                    F.nama as satuannama
                from 
                    gudterima A,
                    gudterimadetail B,
                    barang C,
                    gudang D, 
                    departments E,
                    brgsatuan F
                where 
                    A.id=B.gudterima_id 
                    and B.barang_id=C.id 
                    and A.gudang_id=D.id 
                    and F.id=C.brgsatuan_id 
                    and D.id=".$setgud->value."
                group by C.id
                ) x");
        }

        return $this->renderer->render($response, 'store/barang-form', $data);
    }

    public function save(Request $request, Response $response, Array $args)
    {
        $postData = $request->getParsedBody();

        if($postData['id'] != ""){
            $this->session->setFlash('post_data', array('Data Barang ditambahkan'));

            $barang = Storebarang::find($postData['id']);
            $barang->updated_at = date("Y-m-d H:i:s");
        } else {

            $this->session->setFlash('post_data', array('Data Barang diperbaharui'));
            $barang = new Storebarang();
        }

        $barang->barang_id = $postData['barang'];
        $barang->harga = FormaterAdapter::reverse($postData['harga']);
        $original = $barang->getOriginal();
        $barang->save();

        $log = LogAuditingProvider::logactivity($barang,$original,'storebarang');

        return $response->withRedirect($this->router->pathFor('store-barang'));
    }

    public function delete(Request $request, Response $response, Array $args)
    {
        $barang = Storebarang::find($args['id']);
        $barang->delete();
        $this->session->setFlash('success', 'Data Barang telah dihapus');
        return $response->withRedirect($this->router->pathFor('store-barang'));
    }

}
