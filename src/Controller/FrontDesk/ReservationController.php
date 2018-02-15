<?php

namespace App\Controller\FrontDesk;

use Slim\Http\Request;
use Slim\Http\Response;
use App\Controller\Controller;
use App\Model\Guest;
use App\Model\Reservation;
use App\Model\Idtype;
use App\Model\Company;
use App\Model\Negara;
use App\Model\RoomStatus;
use App\Model\RoomStatusType;
use App\Model\Agent;
use App\Model\AgentRate;
use App\Model\Reservationdetail;
use App\Model\PeriodicRate;
use App\Model\PeriodicRateDetail;
use Kulkul\Reservation\RoomRate;
use App\Model\Creditcard;
use Kulkul\CodeGenerator\ReservationCode;
use Kulkul\CurrencyFormater\FormaterAdapter;
//use Harmoni\DateConverter\DateConverterProvider;

class ReservationController extends Controller
{
    public function __invoke(Request $request, Response $response, Array $args)
    {

        $data['guests'] = Guest::all();
        $data['app_profile'] = $this->app_profile;
        $data['reservations'] = Reservation::whereHas('details',function($q){
            $q->where('checkin_at','=',null);
        })->orderBy('id','desc')->get();

        $data['reservations_checkin'] = Reservation::whereHas('details',function($q){
            $q->whereNotNull('checkin_at');
        })->orderBy('id','desc')->get();

        //$data['reservations'] = Reservation::orderBy('id','desc')->get();
        $data['message'] = $this->session->getFlash('success');
        return $this->renderer->render($response, 'frontdesk/reservation', $data);
    }

    public function form(Request $request, Response $response, Array $args)
    {
        $data = [];
        $data['app_profile'] = $this->app_profile;
        $data['countries'] = Negara::all();
        $data['agents'] = Agent::where("is_active","=","1")->get();
        $data['companies'] = Company::all();
        $data['guests'] = Guest::all();

        if (isset($args["id"])) $data['reservation'] = Reservation::find($args["id"]);
        $data['idtypes'] = Idtype::all();
        $data['app_profile'] = $this->app_profile;
        if (!isset($args["id"])) $data['newCode'] = ReservationCode::generate();
        $data['creditcards'] = Creditcard::all();

        return $this->renderer->render($response, 'frontdesk/reservation-form', $data);
    }

