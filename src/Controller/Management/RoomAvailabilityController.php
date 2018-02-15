<?php

namespace App\Controller\Management;

use Slim\Http\Request;
use Slim\Http\Response;
use App\Controller\Controller;
use App\Model\Reservation;
use App\Model\Reservationdetail;
use App\Model\Room;
use App\Model\RoomStatus;
use App\Model\RoomType;
use App\Model\BedType;
use App\Model\Building;
use Illuminate\Database\Capsule\Manager as DB;

class RoomAvailabilityController extends Controller
{
    public function __invoke(Request $request, Response $response, Array $args)
    {
        function convert_date($date){
                    $exp = explode('-', $date);
                    if (count($exp)==3) {
                        $date = $exp[2].'-'.$exp[1].'-'.$exp[0];
                    }
                    return $date;
                }

        $postData = $request->getParsedBody();
        $data['room_type_id']=@$postData["room_type_id"];
        $data['building_id']=@$postData["building_id"];

        if($request->isPost()){        
            $start=$postData["start"];
            $end=$postData["end"];
        }else{
            $start=date("d-m-Y");
            $end=date("d-m-Y");
        }


        $data["start"]=convert_date($start);
        $data['end']=convert_date($end);

        $data["room_types"]=RoomType::all();
        $data["buildings"]=Building::all();
        $data["kamar"]=Room::all();

        $data['roomsz'] = Room::all();

        
        if($data['room_type_id'] != ''){
            $data['roomsz'] = Room::where('rooms.room_type_id','=',$data['room_type_id'])
                                ->get();
        }
        if($data['building_id'] != ''){
            $data['roomsz'] = Room::where('rooms.buildings_id','=',$data['building_id'])
                                ->get();
        }
        if($data['building_id'] != '' && $data['room_type_id'] != ''){
            $data['roomsz'] = Room::where('rooms.room_type_id','=',$data['room_type_id'])
                                ->where('rooms.buildings_id','=',$data['building_id'])
                                ->get();
        }


        return $this->renderer->render($response, 'management/room-availabel', $data);

    }


    public function room_availabel(Request $request, Response $response, Array $args)
    {

    }

}
