<?php

namespace App\Controller\Logistic;

use Slim\Http\Request;
use Slim\Http\Response;
use App\Controller\Controller;
use App\Model\Brgsatuan;
use App\Model\Account;
use App\Model\Brgkategori;
use App\Model\Barang;
use App\Model\Gudang;
use App\Model\Gudpakai; //pemakaian barang
use App\Model\Gudpakaidetail; //pemakaian barang
use App\Model\Gudterima; //penerimaan barang
use App\Model\Gudterimadetail; //penerimaan barang
use App\Model\Gudpindah; //mutasi gudang
use App\Model\Gudpindahdetail; //mutasi gudang
use App\Model\Gudhilang; //barang rusak & hilang
use App\Model\Gudhilangdetail; //barang rusak & hilang
use App\Model\Gudrevisi; //revisi stok
use App\Model\Gudrevisidetail; //revisi stok 
use App\Model\Reskasir; //kasir restoran
use App\Model\Resgudang; //gudang restoran
use Kulkul\LogisticStock\LogisticStockProvider; 
use Kulkul\Options;
use Illuminate\Database\Capsule\Manager as DB;

class StokController extends Controller 
{
    public function stock(Request $request, Response $response, Array $args)
    {
        if($request->isPost()){
            $postData = $request->getParsedBody();
            
            $stock = new LogisticStockProvider();
            
            $data = $stock->getStock(date("Y-m-t",strtotime($postData["year"].'-'.$postData["month"].'-01'))
                                    , $postData['gudang_id'], $postData['kategori_id'], $postData['barang_id'], $postData['stok']);

            $data['month'] = $postData['month'];
            $data['year'] = $postData['year'];

            return $this->renderer->render($response, 'logistic/reports/stock-report', $data);  

        } else {

            $data['app_profile'] = $this->app_profile;
            $data['goods'] = Barang::all();
            $data['categories'] = Brgkategori::all();
            $data['warehouses'] = Gudang::all();
            return $this->renderer->render($response, 'logistic/reports/stock-form', $data);   
        }
         
    }
}