    public function room_available(Request $request, Response $response, Array $args){

        if($args['checkin']==$args['checkout']){
            return $response->write(json_encode([]));
        }

        $rates = new RoomRate($args['checkin'], $args['checkout']); //data rate
        $ratesData = $rates->getRoomRates();
        //var_dump($ratesData);
        $rooms=[];
        $arr=[];

        /// data rate periodic

        $periodicRate = PeriodicRate::where("start_date","<=",$args['checkout'])
            ->where("end_date",">=",$args['checkin'])
            ->get();


        $periodicDetails = PeriodicRateDetail::whereHas("rate",function($q) use ($args){
            $q->where("start_date","<=",$args['checkout'])
            ->where("end_date",">=",$args['checkin']);
        })->get();


        $periodicRateDate = [];

        foreach ($periodicRate as $key => $pR) {
            $dt_start=strtotime($pR->start_date);  $dt_end=strtotime($pR->end_date);  $dt = $dt_start;
            while ($dt <= $dt_end) {
                foreach ($periodicDetails as $key => $pDetail) {
                    $periodicRateDate[date("Y-m-d",$dt)][$pDetail->rooms_id] = $pDetail;
                }
                $dt = strtotime(date("Y-m-d",$dt)." + 1 day");
            }
        }


        foreach ($ratesData as $key=>$rate) {
            $arr[$rate->id]=(object)[
                "id"=>$rate->id,
                "number"=>$rate->number,
                "type_name"=>$rate->room_type_name,
                "type_id"=>$rate->type_id,
                "plat_number"=>$rate->level,
                // "bed_type_name"=>$rate->bed_type_name,
                // "bed_type_id"=>$rate->bed_type_id,
                "rates"=>[]
            ];
        }


        foreach ($ratesData as $key => $rate) {
            $rate_ =(object)[
                "date"=>$rate->date,
                "dayname"=>$rate->dayname,
                "room_price"=>($rate->room_price+$rate->breakfast_price),
                "room_only_price"=>$rate->room_only_price,
                "breakfast_price"=>$rate->breakfast_price];

            if(isset($periodicRateDate[$rate->date][$rate->id])){ //jika ada harga periodiknya
                $rate_ = $this->periodicCalc($periodicRateDate[$rate->date][$rate->id],$rate_);
            }

            $arr[$rate->id]->rates[] = $rate_;
        }


        foreach ($arr as $key => $room) { //default status kamar free
            $room->status="Free";
            $arr_rooms[$room->id]=$room;
        }

        ///// checking occupancy & status
        
        $_checkin = $this->convert_date($args['checkin']);
        $_checkout = $this->convert_date($args['checkout']);
        // var_dump($_checkin); return false;
        $occup=Reservationdetail::whereHas("reservation",function($q) use ($_checkin, $_checkout){
                                $q->where('checkout','>=',$_checkin)
                                ->where('checkin','<=',$_checkout)
                                ->where('status','!=',2);
                            })
                            ->whereNull('checkout_at')
                            ->get();


        $data["booking"]=[];
        foreach ($occup as $key => $val) {
            if(isset($arr_rooms[$val->rooms_id])){
                
                $arr_rooms[$val->rooms_id]->status="Booking"; //add occupied status
                if(substr($val->reservation->checkout,0,10) == $_checkin){
                    $arr_rooms[$val->rooms_id]->status="Free"; //add occupied status
                }
                if(substr($val->reservation->checkin,0,10) == $_checkout){
                    $arr_rooms[$val->rooms_id]->status="Free"; //add occupied status
                }
                // $arr_rooms[$val->rooms_id]->status=$val->reservation->checkout." / ".$this->convert_date($args['checkin']); //add occupied status
            }
        }

        // cek status out of service
        $outservice=RoomStatus::whereBetween("date",[$args['checkin'],$args['checkout']])
                                ->where('status','=','5')->get();


        $data["outservice"]=[];
        foreach ($outservice as $key => $val) {
            if(isset($arr_rooms[$val->rooms_id])){
                $arr_rooms[$val->rooms_id]->status="Out of Service";
            }
        }


        $agentRates = AgentRate::where("agents_id","=",@$args['agent'])->get();
        $w_agentRates=[];
        foreach($agentRates as $aRate){
            // echo $aRate;

            foreach ($arr_rooms as $key => $room) {
                if($aRate->room_id == $room->id){ //echo $room->id."<br/>";
                    foreach($room->rates as $rate){
                        $rate->room_price = $aRate->room_price;
                        $rate->breakfast_price = $aRate->breakfast_price;
                        $rate->room_only_price = $aRate->room_only_price;
                        // echo print_r($rate,true).'<br/>';
                    }
                    // echo print_r($room,true).'<br/>';
                    $it = $room;
                    $w_agentRates[] = $it;

                }
            }
        }

        if($agentRates->count()<1) $w_agentRates = $arr_rooms;

        $rooms=[];
        foreach ($w_agentRates as $key => $room) {
            foreach($room->rates as $rate){
                $rate->breakfast_price = number_format($rate->breakfast_price,0,',','.');
                $rate->room_only_price = number_format($rate->room_only_price,0,',','.');
                $rate->room_price = number_format($rate->room_price,0,',','.');
            }
            $rooms[]=$room;
        }

        return $response->write(json_encode($rooms));
    }

