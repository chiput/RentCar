<?php

namespace App\Controller\Housekeeping;

use Slim\Http\Request;
use Slim\Http\Response;
use App\Controller\Controller;
use App\Model\Room;
use App\Model\RoomStatus;
use App\Model\RoomStatusType;
use App\Model\RoomStatusLog;
use App\Model\Building;
use App\Model\RoomType;
use App\Model\BedType;
use App\Model\Reservationdetail;
use App\Model\Reservation;
use Illuminate\Database\Capsule\Manager as DB;

class HkRoomStatusController extends Controller
{
	public function __invoke(Request $request, Response $response, Array $args)
	{
		$postData = $request->getParsedBody();
        $data['room_type_id']=@$postData["room_type_id"];
        $data['bed_type_id']=@$postData["bed_type_id"];
        $data['building_id']=@$postData["building_id"];
        if($request->isPost()){        
            $date=$postData["date"];
        }else{
            $date=date("d-m-Y");
        }

        $rooms=Room::where('id','>=',0);

        if($data['room_type_id']!=''){
            $rooms->where('room_type_id',"=",$data["room_type_id"]);
        }

        if($data['bed_type_id']!=''){
            $rooms->where('bed_type_id',"=",$data["bed_type_id"]);
        }
        
        if($data['building_id']!=''){
            $rooms->where('buildings_id',"=",$data["building_id"]);
        }

        if($data['room_type_id']==''&&$data['bed_type_id']==''&&$data['building_id']==''){
            $data["rooms"]=Room::all();
        }else{
            $data["rooms"]=$rooms->get();
        }


        $data["room_types"]=RoomType::all();
        $data["bed_types"]=BedType::all();
        $data["buildings"]=Building::all();
        $data['roomstatustype'] = RoomStatusType::all();
        $data['roomslog'] = RoomStatusLog::orderBy('id', 'desc')->get();

        $data["date"]=$date;

        return $this->renderer->render($response, 'housekeeping/room-status', $data);
	}

	public function save(Request $request, Response $response, Array $args)
	{
		$postData = $request->getParsedBody();
		$date = date('d-m-Y');

		if(!isset($postData['rooms_id'])) {
			$this->session->setFlash('success', 'Pilih minimal 1 Kamar');
		} else {
			$this->session->setFlash('success', 'Kamar Sudah Diset');

            

			foreach ($postData['rooms_id'] as $key => $rooms) {
				$setStatus = RoomStatus::where("rooms_id", "=", $postData['rooms_id'][$key])->first();
				$setStatus->date = $date;
				$setStatus->status = $postData['status_kamar'];
				$setStatus->save();
			}

		}

		return $response->withRedirect($this->router->pathFor('housekeeping-room-status'));
	}

    public function process(Request $request, Response $response, Array $args)
    {
        $postData = $request->getParsedBody();

        $tanggal = date('Y-m-d H:i:s');

        $reservation = "";
        $checkout = "";

        $reservation = Reservation::where('checkin', '<=', $tanggal)->where('checkout', '>=', $tanggal)->get();
        $checkouts = Reservation::whereDate('checkout', '=', $postData['tanggal'])->get(); 

        //var_dump(json_encode($checkouts));
        //die();

        $counter = 0;

             if($reservation != null) {

                foreach ($reservation as $resDetail) {
                    $rooms = Reservationdetail::where('reservations_id', '=', $resDetail->id)->get();

                    foreach ($rooms as $room) {
                        $roomstatus = RoomStatus::where('rooms_id', '=', $room->rooms_id)->first();
                        $roomstatus->date = $postData['tanggal'];
                        $roomstatus->status = 3;
                        $roomstatus->save();
                    }
                }

                $counter +=1;
            }

             if($checkouts != null) {

                foreach ($checkouts as $checkout) {

                    $rooms = Reservationdetail::where('reservations_id', '=', $checkout->id)->get();

                    foreach ($rooms as $room) {
                        $checkout = RoomStatus::where('rooms_id', '=', $room->rooms_id)->first();
                        $checkout->date = $postData['tanggal'];
                        $checkout->status = 2;
                        $checkout->save();
                    }
                }

                $counter +=1;

            }

            if($counter > 0) {
                $message = "Set Status Otomatis Telah Dikerjakan";            
            } else {
                $message = "Set Status Otomatis Gagal Dikerjakan"; 
            }

        $roomstatuslog = new RoomStatusLog();
        $roomstatuslog->date = $postData['tanggal'];
        $roomstatuslog->remark = $message;
        $roomstatuslog->users_id = $this->session->get('activeUser')["id"];
        $roomstatuslog->save();
        
        return $response->withRedirect($this->router->pathFor('housekeeping-room-status'));
    }
}