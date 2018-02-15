<?php

namespace App\Controller\FrontDesk;

use Slim\Http\Request;
use Slim\Http\Response;
use App\Controller\Controller;
use App\Model\Reservation;
use App\Model\Reservationdetail;
use App\Model\Room;
use App\Model\RoomStatus;
use App\Model\RoomStatusType;
use App\Model\RoomType;
use App\Model\BedType;
use App\Model\Building;
use Illuminate\Database\Capsule\Manager as DB;

class RoomstatusController extends Controller
{
    public function __invoke(Request $request, Response $response, Array $args){


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
        //$data["rooms"] = Room::all();
        
        /*
        $occup=Reservationdetail::whereHas("reservation",function($q) use ($date){
                        $q->where('checkout','>=',$date)
                        ->where('status','=','0'); // hanya yang confirm reservasi
                    })
                    ->where('checkin_at','<=',$date) 
                    ->get();

        $data["occupied"]=[];
        foreach ($occup as $key => $room) {
            $data["occupied"][$room->rooms_id]=$room;
        }

        $reserved=Reservationdetail::whereHas("reservation",function($q) use ($date){
                        $q->where('checkout','>=',$date)
                        ->where('checkin','<=',$date)
                        ->where('status','=','0'); // hanya yang confirm reservasi
                    })
                    ->where('checkin_at','=',null) 
                    ->get();

        $data["reserved"]=[];
        foreach ($reserved as $key => $room) {
            $data["reserved"][$room->rooms_id]=$room;
        }



        $status=RoomStatus::where("date","=",$date)->get();

        $data["status"]=[];
        foreach ($status as $key => $stat) {
            $data["status"][$stat->rooms_id]=$stat;
        }

        */

        $data["date"]=$date;

        return $this->renderer->render($response, 'frontdesk/room-perday-status', $data);

    }


    public function detail(Request $request, Response $response, Array $args){
        
        function convert_date($date){
                    $exp = explode('-', $date);
                    if (count($exp)==3) {
                        $date = $exp[2].'-'.$exp[1].'-'.$exp[0];
                    }
                    return $date;
                }
        // $start = $args["start"];
        // $end = $args["end"];
        // $rooms_id = $postData["rooms_id"];



        if($request->isPost()){     
            $postData = $request->getParsedBody();   
            return $response->withRedirect($this->router->pathFor('frontdesk-roomstatus-detail',$postData));
        }

        $data=$args;
        $data['room'] = Room::find($args["rooms_id"]);
        $data['roomstatus'] = RoomStatusType::all();

        /*
        $occup=Reservationdetail::whereHas("reservation",function($q) use ($args){
                        $q->WhereBetween('checkout',[$args["start"],$args["end"]])
                        ->where('status','=','0'); // hanya yang confirm reservasi
                    })
                    ->where(function ($query) use ($args) {
                        $query->WhereBetween('checkin_at',[$args["start"],$args["end"]]);
                        })
                    ->where("rooms_id",$args["rooms_id"])
                    ->get();
        
        $data["occupied"]=[];

        foreach ($occup as $key => $detail) {
            $d_checkin=strtotime($detail->checkin_at);
            $d_checkout=strtotime($detail->reservation->checkout);
            $dt=$d_checkin;
            while($dt<=$d_checkout){
                $data["occupied"][date('Y-m-d',$dt)]=$detail;
                $dt=strtotime(date('Y-m-d',$dt)." +1 day");
            }
        }


        $reserved=Reservationdetail::whereHas("reservation",function($q) use ($args){
                        // $q->WhereBetween('checkout',[$args["start"],$args["end"]])
                        $q->where('checkout','>=',$args["start"])
                        ->where('checkin','<=',$args["end"])
                        ->where('status','=','0'); // hanya yang confirm reservasi
                    })
                    ->where("rooms_id",$args["rooms_id"])
                    ->where('checkin_code','=',null) 
                    ->get();
        //             ->toSql();
        // echo $reserved; return $response;
        $data["reserved"]=[];

        foreach ($reserved as $key => $detail) {
            $d_checkin=strtotime($detail->reservation->checkin);
            $d_checkout=strtotime($detail->reservation->checkout);
            $dt=$d_checkin;
            while($dt<=$d_checkout){
                $data["reserved"][date('Y-m-d',$dt)]=$detail;
                $dt=strtotime(date('Y-m-d',$dt)." +1 day");
            }
        }

        //echo $data["occupied"];
        //return;
        */

        $status=RoomStatus::whereBetween("date",[convert_date($args["start"]),convert_date($args["end"])])
                            ->where("rooms_id",$args["rooms_id"])
                            ->get();

        $data["status"]=[];
        foreach ($status as $key => $stat) {
            $data["status"][$stat->date]=$stat;
        }
        

        return $this->renderer->render($response, 'frontdesk/room-status-detail', $data);        

    }



