<?php

namespace App\Controller\FrontDesk;

use Slim\Http\Request;
use Slim\Http\Response;
use App\Controller\Controller;
use App\Model\RoomChanges;
use App\Model\Reservation;
use App\Model\Reservationdetail;
use App\Model\Room;
use App\Model\RoomStatus;
use App\Model\RoomType;
use App\Model\BedType;
use Kulkul\Reservation\RoomRate;
use Kulkul\CurrencyFormater\FormaterAdapter;
use Illuminate\Database\Capsule\Manager as DB;

class RoomchangeController extends Controller
{

    public function __invoke(Request $request, Response $response, Array $args){

        $data['app_profile'] = $this->app_profile;
        $data["roomChanges"] = RoomChanges::all();

        return $this->renderer->render($response, 'frontdesk/room-change', $data);

    }

    public function form(Request $request, Response $response, Array $args){

        $data['app_profile'] = $this->app_profile;

        return $this->renderer->render($response, 'frontdesk/room-change-form', $data);


    }

    public function save(Request $request, Response $response, Array $args){

        function convert_date($date){
            $exp = explode('-', $date);
            if (count($exp)==3) {
                $date = $exp[2].'-'.$exp[1].'-'.$exp[0];
            }
            return $date;
        }

        $postData=$request->getParsedBody();

        $this->validation->validate([
            'date|Tanggal' => [convert_date($postData['date']), 'required'],
            'reservations_detail_rooms_id|Kamar Dipakai' => [$postData['reservations_detail_rooms_id'], 'required'],
            'selAvail|Kamar Tersedia' => [$postData['selAvail'], 'required'],
        ]);

        $roomChange=new RoomChanges();

        if (!$this->validation->passes()) {

            $this->session->setFlash('error_messages', $this->validation->errors()->all());
            $this->session->setFlash('post_data', $postData);
            return $response->withRedirect($this->router->pathFor('frontdesk-roomchange-form'));

        }


        $roomChange->date=convert_date($postData["date"]);
        $roomChange->remark=$postData["remark"];
        $roomChange->users_id=$this->session->get('activeUser')["id"];
        $roomChange->save();

        $from=Reservationdetail::find($postData["reservations_detail_id"]);
        $from->checkout_at=convert_date($postData["date"]);
        $from->room_changes_id=$roomChange->id;
        $from->change_code=1;

            // new script
                $reserv = Reservation::where('id','=',$from->reservations_id)->first();
                    $rescheckin = explode(' ', $reserv->checkin);
                    $rescheckout = explode(' ', $reserv->checkout);
                    $roomcheckout = convert_date($postData["date"]);

                    $resin = strtotime($rescheckin[0]);
                    $resout = strtotime($rescheckout[0]);
                    $roomout = strtotime($roomcheckout);

                    $pindah = abs($resout-$roomout);
                    $pindah = $pindah/86400;
                    $pindah = intval($pindah);

                    $full = abs($resout-$resin);
                    $full = $full/86400;
                    $full = intval($full);

                    $selisih = $full - $pindah;

                    $priceday = $from->price / $full;
                    $price = $priceday * $selisih;

                    $from->price = $price;                
            // end script


        $from->save();

        $to=new Reservationdetail();
        $to->checkin_code=$from->checkin_code;
        // check_out_id ???
        $to->adult=$from->adult;
        $to->children=$from->children;
        $to->creditcard_id=$from->creditcard_id;
        $to->creditcard_number=$from->creditcard_number;
        $to->note=$from->note;
        $to->internal_note=$from->internal_note;
        $to->is_compliment=1;
        $to->users_id=$this->session->get('activeUser')["id"];
        $to->reservations_id=$from->reservations_id;
        $to->rooms_id=$postData["selAvail"];
        $to->checkin_at=convert_date($postData["date"]);
        $to->checkout_at=NULL;
        $to->room_changes_id=$roomChange->id;
        $to->change_code=2;
        $to->price=FormaterAdapter::reverse($postData["price"])*1;
        $to->save();

        $roomstatus = RoomStatus::where('reservationdetail_id', '=', $postData["reservations_detail_id"])
                            ->update(
                                ['reservationdetail_id' => 0],
                                ['date' => date("Y-m-d")],
                                ['status' => 2]
                            );

        $fromstatus = $roomstatus->status;

        $tostatus = RoomStatus::where('rooms_id', '=', $to->rooms_id)
                            ->update(
                                ['reservationdetail_id' => $postData["reservations_detail_id"]],
                                ['date' => convert_date($postData["date"])],
                                ['status' => $fromstatus],
                                ['remark' => "Changed Room"]
                            );



        $this->session->setFlash('success', "Pindah kamar sudah diproses");
        return $response->withRedirect($this->router->pathFor('frontdesk-roomchange'));

    }

    public function ajax_reserved_room(Request $request, Response $response, Array $args){
        
        function convert_date($date){
            $exp = explode('-', $date);
            if (count($exp)==3) {
                $date = $exp[2].'-'.$exp[1].'-'.$exp[0];
            }
            return $date;
        }

        $postData=$request->getParsedBody();
        $date=convert_date($postData["date"]);
        $details=Reservationdetail::where(DB::raw('left(`checkin_at`,10)'),"<=",$date)
                                    ->whereNull('checkout_at')
                                    ->whereHas("reservation",function($q) use ($date){
                                        $q->where('checkout','>',$date);
                            })->get();
        // echo $details->toSql(); return false;
        $rooms=[];
        foreach ($details as $key => $detail) {
            $rooms[]=(object)[
                "id"=>$detail->id,
                "nobukti"=>$detail->reservation->nobukti,
                "checkin_at_date"=>convert_date(substr($detail->checkin_at,0,10)),
                "checkin_at_time"=>substr($detail->checkin_at,10,18),
                "rooms_id"=>$detail->rooms_id,
                "name"=>$detail->reservation->guest->name,
                "number"=>$detail->room->number,
                "checkin"=>$detail->reservation->checkin,
                "checkout"=>$detail->reservation->checkout,
                "agent_id"=>$detail->reservation->agent_id,
            ];
        }
        return $response->write(json_encode($rooms));
    }

    public function delete(Request $request, Response $response, Array $args){
        $id=$args["id"];


        //kamar baru
        $room2=Reservationdetail::where("room_changes_id","=",$id)
                                ->where("change_code","=","2")
                                ->whereNull("checkout_at"); //Hanya untuk yang belum checkout
        if($room2->count()>0){

            $roomstatus = RoomStatus::where("reservationdetail_id",'=', $room2->id)
                            ->update(
                                ['reservationdetail_id' => 0],
                                ['date' => date("Y-m-d")],
                                ['status' => 2],
                                ['remark' => ""]
                            );

            $room2->delete();

            $roomChange=RoomChanges::find($id);
            $roomChange->delete();

            $room1=Reservationdetail::where("room_changes_id","=",$id)->where("change_code","=","1")->first();
            $room1->checkout_at=NULL;
            $room1->room_changes_id=0;
            $room1->change_code=0;
            $room1->price=$room1->price_old;
            $room1->save();
            $this->session->setFlash('success', "Pindah kamar dibatalkan");
        }else{
            $this->session->setFlash('error', "No HI.16110005 sudah checkout");
        }


        return $response->withRedirect($this->router->pathFor('frontdesk-roomchange'));

    }

}
