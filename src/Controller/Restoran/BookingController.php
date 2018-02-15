<?php

namespace App\Controller\Restoran;

use Slim\Http\Request;
use Slim\Http\Response;
use App\Controller\Controller;
use App\Model\Resbooking;
use App\Model\Resmeja;
use App\Model\Respelanggan;
use App\Model\Reservationdetail;
use App\Model\Option;
use Illuminate\Database\Capsule\Manager as DB;
use Kulkul\Options;

class BookingController extends Controller
{
    public function __invoke(Request $request, Response $response, Array $args)
    {
        $postData = $request->getParsedBody();
        $data['app_profile'] = $this->app_profile;
        $data['reservasi'] = Resbooking::where('status','1')->orderBy("created_at",'DESC')->get();
                $data['checkin'] = Resbooking::where('status','2')->orderBy("created_at",'DESC')->get();
        $data['batal'] = Resbooking::where('status','3')->orderBy("created_at",'DESC')->get();

        $data['Rooms'] = Reservationdetail::where("checkin_at","!=", null)
                                            ->where("checkout_at","=",null)
                                            ->get();

        $data['message'] = $this->session->getFlash('success');
        return $this->renderer->render($response, 'restoran/booking', $data);
    }

    public function GenericNoBukti($NoBukti){
        $repalgs= $this->db->table('resbooking')->get();
        if ($NoBukti<10){
            $NoBuktitext="001".$NoBukti++;
        }else if ($NoBukti<100){
            $NoBuktitext="01".$NoBukti++;
        }else if ($NoBukti<1000){
            $NoBuktitext="1".$NoBukti++;
        }
        else if ($NoBukti<10000){
            $NoBuktitext=$NoBukti++;
        }
        $status=true;
         foreach ($repalgs as $resbooking ) {
            if(strtolower($resbooking->nobukti)==strtolower("RES.".date('y').date('m').$NoBuktitext)){
                //$NoBukti++;
                $status=false;
            }
        }
        if(!$status){
           return $this->GenericNoBukti($NoBukti);
        }
        else{
            return "RES.".date('y').date('m').$NoBuktitext ;
        }
    }

    public function form(Request $request, Response $response, Array $args)
    {
        

        $data = [];
        $data['errors'] = $this->session->getFlash('error_messages');
        $data['app_profile'] = $this->app_profile;

        $data['mejas'] = Resmeja::all();
        $meja= $postData["mejas"]; //for selected to checkbox
        $data["z"]=$meja;
        $data['pelanggans'] = Respelanggan::all();
        $data['Rooms'] = Reservationdetail::where("checkin_at","!=", null)
                                            ->where("checkout_at","=",null)
                                            ->get();

        if (isset($args["id"])) $data['resbooking'] = Resbooking::find($args["id"]);

        if(@$args["id"] != ""){
            $data['resbooking'] = Resbooking::find($args["id"]);
            $data['resbooking']->tanggal = $this->convert_date($data['resbooking']->tanggal);
        } else {

            if($request->isPost()){        
                $date=$postData["date"];
            }else{
                $date=date("Y-m-d");
            }

            $data["date"]=$date;

            $data['NoBukti'] =$this->GenericNoBukti(count($this->db->table('resbooking')->get()));

        }

        return $this->renderer->render($response, 'restoran/booking-form', $data);
    }

    public function save(Request $request, Response $response, Array $args)
    {
        $postData = $request->getParsedBody();

        function convert_date($date){
            $exp = explode('-', $date);
            if (count($exp)==3) {
                $date = $exp[2].'-'.$exp[1].'-'.$exp[0];
            }
            return $date;
        }

        $this->validation->validate([
            'tanggal_checkin|Tanggal Checkin' => [$postData['tanggal_checkin'], 'required'],
            'meja_id|Meja' => [$postData['meja_id'], 'required'],
            'status|Status' => [$postData['status'], 'required'],
        ]);

        if (!$this->validation->passes()) {

            $this->session->setFlash('error_messages', $this->validation->errors()->all());
            $this->session->setFlash('post_data', $postData);

            if ($postData['id'] == '') {
                return $response->withRedirect($this->router->pathFor('booking-new'));
            } else {
                return $response->withRedirect($this->router->pathFor('booking-edit'));
            }
        }


        // insert
        if ($postData['id'] == '') {
            $this->session->setFlash('success', 'Reservasi ditambahkan');
            $resbooking = new Resbooking();
            $resbooking->users_id = $this->session->get('activeUser')["id"];
        } else {
        // update
            $this->session->setFlash('success', 'Reservasi diperbaharui');
            $resbooking = Resbooking::find($postData['id']);
            $resbooking->users_id_edit = $this->session->get('activeUser')["id"];
        }

            $resbooking->tanggal = convert_date($postData['tanggal']);
            $resbooking->nobukti = $postData['nobukti'];
            $resbooking->checkin = convert_date($postData['tanggal_checkin']);
            $resbooking->jam = $postData['jam'];
            $resbooking->pax = $postData['pax'];
            $resbooking->meja_id = $postData['meja_id'];
            $resbooking->pax = $postData['pax'];
            $resbooking->pelanggan_id = $postData['pelanggan_id'];
            $resbooking->rooms_id = $postData['guest_id'];
            // $resbooking->telepon = $postData['telepon'];
            $resbooking->status = $postData['status'];
            // $resbooking->keterangan = $postData['keterangan'];
            // $resbooking->canceldate = $postData["canceldate"];
            $resbooking->save();
            
            $resbooking_id=$resbooking->id;

            $this->session->setFlash('success', 'Reservasi telah tersimpan');
            if ($postData['id'] != '') {
                
            return $response->withRedirect($this->router->pathFor('booking',['id'=>$postData['id']]));
            }

        return $response->withRedirect($this->router->pathFor('booking'));

    }

    public function posted(Request $request, Response $response, Array $args)
    {
        $postData = $request->getParsedBody();
        $jurnal=Resbooking::find($postData["id"]);
        $jurnal->status=$postData["posted"];
        $jurnal->save();
        return $response;
    }
     private function convert_date($date){
            $exp = explode('-', $date);
            if (count($exp)==3) {
                $date = $exp[2].'-'.$exp[1].'-'.$exp[0];
            }
            return $date;
        }

    public function delete(Request $request, Response $response, Array $args)
    {
        if(@$args["id"] != ""){
            $resbooking = Resbooking::find($args["id"]);
            $resbooking->delete();
        }

        $this->session->setFlash('success', 'Reservasi telah dihapus');
        return $response->withRedirect($this->router->pathFor('booking'));
    }

    public function buktireservasi(Request $request, Response $response, Array $args)
    {
        $data['resbooking']=Resbooking::find($args["id"]);

        $resbooking=Resbooking::find($args["id"]);
        $data['mejas'] = Resmeja::all();
        // $meja= $postData["mejas"]; //for selected to checkbox
        // $data["z"]=$meja;
        $data['pelanggans'] = Respelanggan::all();
        $data['Rooms'] = Reservationdetail::where("checkin_at","!=", null)
                                            ->where("checkout_at","=",null)
                                            ->get();

        ///// get option ///
        $opt = Option::all();
        $Options=[];
        foreach ($opt as $value) {
            $Options[$value->name] = $value->value;
        }
        $data['options'] = $Options;
        ///// end get option ///
        
        return $this->renderer->render($response, 'restoran/reports/cetak-booking', $data);
    }

}
