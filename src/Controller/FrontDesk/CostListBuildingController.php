<?php

namespace App\Controller\FrontDesk;

use App\Controller\Controller;
use Slim\Http\Request;
use Slim\Http\Response;
use App\Model\Reservation;
use App\Model\Reservationdetail;
use App\Model\Guest;
use App\Model\Addcharge;
use App\Model\CheckOut;
use App\Model\CheckOutDetail;
use App\Model\Negara;
use App\Model\Idtype;
use Illuminate\Database\Capsule\Manager as DB;

class CostListBuildingController extends Controller
{

	public function __invoke(Request $request, Response $response, Array $args)
	{
		$data["countries"]=Country::all();
        $data["idtypes"]=Idtype::all();

		$data['app_profile'] = $this->app_profile;
		$data['guests']=Guest::all();
		return $this->renderer->render($response, 'frontdesk/costlistbuilding', $data);
	}

	public function ajax_detail(Request $request, Response $response, Array $args)
	{
		function convert_date($date){
                    $exp = explode('-', $date);
                    if (count($exp)==3) {
                        $date = $exp[2].'-'.$exp[1].'-'.$exp[0];
                    }
                    return $date;
                }

		$data["reservations"]=Reservation::where("guests_id","=",$args["id"])->get()->toArray(); // reservasi tamu

		foreach($data["reservations"] as $key => $res){
			    $tanggal = substr($res['tanggal'],0,10); 
				$data['reservations'][$key]['tanggal'] = convert_date($tanggal);
			    $checkin = substr($res['checkin'],0,10); 
				$data['reservations'][$key]['checkin'] = convert_date($checkin);
				$checkout = substr($res['checkout'],0,10); 
				$data['reservations'][$key]['checkout'] = convert_date($checkout);
		}

		$guest=Guest::find($args["id"]); // Detail Tamu
		$data["guest"]=$guest->toArray();
		$data["guest"]["date_of_birth"]=convert_date($guest->date_of_birth);
		$data["guest"]["date_of_validation"]=convert_date($guest->date_of_validation);
		$guest=$guest->get();
		$data["guest"]["country"]=$guest[0]->country->nama;
		$data["guest"]["idtype"]=$guest[0]->idtype->name;

		//=Guest::find($args["id"])->toArray(); // Detail Tamu
// DATE_FORMAT(`tanggal`, '%d-%m-%Y')
		$data["addcharges"]=Addcharge::whereHas("reservation_detail",function($q) use ($args){ // biaya tambahan tamu
			$q->whereHas('reservation',function($q2)use ($args){
				$q2->where("guests_id","=",$args["id"]);
			});
		})->get()->toArray();
		foreach ($data['addcharges'] as $key => $value) {
			$tanggal=substr($value['tanggal'],0,10);
			$data['addcharges'][$key]['tanggal']=convert_date($tanggal);
		}

		return $response->write(json_encode((object)$data));

	}

}
