<?php

namespace App\Controller\FrontDesk;

use Slim\Http\Request;
use Slim\Http\Response;
use App\Controller\Controller;
use App\Model\Guest;
use App\Model\Negara;
use App\Model\Company;
use App\Model\Idtype;
use App\Model\RoomType;
use App\Model\Building;
use App\Model\Reservation;
use App\Model\Reservationdetail;
use App\Model\Option;
use Illuminate\Database\Capsule\Manager as DB;
use Harmoni\LogAuditing\LogAuditingProvider;

class GuestController extends Controller
{
    public function __invoke(Request $request, Response $response, Array $args)
    {
        $data['guests'] = Guest::orderBy('id','desc')->get();
        $data['message'] = $this->session->getFlash('success');
        return $this->renderer->render($response, 'frontdesk/guest', $data);
    }

    public function form(Request $request, Response $response, Array $args)
    {
        $data = [];
        $data["countries"]=Negara::all();
        $data["idtypes"]=Idtype::all();
        $data["companies"]=Company::all();
        // if update
        if (isset($args['id'])) $data['guest'] = Guest::find($args['id']);

        // if error
        $data['errors'] = $this->session->getFlash('error_messages');
        if (!is_null($data['errors'])) {
            $data['guest'] = (object) $this->session->getFlash('post_data');
        }

        return $this->renderer->render($response, 'frontdesk/guest-form', $data);
    }

    public function save(Request $request, Response $response, Array $args)
    {
        $postData = $request->getParsedBody();

        function convert_date($date){
            $exp = explode('-', $date);
            if (count($exp)==3) {
                $date = $exp[2].'-'.$exp[1].'-'.$exp[0];
            }
            return $date;
        }
        // validation
        $this->validation->validate([
            'name|Nama Tamu' => [$postData['name'], 'required'],
            'address|Alamat Tamu' => [$postData['address'], 'required'],
            'country_id|Negara' => [$postData['country_id'], 'required'],
            'date_of_birth|Tanggal Lahir' => [convert_date($postData['date_of_birth']), 'required'],
            'date_of_validation|Tanggal Berlaku ' => [convert_date($postData['date_of_validation']), 'required'],
            'idcode|Nomor Identitas' => [$postData['idcode'], 'required'],
        ]);
        if (!$this->validation->passes()) {

            $this->session->setFlash('error_messages', $this->validation->errors()->all());
            $this->session->setFlash('post_data', $postData);

            if ($postData['id'] == '') {
                return $response->withRedirect($this->router->pathFor('frontdesk-guest-new'));
            } else {
                return $response->withRedirect($this->router->pathFor('frontdesk-guest-update',['id' => $postData['id']]));
            }
        }

        // insert
        if ($postData['id'] == '') {
            $this->session->setFlash('success', 'Data Pelanggan ditambahkan');
            $guest = new Guest();
        } else {
        // update
            $this->session->setFlash('success', 'Data Pelanggan diperbarui');
            $guest = Guest::find($postData['id']);
        }
        $guest->name = $postData['name'];
        $guest->is_active = $postData['is_active'];
        $guest->address=$postData["address"];
        $guest->state=$postData["state"];
        $guest->country_id=$postData["country_id"];
        $guest->city=$postData["city"];
        $guest->zipcode=$postData["zipcode"];
        $guest->phone=$postData["phone"];
        $guest->fax=$postData["fax"];
        $guest->email=$postData["email"];
        $guest->idcode=$postData["idcode"];
        $guest->company_id=$postData["company_id"];
        $guest->sex=$postData["sex"];
        $guest->date_of_birth=convert_date(@$postData["date_of_birth"])==""?date('Y-m-d'):convert_date($postData["date_of_birth"]);
        $guest->date_of_validation=convert_date(@$postData["date_of_validation"])==""?date('Y-m-d'):convert_date($postData["date_of_validation"]);
        $guest->idtype_id=$postData["idtype_id"];
        $guest->idcode=$postData["idcode"];
        $guest->is_blacklist=(@$postData["is_blacklist"]==""?0:1);
        $guest->users_id=$this->session->get('activeUser')["id"];
        $original = $guest->getOriginal();
        $guest->save();

        $log = LogAuditingProvider::logactivity($guest,$original,'guests');

        return $response->withRedirect($this->router->pathFor('frontdesk-guest'));
    }

