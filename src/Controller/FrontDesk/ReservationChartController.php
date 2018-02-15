<?php

namespace App\Controller\FrontDesk;

use Slim\Http\Request;
use Slim\Http\Response;
use App\Controller\Controller;
use App\Model\Reservationdetail;
use App\Model\Reservation;
use App\Model\Room;
use App\Extension\League\Plates\ReservationChartExtension;
use App\Model\RoomType;
use App\Model\Building;
use Kulkul\Options;

class ReservationChartController extends Controller
{
    public function generate(Request $request, Response $response, Array $args)
    {
        $postData = $request->getParsedBody();

        function convert_date($date){
            $exp = explode('-', $date);
            if (count($exp)==3) {
                $date = $exp[2].'-'.$exp[1].'-'.$exp[0];
            }
            return $date;
        }

        $params['start'] = convert_date($postData['start']);
        $params['end'] = convert_date($postData['end']);
        $params['roomType'] = $postData['room_type'];
        // $params['build'] = $postData['building'];

        $data['rooms'] = Room::orderBy('number')->get();
        if( $postData['room_type'] != 0) $data['rooms'] = Room::orderBy('number')->where('room_type_id','=',$postData['room_type'])->get();

        // if( $postData['building'] != 0) $data['rooms'] = Room::orderBy('number')->where('buildings_id','=',$postData['building'])->get();

        $data['date_range'] = $params;

        $reservations = Reservationdetail::whereHas('reservation',function($q) use($params){
                            $q->where('checkin','<',$params["end"])
                                ->where('checkout','>',$params["start"])
                                ->where('status','!=',2);
                        })
                        ->whereHas('room',function($q2) use($params){
                            if($params['roomType'] != 0){
                                    $q2->where('room_type_id','=',$params['roomType']);
                            // } else if ($params['build'] != 0){
                            //         $q2->where('buildings_id','=',$params['build']);
                            }
                        })->get();


        // return $reservations;


        $reservationDetails = [];
        foreach($reservations as $res){
            if($res->change_code == 1){
                $uTimeStart = strtotime($res->reservation->checkin);
                $uTimeEnd = strtotime($res->checkout_at);
            } else if($res->change_code == 2){
                $uTimeStart = strtotime($res->checkin_at);
                $uTimeEnd = strtotime($res->reservation->checkout);
            } else {
                $uTimeStart = strtotime($res->reservation->checkin);
                $uTimeEnd = strtotime($res->reservation->checkout);
            }
            
            
            $uCurTime = $uTimeStart;
            while($uCurTime <= $uTimeEnd){
                $isCheckinOrCheckout = "no";
                if($uCurTime == $uTimeStart)  $isCheckinOrCheckout = "checkin";
                if($uCurTime == $uTimeEnd)  $isCheckinOrCheckout = "checkout";

                if(@$res->checkin_at == "" && @$res->checkout_at == ""){
                    $class = "reserve";
                    if($res->reservation->canmove==0) $class.= " fixed"; // tidak bisa pindah
                    if($res->reservation->canmove!=0) $class.= " moveable"; // bisa pindah
                    if(count($res->reservation->deposits)<1) $class = "reserve unpaid"; //belum deposit

                }
                if(@$res->checkin_at != "" && @$res->checkout_at == ""){
                    $class = "inhouse";
                }
                if(@$res->checkin_at != "" && @$res->checkout_at != "") $class = "checkedout";

                $reservationDetails[$res->rooms_id][date("Y-m-d",$uCurTime)][$isCheckinOrCheckout] = (object)['res'=>$res,"class"=>$class, ""];
                $uCurTime = strtotime(date("Y-m-d",$uCurTime)." + 1 day");
            }

        }

        $data['reservationDetails'] = $reservationDetails;
        $data['arrRoomDate'] = $ArrRoomDate;


        $data['app_profile'] = $this->app_profile;
		$data['options'] = Options::all();

        //$this->renderer->plates()->loadExtension(new ReservationChartExtension);

        //$tes = $this->renderer->render($response, 'frontdesk/reports/reservation-chart', $data);
        return $data;
    }

    public function filter(Request $request, Response $response, Array $args)
    {
        $data['postData'] = [];
        $data['submit_form'] = $this->router->pathFor('frontdesk-reservation-chart-filter');
        $data['room_types'] = RoomType::all();
        // $data['building'] = Building::all();

        if($request->isPost()){
            $data = $this->generate($request, $response, $args);

            // echo "<pre>".print_r($data,true)."</pre>";
            // return $response;

            $data['postData'] = $request->getParsedBody();
            $data['submit_form'] = $this->router->pathFor('frontdesk-reservation-chart-filter');
            $data['room_types'] = RoomType::all();
            // $data['building'] = Building::all();


            return $this->renderer->render($response, 'frontdesk/reports/reservation-filter', $data);
        }
        return $this->renderer->render($response, 'frontdesk/reports/reservation-filter', $data);

    }
}
