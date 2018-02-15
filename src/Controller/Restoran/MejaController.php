<?php

namespace App\Controller\Restoran;

use Slim\Http\Request;
use Slim\Http\Response;
use App\Controller\Controller;
use App\Model\Resmeja;
use App\Model\Option;
use App\Model\Reskasirku;
use Illuminate\Database\Capsule\Manager as Capsule;

class MejaController extends Controller
{
    public function __invoke(Request $request, Response $response, Array $args)
    {
        $data['app_profile'] = $this->app_profile;
        $data['mejas'] =Resmeja::all()->sortByDesc("created_at");

        return $this->renderer->render($response, 'restoran/meja', $data);
    }


    public function form(Request $request, Response $response, Array $args)
    {
        if (isset($args['id'])) $data['meja'] = Resmeja::find($args['id']);
        $data['app_profile'] = $this->app_profile;

        $data['errors'] = $this->session->getFlash('error_messages');
        if (!is_null($data['errors'])) {
            $data['meja'] = (object) $this->session->getFlash('post_data');
        }

        return $this->renderer->render($response, 'restoran/meja-form', $data);
    }

    public function save(Request $request, Response $response, Array $args)
    {
        $postData = $request->getParsedBody();

        // validation
        $this->validation->validate([
            'max_tamu|Kapasitas Tamu' => [$postData['max_tamu'], 'required|number'],
            'kode_meja|Kode Meja' => [$postData['kode_meja'], 'required'],

        ]);
        if (!$this->validation->passes()) {

            $this->session->setFlash('error_messages', $this->validation->errors()->all());
            $this->session->setFlash('post_data', $postData);

            if ($postData['id'] == '') {
                return $response->withRedirect($this->router->pathFor('meja-new'));
            } else {
                return $response->withRedirect($this->router->pathFor('meja-edit',['id'=>$postData['id']]));
            }
        }

        // insert
        if ($postData['id'] == '') {
            $vadidasikode=$this->CekKode($postData['kode_meja']);
            if($vadidasikode){
            $this->session->setFlash('success', 'Data Meja ditambahkan');
            $Meja = new Resmeja();
            $Meja->created_at =date('Y-m-d H:i:s');;
            }else{
                $this->session->setFlash('error_messages', array('Data Kode Sudah Ada'));
                return $response->withRedirect($this->router->pathFor('meja-new'));
            }
        } else {
        // update
            $dataKode=Resmeja::whereId($postData['id'])->first();
            $vadidasikode=$this->CekKode($postData['kode_meja']);
            if($vadidasikode || $postData['kode_meja']==$dataKode->kode){
            $this->session->setFlash('success', 'Data Meja diperbarui');
            $Meja = Resmeja::find($postData['id']);
            $Meja->updated_at = date('Y-m-d H:i:s');
            }else{
                $this->session->setFlash('error_messages', array('Data Kode Sudah Ada'));
                return $response->withRedirect($this->router->pathFor('meja-edit',['id'=>$postData['id']]));
            }
        }

        $Meja->kode_meja=$postData['kode_meja'];
        $Meja->max_tamu = $postData['max_tamu'];
        $Meja->tipe_meja = $postData['tipe_meja'];
        $Meja->users_id=$this->session->get('activeUser')["id"];
        $Meja->save();

        return $response->withRedirect($this->router->pathFor('meja'));
    }

    public function delete(Request $request, Response $response, Array $args)
    {
        $Meja = Resmeja::find($args['id']);
        $Meja->delete();
        $this->session->setFlash('success', 'Data Meja telah dihapus');
        return $response->withRedirect($this->router->pathFor('meja'));
    }

   private function CekKode($id){
    $result=true;
    $mejas = $this->db->table('resmeja')
                        ->select('kode_meja')->get();

    foreach ($mejas as $meja) {
        if(strtolower($meja->kode_meja)==strtolower($id)){
            $result=false;
        }
        # code...
    }
    return  $result;
   }


    public function laporanmeja(Request $request, Response $response, Array $args)
    {
        
        if ($request->isPost()) {

            $postData = $request->getParsedBody();
            $data["d_start"]=$postData["start"];
            $data["d_end"]=$postData["end"];

        } else {
            $data["d_start"]=date("d-m-Y");
            $data["d_end"]=date("d-m-Y",strtotime("tomorrow"));
        }

        $data['kinerja'] = Reskasirku::whereBetween('tanggal',array($this->convert_date($data["d_start"]),$this->convert_date($data["d_end"])))
                                        ->select('meja',Capsule::raw('count(id) as kuantitas'),Capsule::raw('sum(total) as total'),Capsule::raw('sum(pax) as pax'))
                                        ->groupby('meja')
                                        ->orderby('total', 'DESC')
                                        ->get();

        return $this->renderer->render($response, 'restoran/reports/meja', $data);
    }

    public function laporanmejaprint(Request $request, Response $response, Array $args)
    {
        ///// get option ///
        $opt = Option::all();

        $Options=[];
        foreach ($opt as $value) {
            $Options[$value->name] = $value->value;
        }
        $data['options'] = $Options;
        ///// end get option ///

        $data['kinerja'] = Reskasirku::whereBetween('tanggal',array($this->convert_date($args["start"]), $this->convert_date($args["end"])))
                                        ->select('meja',Capsule::raw('count(id) as kuantitas'),Capsule::raw('sum(total) as total'),Capsule::raw('sum(pax) as pax'))
                                        ->groupby('meja')
                                        ->orderby('total', 'DESC')
                                        ->get();

        return $this->renderer->render($response, 'restoran/reports/meja-print', $data);
    }

    private function convert_date($date){
        $exp = explode('-', $date);
        if (count($exp)==3) {
            $date = $exp[2].'-'.$exp[1].'-'.$exp[0];
        }
        return $date;
    }
}
