<?php

namespace App\Controller\FrontDesk;

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


        $postData = $request->getParsedBody();
        $data['room_type_id']=@$postData["room_type_id"];
        // $data['building_id']=@$postData["building_id"];

        if($request->isPost()){        
            $start=$postData["start"];
            $end=$postData["end"];
        }else{
            $start=date("Y-m-d");
            $end=date("Y-m-d");
        }


        $data["start"]=$start;
        $data['end']=$end;

        $data["room_types"]=RoomType::all();
        // $data["buildings"]=Building::all();
        $data["kamar"]=Room::all();

        $data['roomsz'] = Room::all();

        
        if($data['room_type_id'] != ''){
            $data['roomsz'] = Room::where('rooms.room_type_id','=',$data['room_type_id'])
                                ->get();
        }
        // if($data['building_id'] != ''){
        //     $data['roomsz'] = Room::where('rooms.buildings_id','=',$data['building_id'])
        //                         ->get();
        // }
        // if($data['building_id'] != '' && $data['room_type_id'] != ''){
        //     $data['roomsz'] = Room::where('rooms.room_type_id','=',$data['room_type_id'])
        //                         ->where('rooms.buildings_id','=',$data['building_id'])
        //                         ->get();
        // }


        return $this->renderer->render($response, 'frontdesk/room-availabel', $data);

    }


    public function room_availabel(Request $request, Response $response, Array $args)
    {

    }

}
