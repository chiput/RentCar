<?php

namespace App\Controller\Pembelian;

use Slim\Http\Request;
use Slim\Http\Response;
use App\Controller\Controller;
use App\Model\Option;
use App\Model\Supplier;
use App\Model\Pembelian;
use App\Model\PembelianDetail;
use App\Model\PembelianRetur;
use App\Model\PembelianReturDetail;
use App\Model\Department;
use App\Model\Gudminta;
use App\Model\Gudmintadetail;
use App\Model\Barang;
use App\Model\Brgsatuan;
use Illuminate\Database\Capsule\Manager as DB;
use Kulkul\Options;

Class ReportController extends Controller
{
	private function getOption(){
      ///// get option ///
      $opt = Option::all();
      $Options=[];
      foreach ($opt as $value) {
          $Options[$value->name] = $value->value;
      }
      return $Options;
      ///// end get option ///
  }

	public function __invoke(Request $request, Response $response, Array $args)
	{

	}

	public function supplier(Request $request, Response $response, Array $args)
	{
		$data['app_profile'] = $this->app_profile;
		$data['options'] = $this->getOption();
		$data['suppliers'] = Supplier::all();

		return $this->renderer->render($response, 'pembelian/reports/supplier-report', $data);
	}

	public function pembelian(Request $request, Response $response, Array $args)
	{
		if($request->isPost()){
	            $post = $request->getParsedBody();
	            $data = $post;
	            $data['pembelians'] = Pembelian::whereBetween('tanggal',[$this->convert_date($post["d_start"]),$this->convert_date($post["d_end"])])->get();
	            $data['options'] = Options::all();
	            return $this->renderer->render($response, 'pembelian/reports/pembelian-report-all', $data);
	    } else {
	        $data['app_profile'] = $this->app_profile;
	        return $this->renderer->render($response, 'pembelian/reports/pembelian-report-form', $data);
	    }
	}

	public function pembeliandetail(Request $request, Response $response, Array $args)
	{
		if($request->isPost()){
            $post = $request->getParsedBody();
            $data = $post;
            $data['pembelians'] = Pembelian::whereBetween('tanggal',[$this->convert_date($post["d_start"]),$this->convert_date($post["d_end"])])->get();
            $data['options'] = Options::all();
            return $this->renderer->render($response, 'pembelian/reports/pembeliandetail-report-all', $data);
	    } else {
	        $data['app_profile'] = $this->app_profile;
	        return $this->renderer->render($response, 'pembelian/reports/pembeliandetail-report-form', $data);
	    }
	}

	public function pembelianretur(Request $request, Response $response, Array $args)
	{
		if($request->isPost()){
	            $post = $request->getParsedBody();
	            $data = $post;
	            $data['returs'] = PembelianRetur::whereBetween('tanggal',[$this->convert_date($post["d_start"]),$this->convert_date($post["d_end"])])->get();
	            $data['options'] = Options::all();
	            return $this->renderer->render($response, 'pembelian/reports/retur-pembelian-all', $data);
	    } else {
	        $data['app_profile'] = $this->app_profile;
	        return $this->renderer->render($response, 'pembelian/reports/retur-pembelian-form', $data);
	    }
	}

	public function printpurchase(Request $request, Response $response, Array $args)
	{
	 	$data['app_profile'] = $this->app_profile;
		$data['options'] = $this->getOption();
		$data['purReq'] = Pembelian::find($args['id']);

		return $this->renderer->render($response, 'pembelian/reports/pembelian-cetak-report', $data);
	}

	public function printretur(Request $request, Response $response, Array $args)
	{
		$data['retur'] = PembelianRetur::find($args["id"]);
        $data['options'] = Options::all();
        
        return $this->renderer->render($response, 'pembelian/reports/retur-pembelian-print', $data);   

	}

    public function convert_date($date){
        $exp = explode('-', $date);
        if (count($exp)==3) {
            $date = $exp[2].'-'.$exp[1].'-'.$exp[0];
        }
        return $date;
    }              
}