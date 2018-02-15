<?php

namespace App\Controller\FrontDesk\Report;

use Slim\Http\Request;
use Slim\Http\Response;
use App\Controller\Controller;
use App\Model\Reservation;
use App\Model\Reservationdetail;
use App\Model\Guest;
use App\Model\Addcharge;
use App\Model\Addchargedetail;
use App\Model\CheckOut;
use App\Model\CheckOutDetail;
use App\Model\Negara;
use App\Model\Idtype;
use App\Model\Option;
use Illuminate\Database\Capsule\Manager as DB;

class GuestHistoryController extends Controller
{
    public function filter(Request $request, Response $response, $args)
    {
        
        $data['customDataLyout'] = [
            'title' => 'Laporan Riwayat Tamu'
        ];

        $data['guests'] = Guest::all();
        return $this->renderer->render($response, 'frontdesk/reports/guest-history-filter', $data);
    }

    public function __invoke(Request $request, Response $response, $args)
    {
        $postData = $request->getParsedBody();

        $data["reservations"]=Reservation::where("guests_id","=",$args["id"])->get(); // reservasi tamu

        $guest=Guest::find($args["id"]); // Detail Tamu
        $data["guest"]=$guest->toArray();
        $guest=$guest->get();
        $data["guest"]["country"]=$guest[0]->country->nama;
        $data["guest"]["idtype"]=$guest[0]->idtype->name;
        $data["guest"] = (object)$data["guest"];
        //=Guest::find($args["id"])->toArray(); // Detail Tamu

        $data["addcharges"]=Addcharge::whereHas("reservation_detail",function($q) use ($args){ // biaya tambahan tamu
            $q->whereHas('reservation',function($q2) use ($args){
                $q2->where("guests_id","=",$args["id"]);
            });
        })->get();

        ///// get option ///
        $opt = Option::all();
        $Options=[];
        foreach ($opt as $value) {
            $Options[$value->name] = $value->value;
        }
        $data['options'] = $Options;
        ///// end get option ///

        return $this->renderer->render($response, 'frontdesk/reports/guest-history-report', $data);
    }
}
