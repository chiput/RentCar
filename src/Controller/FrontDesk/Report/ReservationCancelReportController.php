<?php

namespace App\Controller\FrontDesk\Report;

use Slim\Http\Request;
use Slim\Http\Response;
use App\Controller\Controller;
use App\Model\Reservation;
use App\Model\Reservationdetail;
use App\Model\Option;

class ReservationCancelReportController extends Controller
{
    public function filter(Request $request, Response $response, $args)
    {
        $data['submit_form'] = $this->router->pathFor('frontdesk-report-reservation-cancel-display');
        return $this->renderer->render($response, 'frontdesk/reports/reservation-cancel-filter', $data);
    }

    public function __invoke(Request $request, Response $response, $args)
    {
        $postData = $request->getParsedBody();
        $data['range'] = $postData;
        $postData['start'] = $this->convert_date($postData['start']);
        $postData['end'] = $this->convert_date($postData['end']);
        $data['reservations'] = Reservation::whereBetween('canceldate', array_values($postData))
                                ->where('status','=',2)
                                ->get();

        ///// get option ///
        $opt = Option::all();
        $Options=[];
        foreach ($opt as $value) {
            $Options[$value->name] = $value->value;
        }
        $data['options'] = $Options;
        ///// end get option ///
        
        return $this->renderer->render($response, 'frontdesk/reports/reservation-cancel-report', $data);
    }

    function convert_date($date){
        $exp = explode('-', $date);
        if (count($exp)==3) {
            $date = $exp[2].'-'.$exp[1].'-'.$exp[0];
        }
        return $date;
    }
}
