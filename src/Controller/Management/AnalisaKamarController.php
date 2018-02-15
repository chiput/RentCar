<?php

namespace App\Controller\Management;

use Slim\Http\Request;
use Slim\Http\Response;
use App\Controller\Controller;
use App\Model\Reservation;
use App\Model\Reservationdetail;
use Illuminate\Database\Capsule\Manager as DB;

class AnalisaKamarController extends Controller
{
  
    public function __invoke(Request $request, Response $response, Array $args){

        $postData = $request->getParsedBody();

        if($request->isPost()){        
            $start=$postData["start"];
            $end=$postData["end"];
        }else{
            $start=date("d-m-Y");
            $end=date("d-m-Y");
        }

        $data["start"]=$this->convert_date($start);
        $data['end']=$this->convert_date($end);

        $data['datas'] = Reservationdetail::whereBetween("checkin_at",[$this->convert_date($start),$this->convert_date($end)])
                                                ->select(DB::raw('Count(*) as jumlah, reservationdetails.*'))
                                                ->groupBy('rooms_id')
                                                ->get();
        if($postData['sorting'] > 0){
            $data['datas'] =  Reservationdetail::whereBetween("checkin_at",[$this->convert_date($start),$this->convert_date($end)])
                                                ->select(DB::raw('Count(*) as jumlah, reservationdetails.*'))
                                                ->groupBy('rooms_id')
                                                ->orderBy('jumlah','DESC')
                                                ->limit($postData['sorting'])
                                                ->get();
        }
        $data['sorting'] = $postData['sorting'];
        
        return $this->renderer->render($response, 'management/room-favorit', $data);
    }  

    public function reservasi_kamar(Request $request, Response $response, Array $args)
    {
         // $data['app_profile'] = $this->app_profile;
        $data["analisa"] = Reservation::first();
        
        if ($request->isPost()) {

            $postData = $request->getParsedBody();

            $data["d_start"]=$postData["start"];
            $data["d_end"]=$postData["end"];
            $data['status']=$postData['status'];

        } else {
            $data['status']=1;
            $data["d_start"]=date("d-m-Y");
            $data["d_end"]=date("d-m-Y",strtotime("tomorrow"));
            
        }

        return $this->renderer->render($response, 'management/reservasi-room', $data);
    }

    public function checkin(Request $request, Response $response, Array $args)
    {
        // $data['app_profile'] = $this->app_profile;
        $data["analisa"] = Reservation::first();
        
        if ($request->isPost()) {

            $postData = $request->getParsedBody();

            $data["d_start"]=$postData["start"];
            $data["d_end"]=$postData["end"];
            $data['status']=$postData['status'];

        } else {
            $data['status']=1;
            $data["d_start"]=date("d-m-Y");
            $data["d_end"]=date("d-m-Y",strtotime("tomorrow"));
            
        }

        return $this->renderer->render($response, 'management/checkin-room', $data);
    }

    private function convert_date($date){
        $exp = explode('-', $date);
        if (count($exp)==3) {
            $date = $exp[2].'-'.$exp[1].'-'.$exp[0];
        }
        return $date;
    }

}
