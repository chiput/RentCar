<?php

namespace App\Controller\Management;

use Slim\Http\Request;
use Slim\Http\Response;
use App\Controller\Controller;

use App\Model\Agent;
use App\Model\AgenRate;
use App\Model\Reservation;
use App\Model\Reservationdetail;
use Illuminate\Database\Capsule\Manager as DB;

class ActivityDiagramController extends Controller
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
        $agent= $postData["agents"];
        $data["z"]=$agent;
        if(isset($agent)){
            $data["reservations"] = Agent::leftjoin(DB::raw('(SELECT count(reservations.id) as total,
                                        reservations.agent_id as codes, reservations.checkin as checkin,
                                        reservations.checkout as checkout
                                        FROM reservations 
                                        WHERE (checkin < "'.$data['end'].' 00:00:00") and 
                                        (checkin < "'.$data['end'].' 00:00:00")
                                        GROUP BY reservations.agent_id
                                        ) sio'), function($join){
                                        $join->on('agents.id', '=', 'sio.codes');
                                    })
                                ->whereIn('id', $agent)
                                ->select('agents.*','sio.*')
                                ->get();
        }else{

            $data["reservations"] = Agent::leftjoin(DB::raw('(SELECT count(reservations.id) as total,
                                        reservations.agent_id as codes, reservations.checkin as checkin,
                                        reservations.checkout as checkout
                                        FROM reservations 
                                        WHERE (checkin < "'.$data['end'].' 00:00:00") and 
                                        (checkin < "'.$data['end'].' 00:00:00")
                                        GROUP BY reservations.agent_id
                                        ) sio'), function($join){
                                        $join->on('agents.id', '=', 'sio.codes');
                                    })
                                ->select('agents.*','sio.*')
                                ->get();
        }


        return $this->renderer->render($response, 'management/activityDiagram', $data);
    }

    public function activityDiagram(Request $request, Response $response, Array $args)
    {

    }

    

}
