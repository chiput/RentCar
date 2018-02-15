<?php

namespace App\Controller\Management;

use Slim\Http\Request;
use Slim\Http\Response;
use App\Controller\Controller;
use App\Model\Reservation;
use App\Model\Reservationdetail;
use App\Model\Guest;
use App\Model\Agent;
use Illuminate\Database\Capsule\Manager as DB;

class AktifitasPenjualanController extends Controller
{
    public function __invoke(Request $request, Response $response, Array $args){
                function convert_date($date){
                    $exp = explode('-', $date);
                    if (count($exp)==3) {
                        $date = $exp[2].'-'.$exp[1].'-'.$exp[0];
                    }
                    return $date;
                }
        $postData = $request->getParsedBody();
        $data['agent']=@$postData["agent"];

        if($request->isPost()){        
            $start=$postData["start"];
            $end=$postData["end"];
        }else{
            $start=date("d-m-Y");
            $end=date("d-m-Y");
        }

        $data["start"]=convert_date($start);
        $data['end']=convert_date($end);

        $data["agents"]=Agent::all();

        $data["reservations"] = Reservation::leftJoin(DB::raw('(
                                    SELECT SUM(reservationdetails.price) as prices, SUM(reservationdetails.priceExtra) as priceExtras, reservationdetails.reservations_id as resv, reservationdetails.checkin_code as code
                                    FROM reservationdetails
                                    GROUP BY reservationdetails.reservations_id
                                    ) sio'), function($join)
                                {
                                    $join->on('reservations.id', '=', 'sio.resv');
                                })
                            ->whereNotNull('code')
                            ->where('checkin','<',$data["end"].' 00:00:00')
                            ->where('checkout','>',$data["start"].' 00:00:00')
                            ->where('agent_id','!=','0')
                            ->get();

        if($data['agent'] != ''){
            $data["reservations"] = Reservation::leftJoin(DB::raw('(
                                    SELECT SUM(reservationdetails.price) as prices, SUM(reservationdetails.priceExtra) as priceExtras, reservationdetails.reservations_id as resv, reservationdetails.checkin_code as code
                                    FROM reservationdetails
                                    GROUP BY reservationdetails.reservations_id
                                    ) sio'), function($join)
                                {
                                    $join->on('reservations.id', '=', 'sio.resv');
                                })
                            ->whereNotNull('code')
                            ->where('checkin','<',$data["end"].' 00:00:00')
                            ->where('checkout','>',$data["start"].' 00:00:00')
                            ->where('agent_id','=',$data['agent'])
                            ->get();
        }
        
       return $this->renderer->render($response, 'management/salesActivity', $data);

    }



    public function salesActivity(Request $request, Response $response, Array $args)
    {

    }

    

}
