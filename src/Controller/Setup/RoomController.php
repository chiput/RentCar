<?php

namespace App\Controller\Setup;

use Slim\Http\Request;
use Slim\Http\Response;
use App\Controller\Controller;
use App\Model\Room;
use App\Model\RoomType;
use App\Model\BedType;
use App\Model\Building;
use App\Model\RoomDescription;
use App\Model\RoomFacility;
use App\Model\RoomRelFacility;
use App\Model\RoomRelDescription;
use App\Model\RoomStatus;
use App\Model\Agent;
use App\Model\RoomRate;

class RoomController extends Controller
{
    public function __invoke(Request $request, Response $response, Array $args)
    {
        $data['rooms'] = Room::all();
        $data['agents'] = Agent::where("is_active","=","1")->get();
        $data['message'] = $this->session->getFlash('success');
        $data['app_profile'] = $this->app_profile;
        return $this->renderer->render($response, 'setup/room', $data);
    }

    public function form(Request $request, Response $response, Array $args)
    {
        $data = [];
        // if update
        if (isset($args['id'])) $data['room'] = Room::find($args['id']);

        // if error
        $data['errors'] = $this->session->getFlash('error_messages');
        if (!is_null($data['errors'])) {
            $data['room'] = (object) $this->session->getFlash('post_data');
        }

        $data['bedtypes'] = BedType::all();
        $data['roomtypes'] = RoomType::all();
        $data['buildings'] = Building::all();
        $data['roomfacilities'] = RoomFacility::all();
        $data['relFacility'] = RoomRelFacility::where('room_id','=',@$args['id'])->get();
        $data['relDescription'] = RoomRelDescription::where('room_id','=',@$args['id'])->get();
        $data['app_profile'] = $this->app_profile;
        $data['room_descriptions'] = RoomDescription::all();

        return $this->renderer->render($response, 'setup/room-form', $data);
    }

    public function save(Request $request, Response $response, Array $args)
    {
        $postData = $request->getParsedBody();

        // validation
        $this->validation->validate([
            'number|Nomor kamar'        => [$postData['number'], 'required'],
            //'bulding|Gedung'            => [$postData['bulding'], ''],
            'level|Lantai'              => [$postData['level'], 'required'],
            'room_type_id|Jenis Kamar'  => [$postData['room_type_id'], 'number'],
        ]);

        //return $response->write(print_r($postData, true));

        if (!$this->validation->passes()) {

            $this->session->setFlash('error_messages', $this->validation->errors()->all());
            $this->session->setFlash('post_data', $postData);

            if ($postData['id'] == '') {
                return $response->withRedirect($this->router->pathFor('setup-room-new'));
            } else {
                return $response->withRedirect($this->router->pathFor('setup-room-update'));
            }
        }

        // insert



        if ($postData['id'] == '') {
            $this->session->setFlash('success', 'Mobil tersimpan');
            $room = new Room();
            $roomstatus = new RoomStatus();
        } else {
        // update
            $this->session->setFlash('success', 'Mobil terbaharui');
            $room = Room::find($postData['id']);
            $roomstatus = RoomStatus::where('rooms_id', $postData['id'])->first();
        }

        $room->number = $postData['number'];
        $room->adults = $postData['adults'];
        $room->children = $postData['children'];
        $room->level = $postData['level'];
        // $room->buildings_id = $postData['buildings_id'];
        $room->room_type_id = $postData['room_type_id'];
        // $room->bed_type_id = $postData['bed_type_id'];
        $room->currency = $postData['currency'];
        $room->note = $postData['note'];
        $room->is_active = $postData['is_active'];
        $room->save();

        $room_id = $room->id;


        for ($i = 1; $i<=7; $i++) {
                $room_rate = new RoomRate;
                $room_rate->dayname_id = $i;
                $room_rate->room_id = $room_id;
                $room_rate->room_price = 0;
                $room_rate->room_only_price = 0;
                $room_rate->breakfast_price = 0;
                $room_rate->save();
            }

        if ($postData['id'] != '' && $roomstatus == null) {
        }else{
            $roomstatus->rooms_id = $room_id;
            $roomstatus->date = date('Y-m-d');
            $roomstatus->status = 1;
            $roomstatus->remark = '';
            $roomstatus->users_id = $this->session->get('activeUser')["id"];
            $roomstatus->save();
        }



        RoomRelDescription::where('room_id','=',$room->id)->delete();
        RoomRelFacility::where('room_id','=',$room->id)->delete();

        $room->descriptions()->attach($postData['room_descriptions']);
        foreach ($postData['room_facilities'] as $facility) {
            $relFacility = new RoomRelFacility();
            $relFacility->room_id = $room->id;
            $relFacility->room_facility_id = $facility;
            $relFacility->save();
        }
        


        return $response->withRedirect($this->router->pathFor('setup-room'));
    }

    public function delete(Request $request, Response $response, Array $args)
    {
        $roomstatus = RoomStatus::where('rooms_id', $args['id']);
        $roomstatus->delete();
        $department = Room::find($args['id']);
        $department->delete();
        $this->session->setFlash('success', 'Cars deleted');
        return $response->withRedirect($this->router->pathFor('setup-room'));
    }
}