    public function delete(Request $request, Response $response, Array $args)
    {
        $guest = Guest::find($args['id']);
        $guest->delete();
        $this->session->setFlash('success', 'Data Pelanggan telah dihapus');
        return $response->withRedirect($this->router->pathFor('frontdesk-guest'));
    }

    public function guestlist(Request $request, Response $response, Array $args)
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
            $date=convert_date($postData["date"]);
        }else{
            $date=date("Y-m-d");
        }

        $data['date']=$date;

        $data["room_types"]=RoomType::all();
        $data["buildings"]=Building::all();

        $data['guests']=Reservationdetail::join('rooms','reservationdetails.rooms_id','=','rooms.id')
                        ->join('room_types','rooms.room_type_id','=','room_types.id')
                        ->join('buildings','rooms.buildings_id','=','buildings.id')
                        ->join('reservations','reservationdetails.reservations_id','=','reservations.id')
                        ->join('guests','reservations.guests_id','=','guests.id')
                        ->join('negara','guests.country_id','=','negara.id')
                        ->select('reservations.checkout as checkout','rooms.number as number','room_types.name as type','buildings.name as building','guests.name as name','reservations.remarks as remarks','negara.nama as country')
                        ->whereRaw("? between checkin and checkout",[$date])
                        ->whereNotNull('reservationdetails.checkin_at')
                        ->where('reservationdetails.checkout_at','=',NULL)
                        ->get();

        if($data['room_type_id'] != ''){
            $data['guests'] = Reservationdetail::join('rooms','reservationdetails.rooms_id','=','rooms.id')
                        ->join('room_types','rooms.room_type_id','=','room_types.id')
                        ->join('buildings','rooms.buildings_id','=','buildings.id')
                        ->join('reservations','reservationdetails.reservations_id','=','reservations.id')
                        ->join('guests','reservations.guests_id','=','guests.id')
                        ->join('negara','guests.country_id','=','negara.id')
                        ->select('reservations.checkout as checkout','rooms.number as number','room_types.name as type','buildings.name as building','guests.name as name','reservations.remarks as remarks','negara.nama as country')
                        ->whereRaw("? between checkin and checkout",[$date])
                        ->whereNotNull('reservationdetails.checkin_at')
                        ->where('reservationdetails.checkout_at','=',NULL)
                        ->where('rooms.room_type_id','=',$data['room_type_id'])
                        ->get();
        }
        if($data['building_id'] != ''){
            $data['guests'] = Reservationdetail::join('rooms','reservationdetails.rooms_id','=','rooms.id')
                            ->join('room_types','rooms.room_type_id','=','room_types.id')
                            ->join('buildings','rooms.buildings_id','=','buildings.id')
                            ->join('reservations','reservationdetails.reservations_id','=','reservations.id')
                            ->join('guests','reservations.guests_id','=','guests.id')
                            ->join('negara','guests.country_id','=','negara.id')
                            ->select('reservations.checkout as checkout','rooms.number as number','room_types.name as type','buildings.name as building','guests.name as name','reservations.remarks as remarks','negara.nama as country')
                            ->whereRaw("? between checkin and checkout",[$date])
                            ->whereNotNull('reservationdetails.checkin_at')
                            ->where('reservationdetails.checkout_at','=',NULL)
                            ->where('rooms.buildings_id','=',$data['building_id'])
                            ->get();
        }
        if($data['building_id'] != '' && $data['room_type_id'] != ''){
            $data['guests'] = Reservationdetail::join('rooms','reservationdetails.rooms_id','=','rooms.id')
                            ->join('room_types','rooms.room_type_id','=','room_types.id')
                            ->join('buildings','rooms.buildings_id','=','buildings.id')
                            ->join('reservations','reservationdetails.reservations_id','=','reservations.id')
                            ->join('guests','reservations.guests_id','=','guests.id')
                            ->join('negara','guests.country_id','=','negara.id')
                            ->select('reservations.checkout as checkout','rooms.number as number','room_types.name as type','buildings.name as building','guests.name as name','reservations.remarks as remarks','negara.nama as country')
                            ->whereRaw("? between checkin and checkout",[$date])
                            ->whereNotNull('reservationdetails.checkin_at')
                            ->where('reservationdetails.checkout_at','=',NULL)
                            ->where('rooms.room_type_id','=',$data['room_type_id'])
                            ->where('rooms.buildings_id','=',$data['building_id'])
                            ->get();
        }

        return $this->renderer->render($response, 'frontdesk/guest-list', $data);
    }

    public function guestlistreport(Request $request, Response $response, Array $args)
    {
        $postData = $request->getParsedBody();
        $data['room_type_id']=@$postData["room_type_id"];
        $data['building_id']=@$postData["building_id"];

        if($request->isPost()){
            $date=$postData["date"];
        }else{
            $date=date("Y-m-d");
        }

        $data['date']=$date;

        $data["room_types"]=RoomType::all();
        $data["buildings"]=Building::all();

        ///// get option ///
        $opt = Option::all();
        $Options=[];
        foreach ($opt as $value) {
            $Options[$value->name] = $value->value;
        }
        $data['options'] = $Options;

        $data['guests']=Reservationdetail::join('rooms','reservationdetails.rooms_id','=','rooms.id')
                        ->join('room_types','rooms.room_type_id','=','room_types.id')
                        ->join('buildings','rooms.buildings_id','=','buildings.id')
                        ->join('reservations','reservationdetails.reservations_id','=','reservations.id')
                        //->join('agents','reservations.agent_id','=','agents.id')
                        ->join('guests','reservations.guests_id','=','guests.id')
                        ->join('negara','guests.country_id','=','negara.id')
                        ->select('reservations.agent_id as res','reservations.checkin as checkin','reservations.checkout as checkout','rooms.number as number','room_types.name as type','buildings.name as building','guests.name as name','reservations.remarks as remarks','negara.nama as country')
                        ->whereRaw("? between checkin and checkout",[$date])
                        ->whereNotNull('reservationdetails.checkin_at')
                        ->where('reservationdetails.checkout_at','=',NULL)
                        ->get();

        if($data['room_type_id'] != ''){
            $data['guests'] = Reservationdetail::join('rooms','reservationdetails.rooms_id','=','rooms.id')
                        ->join('room_types','rooms.room_type_id','=','room_types.id')
                        ->join('buildings','rooms.buildings_id','=','buildings.id')
                        ->join('reservations','reservationdetails.reservations_id','=','reservations.id')
                        //->join('agents','reservations.agent_id','=','agents.id')
                        ->join('guests','reservations.guests_id','=','guests.id')
                        ->join('negara','guests.country_id','=','negara.id')
                        ->select('reservations.agent_id as res','reservations.checkin as checkin','reservations.checkout as checkout','rooms.number as number','room_types.name as type','buildings.name as building','guests.name as name','reservations.remarks as remarks','negara.nama as country')
                        ->whereRaw("? between checkin and checkout",[$date])
                        ->whereNotNull('reservationdetails.checkin_at')
                        ->where('reservationdetails.checkout_at','=',NULL)
                        ->where('rooms.room_type_id','=',$data['room_type_id'])
                        ->get();
        }
        if($data['building_id'] != ''){
            $data['guests'] = Reservationdetail::join('rooms','reservationdetails.rooms_id','=','rooms.id')
                            ->join('room_types','rooms.room_type_id','=','room_types.id')
                            ->join('buildings','rooms.buildings_id','=','buildings.id')
                            ->join('reservations','reservationdetails.reservations_id','=','reservations.id')
                            //->join('agents','reservations.agent_id','=','agents.id')
                            ->join('guests','reservations.guests_id','=','guests.id')
                            ->join('negara','guests.country_id','=','negara.id')
                            ->select('reservations.agent_id as res','reservations.checkin as checkin','reservations.checkout as checkout','rooms.number as number','room_types.name as type','buildings.name as building','guests.name as name','reservations.remarks as remarks','negara.nama as country')
                            ->whereRaw("? between checkin and checkout",[$date])
                            ->whereNotNull('reservationdetails.checkin_at')
                            ->where('reservationdetails.checkout_at','=',NULL)
                            ->where('rooms.buildings_id','=',$data['building_id'])
                            ->get();
        }
        if($data['building_id'] != '' && $data['room_type_id'] != ''){
            $data['guests'] = Reservationdetail::join('rooms','reservationdetails.rooms_id','=','rooms.id')
                            ->join('room_types','rooms.room_type_id','=','room_types.id')
                            ->join('buildings','rooms.buildings_id','=','buildings.id')
                            ->join('reservations','reservationdetails.reservations_id','=','reservations.id')
                            //->join('agents','reservations.agent_id','=','agents.id')
                            ->join('guests','reservations.guests_id','=','guests.id')
                            ->join('negara','guests.country_id','=','negara.id')
                            ->select('reservations.agent_id as res','reservations.checkin as checkin','reservations.checkout as checkout','rooms.number as number','room_types.name as type','buildings.name as building','guests.name as name','reservations.remarks as remarks','negara.nama as country')
                            ->whereRaw("? between checkin and checkout",[$date])
                            ->whereNotNull('reservationdetails.checkin_at')
                            ->where('reservationdetails.checkout_at','=',NULL)
                            ->where('rooms.room_type_id','=',$data['room_type_id'])
                            ->where('rooms.buildings_id','=',$data['building_id'])
                            ->get();
        }

        return $this->renderer->render($response, 'frontdesk/reports/guest-in-house', $data);
    }
    public function arrivalguest(Request $request, Response $response, Array $args)
    {

        function convert_date($date){
            $exp = explode('-', $date);
            if (count($exp)==3) {
                $date = $exp[2].'-'.$exp[1].'-'.$exp[0];
            }
            return $date;
        }

        $postData = $request->getParsedBody();

        if($request->isPost()){
            $date=convert_date($postData["date"]);
        }else{
            $date=date("Y-m-d");
        }
        $data['tanggal'] = $date;

        $data['arrivals'] = Reservationdetail::join('rooms','reservationdetails.rooms_id','=','rooms.id')
                        ->join('room_types','rooms.room_type_id','=','room_types.id')
                        ->join('buildings','rooms.buildings_id','=','buildings.id')
                        ->join('reservations','reservationdetails.reservations_id','=','reservations.id')
                        //->join('agents','reservations.agent_id','=','agents.id')
                        ->join('guests','reservations.guests_id','=','guests.id')
                        ->join('negara','guests.country_id','=','negara.id')
                        ->select('reservations.agent_id as res','reservations.checkin as checkin','reservations.checkout as checkout','rooms.number as number','room_types.name as type','buildings.name as building','guests.name as name','reservations.remarks as remarks','negara.nama as country','reservationdetails.checkin_at as checkin_at')
                        ->where(DB::raw('DATE(checkin)'),'=',$date)
                        ->get();


        // Reservationdetail::join('reservations','reservationdetails.reservations_id','=','reservations.id')

        //                                 ->select('reservationdetails.*','reservations.nobukti as nobuks','reservations.remarks as desc')
        //                                 ->get();

        return $this->renderer->render($response, 'frontdesk/arrival-guest', $data);
    }

    public function departureguest(Request $request, Response $response, Array $args)
    {
        $postData = $request->getParsedBody();

        function convert_date($date){
            $exp = explode('-', $date);
            if (count($exp)==3) {
                $date = $exp[2].'-'.$exp[1].'-'.$exp[0];
            }
            return $date;
        }

        if($request->isPost()){
            $date=convert_date($postData["date"]);
        }else{
            $date=date("Y-m-d");
        }
        $data['tanggal'] = $date;

        $data['departures'] = Reservationdetail::join('rooms','reservationdetails.rooms_id','=','rooms.id')
                        ->join('room_types','rooms.room_type_id','=','room_types.id')
                        ->join('buildings','rooms.buildings_id','=','buildings.id')
                        ->join('reservations','reservationdetails.reservations_id','=','reservations.id')
                        //->join('agents','reservations.agent_id','=','agents.id')
                        ->join('guests','reservations.guests_id','=','guests.id')
                        ->join('negara','guests.country_id','=','negara.id')
                        ->select('reservations.agent_id as res','reservations.checkin as checkin','reservations.checkout as checkout','rooms.number as number','room_types.name as type','buildings.name as building','guests.name as name','reservations.remarks as remarks','negara.nama as country','reservationdetails.checkout_at as checkout_at')
                        ->where(DB::raw('DATE(checkout)'),'=',$date)
                        ->get();


        // Reservationdetail::join('reservations','reservationdetails.reservations_id','=','reservations.id')
        //                                 ->where('checkout_at','LIKE','%'.$date.'%')
        //                                 ->select('reservationdetails.*','reservations.nobukti as nobuks','reservations.remarks as desc')
        //                                 ->get();

        return $this->renderer->render($response, 'frontdesk/departure-guest', $data);
    }


    public function guestlistarrival(Request $request, Response $response, Array $args)
    {

        $date=$args['date'];

        $data['date']=$date;

        ///// get option ///
        $opt = Option::all();
        $Options=[];
        foreach ($opt as $value) {
            $Options[$value->name] = $value->value;
        }
        $data['options'] = $Options;
        if($args['id']==1){
            $data['guests']=Reservationdetail::join('rooms','reservationdetails.rooms_id','=','rooms.id')
                        ->join('room_types','rooms.room_type_id','=','room_types.id')
                        ->join('buildings','rooms.buildings_id','=','buildings.id')
                        ->join('reservations','reservationdetails.reservations_id','=','reservations.id')
                        //->join('agents','reservations.agent_id','=','agents.id')
                        ->join('guests','reservations.guests_id','=','guests.id')
                        ->join('negara','guests.country_id','=','negara.id')
                        ->select('reservations.agent_id as res','reservations.checkin as checkin','reservations.checkout as checkout','rooms.number as number','room_types.name as type','buildings.name as building','guests.name as name','reservations.remarks as remarks','negara.nama as country')
                        ->where('checkin','LIKE','%'.$date.'%')
                        ->get();
        }
        if($args['id']==2){
            $data['guests']=Reservationdetail::join('rooms','reservationdetails.rooms_id','=','rooms.id')
                        ->join('room_types','rooms.room_type_id','=','room_types.id')
                        ->join('buildings','rooms.buildings_id','=','buildings.id')
                        ->join('reservations','reservationdetails.reservations_id','=','reservations.id')
                        //->join('agents','reservations.agent_id','=','agents.id')
                        ->join('guests','reservations.guests_id','=','guests.id')
                        ->join('negara','guests.country_id','=','negara.id')
                        ->select('reservations.agent_id as res','reservations.checkin as checkin','reservations.checkout as checkout','rooms.number as number','room_types.name as type','buildings.name as building','guests.name as name','reservations.remarks as remarks','negara.nama as country')
                        ->where('checkout','LIKE','%'.$date.'%')
                        ->get();
        }

        return $this->renderer->render($response, 'frontdesk/reports/guest-arrival-departure', $data);
    }
}
