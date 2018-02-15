<?php
namespace Harmoni\GetBarang;

use App\Model\Barang;
use Slim\Http\Request;
use Slim\Http\Response;
use App\Controller\Controller;
use Kulkul\Authentication\Session;
use Illuminate\Database\Capsule\Manager as DB;

class GetBarangProvider 
{

  public function barang($id)
  {
    $result = Barang::leftJoin('gudterimadetail','gudterimadetail.barang_id','=','barang.id')
                ->leftjoin('gudterima','gudterima.id','=','gudterimadetail.gudterima_id')
                ->select('barang.*','gudterima.gudang_id as gud1')
                ->where('gudterima.gudang_id','=',$id)
                ->groupBy('barang.id')
                ->get();

    return $result;
  }

}

?>
