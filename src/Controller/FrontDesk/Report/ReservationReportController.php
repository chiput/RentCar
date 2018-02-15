<?php

namespace App\Controller\FrontDesk\Report;

use Slim\Http\Request;
use Slim\Http\Response;
use App\Controller\Controller;
use App\Model\Reservation;
use App\Model\Reservationdetail;
use App\Model\Option;

class ReservationReportController extends Controller
{
    public function filter(Request $request, Response $response, $args)
    {
        $data['submit_form'] = $this->router->pathFor('frontdesk-report-reservation');

        return $this->renderer->render($response, 'frontdesk/reports/reservation-filter', $data);
    }

    public function display(Request $request, Response $response, $args)
    {

          function convert_date($date){
                    $exp = explode('-', $date);
                    if (count($exp)==3) {
                        $date = $exp[2].'-'.$exp[1].'-'.$exp[0];
                    }
                    return $date;
                }
        $postData = $request->getParsedBody();

        $data['range'] = $postData;

        $start = convert_date($data['range']['start']);
        $end = convert_date($data['range']['end']);

        $data['reservations'] = Reservation::whereBetween('tanggal', array($start,$end))
                                    ->get();

        $reservationIds = $data['reservations']->pluck('id');
        //echo "<pre>".$reservationIds."</pre>";
        //return false;
        $data['reservationDetails'] = ReservationDetail::whereIn('reservations_id', $reservationIds)->get();
        //echo "<pre>".print_r($data['reservationDetails'],true)."</pre>";
        ///// get option ///
        $opt = Option::all();
        $Options=[];
        foreach ($opt as $value) {
            $Options[$value->name] = $value->value;
        }
        $data['options'] = $Options;
        ///// end get option ///                                        ->get();

        return $this->renderer->render($response, 'frontdesk/reports/reservation', $data);
    }

  
}