    public function update(Request $request, Response $response, Array $args)
    {
        function convert_date($date){
                    $exp = explode('-', $date);
                    if (count($exp)==3) {
                        $date = $exp[2].'-'.$exp[1].'-'.$exp[0];
                    }
                    return $date;
                }

        $postData=$request->getParsedBody();
        $d_start=strtotime(convert_date($postData["start"]));
        $d_end=strtotime(convert_date($postData["end"]));
        $dt=$d_start;
        while($dt<=$d_end){
            $status=RoomStatus::where("rooms_id","=",$postData["rooms_id"])
                    ->where("date","=",date("Y-m-d",$dt));
            $status->delete();    
            // if($status->count()<1){
            //     if($postData["status"]>=0){
            //         $status=new RoomStatus();
            //     }
            // }

            if($postData["status"]>=0){

                $status=new RoomStatus();
                $status->rooms_id=$postData["rooms_id"];
                $status->date=date("Y-m-d",$dt);
                $status->status=$postData["status"];
                $status->remark=$postData["remark"];
                $status->users_id=$this->session->get('activeUser')["id"];;
                $status->save();
                //echo $postData["status"]." ".date("Y-m-d",$dt)."<br/>";
            }
            
            $dt=strtotime(date('Y-m-d',$dt)." +1 day");
            
        }
        return $response->withRedirect($this->router->pathFor('frontdesk-roomstatus-detail',$args));
        //return;
    }

    public function check(Request $request, Response $response, Array $args)
    {
        function convert_date($date){
                    $exp = explode('-', $date);
                    if (count($exp)==3) {
                        $date = $exp[2].'-'.$exp[1].'-'.$exp[0];
                    }
                    return $date;
                }
        $rooms = Room::all();

        $start=date("Y-m-")."01";
        $end=date("Y-m-t");

        $data['rooms'] = [];
        foreach ($rooms as $room) {
            $data['rooms'][$room->id]=$room;
        }


        $data['app_profile'] = $this->app_profile;

        if($request->isPost()){
            $postData = $request->getParsedBody();
            $start=convert_date($postData["start"]);
            $end=convert_date($postData["end"]);
        }
        
        // echo $start;
        // echo $end;
        //$data['reservations'] = Reservation::whereBetween('tanggal','get')->get();

        $reservations=DB::table("reservations")
                            ->join('reservationdetails', 'reservations.id', '=', 'reservationdetails.reservations_id')
                            ->leftjoin('deposits', 'reservations.id', '=', 'deposits.reservations_id')
                            ->select("reservationdetails.rooms_id","deposits.id","reservations.checkin","reservations.checkout")
                            ->whereBetween('reservations.checkin',[$start,$end] )
                            ->orWhereBetween('reservations.checkout',[$start,$end] )
                            ->get();

        $data["reservations"]=[];
        foreach ($reservations as $res) {
            $dtstart=strtotime($start);
            $dtend=strtotime($end);
            $dt=$dtstart;
            while($dt<$dtend):
                if(date("Y-m-d",$dt)>=$res->checkin&&date("Y-m-d",$dt)<=$res->checkout){
                    $data["reservations"][$res->rooms_id][date("Y-m-d",$dt)]=$res;
                }
                $dt=strtotime(date("Y-m-d",$dt)." + 1 day");
            endwhile;
        }
        $data["start"]=$start; 
        $data["end"]=$end;
        return $this->renderer->render($response, 'frontdesk/room-status', $data);

        // print_r($reservations->get());

        // return $response;

    }

}
