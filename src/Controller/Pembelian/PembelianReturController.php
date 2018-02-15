<?php

namespace App\Controller\Pembelian;

use Slim\Http\Request;
use Slim\Http\Response;
use App\Controller\Controller;
use App\Model\PembelianRetur;
use App\Model\PembelianReturDetail;
use App\Model\Pembelian;
use App\Model\PembelianDetail;
use App\Model\PembelianStatus;
use App\Model\Gudterima;
use App\Model\Gudterimadetail;
use App\Model\Barang;
use App\Model\Brgsatuan;
use App\Model\Account;
use Illuminate\Database\Capsule\Manager as DB;
use Kulkul\Options;
use Kulkul\CurrencyFormater\FormaterAdapter;

class PembelianReturController extends Controller
{
	public function __invoke(Request $request, Response $response, Array $args)
    {
        $postData = $request->getParsedBody();

        $data = [];
        $data['app_profile'] = $this->app_profile;

        if ($request->isPost()) {
            $data["d_start"]=$postData["start"];
            $data["d_end"]=$postData["end"];
        } else {
            $data["d_start"]=date("d-m-Y");
            $data["d_end"]=date("d-m-Y",strtotime("tomorrow"));
        }

        $data['returs'] = PembelianRetur::whereBetween("tanggal",[$this->convert_date($data['d_start']), $this->convert_date($data['d_end'])])->orderBy("created_at","desc")->get();


		// $data['app_profile'] = $this->app_profile;

        $data['purchases'] = PembelianStatus::where("status", "=", 0)->orderBy("id", "desc")->get();

		return $this->renderer->render($response, 'pembelian/retur-pembelian', $data);

	}

	public function form(Request $request, Response $response, Array $args)
	{
		$data['goods'] = Barang::all();
		$data['units'] = Brgsatuan::all();
		$data['accounts'] = Account::all();

        if(@$args["id"] != ""){
            $data['retur'] = PembelianRetur::find(@$args["id"]);
            $data['purchase'] = Pembelian::find($data['retur']->pembelian_id);
        } else {
            $data['purchase'] = Pembelian::find(@$args['pembelian_id']);
            $data['receives'] = Gudterima::where("pembelian_id","=",$data['purchase']->id)->orderBy("nobukti", "desc")->get();
            
            $retur = PembelianRetur::where(DB::raw('left(nobukti,7)'), '=', 'RB.'.date('ym'))
                                ->orderBy("nobukti","desc")->first();
             if(@$args["id"] != ""){
                $data['retur'] = PembelianRetur::find($args["id"]);
            } else {
                
                $retur = PembelianRetur::where(DB::raw('left(nobukti,7)'), '=', 'RB.'.date('ym'))
                                    ->orderBy('nobukti',"desc")->first();
                if($retur == NULL){
                    @$data['retur']->nobukti = 'RB.'.date('ym').substr('0000'.(substr($retur->nobukti,-4)*1+1),-4);
                }else{
                    @$data['retur']->nobukti = substr($retur->nobukti,0,7).substr('0000'.(substr($retur->nobukti,-4)*1+1),-4);
                }
                
            }

            $data['errors'] = $this->session->getFlash('error_messages');
            if (!is_null($data['errors'])) {
                $data['retur'] = (object) $this->session->getFlash('post_data');
            } 
            
        }

        $data["receive_total"] = $this->receive_total($data["purchase"]->id);
        $data["retur_total"] = $this->retur_total($data["purchase"]->id);

		$data['app_profile'] = $this->app_profile;

		return $this->renderer->render($response, 'pembelian/retur-pembelian-form', $data);  
	}

	public function save(Request $request, Response $response, Array $args)
	{
		$postData = $request->getParsedBody();
        
        function convert_date($date){
            $date = date("Y-m-d", strtotime($date));
            return $date;
        }
        
        // validation
        $this->validation->validate([
            'tanggal|Tanggal' => [convert_date($postData['tanggal']), 'required'],
            'nobukti|No. Bukti' => [$postData['nobukti'], 'required'],
            'terima_name|No. Terima' => [$postData['terima_name'], 'required'],
        ]);

        if (!$this->validation->passes()) {

            $this->session->setFlash('error_messages', $this->validation->errors()->all());
            $this->session->setFlash('post_data', $postData);

            if ($postData['id'] == '') {
                return $response->withRedirect($this->router->pathFor('retur-pembelian-add',['pembelian_id'=>$postData['pembelian_id']]));
            } else {
                return $response->withRedirect($this->router->pathFor('retur-pembelian-edit',['id'=>$postData['id']]));
            }
        }

        if($postData['id'] != ""){
            $retur = PembelianRetur::find($postData['id']);
            $retur->users_id_edit = $this->session->get('activeUser')["id"];
            $detail = PembelianReturDetail::where("pembelianretur_id","=",$postData['id'])->delete();
        } else {
            $retur = new PembelianRetur();
            $retur->users_id = $this->session->get('activeUser')["id"];
            $retur->users_id_edit = 0;            
        }

        $retur->tanggal = convert_date($postData['tanggal']);
        $retur->nobukti = $postData['nobukti'];
        $retur->pembelian_id = $postData['pembelian_id'];
        $retur->terima_id = $postData['terima_id'];
        $retur->keterangan = $postData['keterangan'];
        $retur->save();

        $retur_id = $retur->id;
        
        // simpan detail
        foreach($postData['barang_id'] as $key => $barang){
            $detail = new PembelianReturDetail();
            $detail->pembelianretur_id = $retur_id;
            $detail->barang_id = $barang;
            $detail->satuan_id = $postData["satuan_id"][$key];
            $detail->kuantitas = $postData["kuantitas"][$key];
            $detail->harga = FormaterAdapter::reverse($postData["harga"][$key]);
            $detail->save();
        }
        
        $this->session->setFlash('success', 'Data Telah Tersimpan');
        return $response->withRedirect($this->router->pathFor('retur-pembelian'));

	}

	public function delete(Request $request, Response $response, Array $args)
	{
		if(@$args["id"] != ""){
            $retur = PembelianRetur::find($args["id"]);
        }
        if($retur != null){
            $retur->delete();
            $details = PembelianReturDetail::where("pembelianretur_id","=",$args["id"])->delete();
        }

        $this->session->setFlash('success', 'Data Telah Terhapus');
        return $response->withRedirect($this->router->pathFor('retur-pembelian'));

	}

    public function receive_total($pembelian_id)
    {
        $receiveDetails = Gudterimadetail::whereHas('gudterima', function ($query) use($pembelian_id){
                                $query->where('pembelian_id', '=', $pembelian_id);
                            })
                            ->selectRaw('barang_id, sum(kuantitas) as kuantitas')
                            ->groupBy('barang_id')
                            ->get();
        $total=[];
        foreach($receiveDetails as $detail){
            $total[$detail->barang_id] = $detail->kuantitas;
        }
        return $total;

    }

    public function retur_total($pembelian_id)
    {
        $returDetails = PembelianReturDetail::whereHas('pembelianretur', function ($query) use($pembelian_id){
                                $query->where('pembelian_id', '=', $pembelian_id);
                            })
                            ->selectRaw('barang_id, sum(kuantitas) as kuantitas')
                            ->groupBy('barang_id')
                            ->get();
        $total=[];
        foreach($returDetails as $detail){
            $total[$detail->barang_id] = $detail->kuantitas;
        }
        return $total;

    }
        function convert_date($date){
            $exp = explode('-', $date);
            if (count($exp)==3) {
                $date = $exp[2].'-'.$exp[1].'-'.$exp[0];
            }
            return $date;
        }

}