    public function save(Request $request, Response $response, Array $args)
    {
        $postData = $request->getParsedBody();



        $this->validation->validate([
            'tanggal|Tanggal' => [$this->convert_date($postData['tanggal']), 'required'],
            'checkin|Check In' => [$this->convert_date($postData['checkin']), 'required'],
            'checkout|Check Out' => [$this->convert_date($postData['checkout']), 'required'],
            'guests_name|Nama Tamu' => [$postData['guests_name'], 'required'],
        ]);

        if (!$this->validation->passes()) {

            $this->session->setFlash('error_messages', $this->validation->errors()->all());
            $this->session->setFlash('post_data', $postData);

            if ($postData['id'] == '') {
                return $response->withRedirect($this->router->pathFor('frontdesk-reservation-add'));
            } else {
                return $response->withRedirect($this->router->pathFor('frontdesk-reservation-edit'));
            }
        }


        // insert

        if ($postData['id'] == '') {
            $this->session->setFlash('success', 'Reservasi ditambahkan');
            $reservation = new Reservation();
            $reservation->users_id=$this->session->get('activeUser')["id"];
        } else {
        // update
            $this->session->setFlash('success', 'Reservasi diperbaharui');
            $reservation = Reservation::find($postData['id']);
            $reservation->users_id_edit=$this->session->get('activeUser')["id"];
        }

        if($postData['guests_id']==''){
            $guests = new Guest();
            // $guests->users_id=$this->session->get('activeUser')["id"];
        }else{
            $guests = Guest::find($postData['guests_id']);
            // $guests->users_id_edit=$this->session->get('activeUser')["id"];
        }

        $guests->name=$postData["guests_name"];
        $guests->address=$postData["guests_address"];
        $guests->state=$postData["guests_state"];
        $guests->country_id=$postData["guests_countries_id"];
        $guests->city=$postData["guests_city"];
        $guests->zipcode=$postData["guests_zipcode"];
        $guests->phone=$postData["guests_phone"];
        $guests->fax=$postData["guests_fax"];
        $guests->email=$postData["guests_email"];
        $guests->company_id=$postData["guests_company_id"];
        $guests->sex=$postData["guests_sex"];
        $guests->date_of_birth=$this->convert_date($postData["guests_date_of_birth"])==""?null:$this->convert_date($postData["guests_date_of_birth"]);
        $guests->idtype_id=$postData["guests_idtype_id"];
        $guests->idcode=$postData["guests_idcode"];
        $guests->users_id=$this->session->get('activeUser')["id"];


        $guests->save();

        $guests_id=$guests->id;

        //return $response->write(var_dump($postData,true));

        $reservation->tanggal=$this->convert_date($postData["tanggal"]);
        $reservation->checkin=$this->convert_date($postData["checkin"]);
        $reservation->checkout=$this->convert_date($postData["checkout"]);
        $reservation->nobukti=$postData["nobukti"];
        $reservation->canmove=isset($postData["canmove"])? 0 : 1;
        $reservation->contracts_id=@$postData["contracts_id"] | 0;
        $reservation->waitinglists_id=@$postData["waitinglists_id"] | 0;
        $reservation->kamar = count($postData["rooms_id"]);
        $reservation->adult=@$postData["adult"] | 0;
        $reservation->child=@$postData["child"] | 0;
        //$reservation->creditcard_id=@$postData["jeniskartukredit"];
        //$reservation->creditcard=$postData["creditcard"];
        //$reservation->creditcarddate=$this->convert_date($postData["creditcarddate"])==""?null:$this->convert_date($postData["creditcarddate"]);
        $reservation->guests_id=$guests_id;
        $reservation->agent_id=$postData["agent_id"];
        $reservation->status=$postData["status"];
        $reservation->remarks=$postData["remarks"];
        $reservation->canceldate=$this->convert_date($postData["canceldate"]);
        if($postData["status"]!=2){
            $reservation->canceldate=null;
        }
        // $reservation->users_id=$this->session->get('activeUser')["id"];
        // $reservation->users_id_edit=0;
        $reservation->updated_at=date("Y-m-d H:i:s");
        //print_r($reservation);
        //return false;
        $reservation->save();
        $reservations_id=$reservation->id;


        $reservationdetails=Reservationdetail::where("reservations_id",$reservations_id);
        $reservationdetails->delete();



        foreach ($postData["rooms_id"] as $key => $rooms) {
            $reservationdetail = new Reservationdetail();
            $reservationdetail->rooms_id=$postData["rooms_id"][$key];
            $reservationdetail->reservations_id=$reservations_id;
            $reservationdetail->price=FormaterAdapter::reverse($postData["price"][$key]);
            $reservationdetail->priceExtra = FormaterAdapter::reverse($postData["priceExtra"][$key]);
            $reservationdetail->price_old=FormaterAdapter::reverse($postData["price"][$key]);
            $reservationdetail->priceExtra_old = FormaterAdapter::reverse($postData["priceExtra"][$key]);
            $reservationdetail->users_id=$this->session->get('activeUser')["id"];
            $reservationdetail->save();

            $reservationdetail_id = $reservationdetail->id;

            // Adding status Free Ready for Reservation Room
            $roomstatus = RoomStatus::where('rooms_id','=', $postData["rooms_id"][$key])->first();
            if($roomstatus != null){
              $roomstatus->reservationdetail_id = $reservationdetail_id;
              $roomstatus->date = $this->convert_date($postData["tanggal"]);
              $roomstatus->status = 1;
              $roomstatus->users_id=$this->session->get('activeUser')["id"];
              $roomstatus->save();
            }
        }

        if($postData["status"]=="2"){// cancel
            return $response->withRedirect($this->router->pathFor('frontdesk-reservation'));
        } else {
            return $response->withRedirect($this->router->pathFor('frontdesk-deposit',["reservations_id"=>$reservations_id]));
        }


    }


