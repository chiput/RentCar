<?php

namespace App\Controller\FrontDesk;

use Slim\Http\Request;
use Slim\Http\Response;
use Kulkul\Reservation\RoomRate;
use Kulkul\CodeGenerator\CheckinCode;
use App\Controller\Controller;
use App\Model\Guest;
use App\Model\Reservation;
use App\Model\Idtype;
use App\Model\Company;
use App\Model\Negara;
use App\Model\Reservationdetail;
use App\Model\RoomStatus;
use App\Model\Creditcard;

class CheckinGroupController extends Controller
{
    public function __invoke(Request $request, Response $response, Array $args)
    {


        $data['guests'] = Guest::all();
        $data['checkins'] = Reservationdetail::where('checkin_code', '!=',  null)
                            ->where('checkout_at','=',null)
                            ->orderBy('id', 'desc')
                            // ->groupBy('reservations_id')
                            ->get(); //yang belum checkout
        $data['checkins_checkedout'] = Reservationdetail::where('checkin_code', '!=', null)
                            ->whereNotNull('checkout_at')
                            ->orderBy('id', 'desc')
                            // ->groupBy('reservations_id', 'checkin_code','id')
                            ->get(); //yang sudah checkedout
        $data['modal_reservations'] = Reservation::whereHas('details',function($q){
            $q->where('checkin_at','=',null);
        })->where('status','=','0')
        ->orderBy('id','desc')->get(); // yang belum checkin
        $data['message'] = $this->session->getFlash('success');
        return $this->renderer->render($response, 'frontdesk/checkin-group', $data);
    }

    public function form(Request $request, Response $response, Array $args)
    {

        $data = [];
        $data["countries"]=Negara::all();
        $data["idtypes"]=Idtype::all();
        $data["companies"]=Company::all();

        if (isset($args['reservation_detail_id']))
        {
            $data['checkin'] = Reservationdetail::find($args['reservation_detail_id']);
        }

        $data['reservation_details'] = Reservationdetail::where('reservations_id', $args['reservation_id'])->get();
        $data['reservation'] = Reservation::find($args['reservation_id']);
        $data['creditcards'] = Creditcard::all();
        $data['checkin_code'] = CheckinCode::generate();
        $data['guest'] = $data['reservation']->guest;
        $data['guest']->date_of_birth = $this->convert_date($data['guest']->date_of_birth);
        $data['guest']->date_of_validation = $this->convert_date($data['guest']->date_of_validation);
        $data['args'] = $args;

        return $this->renderer->render($response, 'frontdesk/checkingroup-add', $data);
    }

    public function save(Request $request, Response $response, Array $args)
    {


        $postData = $request->getParsedBody();

        $checkinCode = CheckinCode::generate();

        $checkinnya = Reservation::where(['id' => $postData['reservation_id']])->update(['remarks' => $postData['remarks']]);

        foreach ($postData['reservation_detail_id'] as $reservation_detail_id) {
            $checkin = Reservationdetail::find($reservation_detail_id);
            // $checkin->users_id_edit = $this->session->get('activeUser')["id"];

            $checkin->checkin_code = $postData['checkin_code'];
            $checkin->checkin_at = $this->convert_date($postData['date_checkin']).' '.$postData['time_checkin'];
            // $checkin->adult = $postData['adult'];
            // $checkin->children = $postData['children'];
            $checkin->creditcard_id = ($postData['creditcard_id']==''?0:$postData['creditcard_id']);
            $checkin->creditcard_number = ($postData['creditcard_number']==''?0:$postData['creditcard_number']);
            $checkin->note = ($postData['internal_note']==''?'':$postData['internal_note']);
            $checkin->users_id = $this->session->get('activeUser')["id"];
            $checkin->is_compliment = (@$postData['is_compliment']==""?0:1);
            if (isset($postData['is_compliment']) == 1){
                $checkin->price = $checkin->price - $checkin->price;
                $checkin->priceExtra = $checkin->priceExtra - $checkin->priceExtra;
            } else {
                $checkin->price = $checkin->price_old;
                $checkin->priceExtra = $checkin->priceExtra_old;
            }
            // if ($data['reservation']->guest) {
                //foreach ($postData['id_guest'] as $guests) {
                    // $guest = Guest::where('id', '=', $checkin->guest_id)->first();
                    $guest = Guest::find($postData['id_guest']);

                    $guest->name = $postData['name'];
                    $guest->sex = $postData['guests_sex'];
                    $guest->email = $postData['email'];
                    $guest->address = $postData['address'];
                    $guest->city = $postData['city'];
                    $guest->country_id = $postData['country'];
                    $guest->zipcode = $postData['zipcode'];
                    $guest->phone = $postData['phone'];
                    $guest->company_id = $postData['company'];
                    $guest->date_of_birth = $this->convert_date($postData['date_of_birth']);
                    $guest->idtype_id = $postData['idtype'];
                    $guest->idcode = $postData['idcode'];
                    $guest->date_of_validation = $this->convert_date($postData['date_of_validation']);

                    $guest->save();
                // }
            // }
            $checkin->save();

            // input Occupied Clean
            $roomstatus = RoomStatus::where('rooms_id', '=', $checkin->rooms_id)->first();
            if($roomstatus != null){
                $roomstatus->date = $this->convert_date($postData['date_checkin']);
                $roomstatus->status = 4;
                $roomstatus->save();
            }

        }

        return $response->withRedirect($this->router->pathFor('frondesk-checkingroup'));
    }

    public function delete(Request $request, Response $response, Array $args)
    {
        $id = $args['id'];
        $resDetail = Reservationdetail::find($id);
        if($resDetail != null){
            $resDetail->checkin_at = null;
            $resDetail->checkout_at = null;
            $resDetail->checkin_code = null;
            $resDetail->save();

            // input Vaccant Ready
            $roomstatus = RoomStatus::where('reservationdetail_id', $resDetail->id)->first();
            if($roomstatus != null){
                $roomstatus->status = 1;
                $roomstatus->save();
            }
        }

        return $response->withRedirect($this->router->pathFor('frondesk-checkingroup'));
    }

    private function convert_date($date){
        $exp = explode('-', $date);
        $exp = array_reverse($exp);
        return implode('-',$exp);
        //
        // if (count($exp)==3) {
        //     $date = $exp[2].'-'.$exp[1].'-'.$exp[0];
        // }
        // return $date;
    }
}