    public function delete(Request $request, Response $response, Array $args)
    {
        $reservation = Reservation::find($args['id']);
        $reservation->delete();

        $reservationdetails_id = "";
        $reservationdetails_id = Reservationdetail::where('reservations_id', '=', $args['id'])->get();

        if($reservationdetails_id != null) {
            foreach ($reservationdetails_id as $reservationdetail_id) {
                $roomdelete = RoomStatus::where('reservationdetail_id', '=', $reservationdetail_id->id)->first();
                if($roomdelete != null){
                  $roomdelete->date = date('Y-m-d');
                  $roomdelete->reservationdetail_id = '';
                  $roomstatus->status = 1;
                  $roomdelete->users_id=$this->session->get('activeUser')["id"];
                  $roomdelete->save();
                }
            }
        }

        $detail = Reservationdetail::where('reservations_id', '=', $args['id'])->delete();

        $this->session->setFlash('success', 'Reservasi telah dihapus');
        return $response->withRedirect($this->router->pathFor('frontdesk-reservation'));
    }

    private function periodicCalc($periodicRateDate,$rate_){
        if($periodicRateDate->rate->markup_percent == 1){

            $rate_->room_only_price =  $rate_->room_only_price * (1 + ($periodicRateDate->rate->markup/100));
            $rate_->room_price =  $rate_->room_only_price + $rate_->breakfast_price;
        } else {
            $rate_->room_only_price += $periodicRateDate->rate->markup;
            $rate_->room_price =  $rate_->room_only_price + $rate_->breakfast_price;
        }

        if($periodicRateDate->rate->disc_percent == 1){
            $rate_->room_only_price =  $rate_->room_only_price * (1 - ($periodicRateDate->rate->disc/100));
            $rate_->room_price =  $rate_->room_only_price + $rate_->breakfast_price;
        } else {

            $rate_->room_only_price -= $periodicRateDate->rate->disc;
            $rate_->room_price =  $rate_->room_only_price + $rate_->breakfast_price;
        }

        return $rate_;
    }

    private function convert_date($date){
        $exp = explode('-', $date);
        if (count($exp)==3) {
            $date = $exp[2].'-'.$exp[1].'-'.$exp[0];
        }
        return $date;
    }
}
