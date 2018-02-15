<?php

namespace App\Controller\FrontDesk\Report;

use Slim\Http\Request;
use Slim\Http\Response;
use App\Controller\Controller;
use App\Model\Reservation;
use App\Model\Reservationdetail;
use App\Model\CheckOut;
use App\Model\CheckOutDetail;
use App\Model\Deposit;
use Kulkul\Reservation\RoomRate;
use App\Model\Option;

class GuestActivityController extends Controller
{
    public function filter(Request $request, Response $response, $args)
    {
        $data['submit_form'] = $this->router->pathFor('frontdesk-report-guest-activity-display');
        $data['customDataLyout'] = [
            'title' => 'Laporan Aktivitas Tamu'
        ];

        return $this->renderer->render($response, 'frontdesk/reports/guest-activity-filter', $data);
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

        $data['reservationdetails'] = Reservationdetail::whereHas("reservation",function($q) use ($postData){
            $q->where('checkin','<=',convert_date($postData['end']))
            ->where('checkout','>=',convert_date($postData['start']));
        })
        ->whereNotNull('checkin_at')
        ->get();

        //echo "<pre>".print_r($data['reservation'],true)."</pre>";

        //$rates = new RoomRate($postData['start'], $postData['end']);

        //echo "<pre>".print_r($rates->getRoomRates(),true)."</pre>";
        
        //return false;

        ///// get option ///
        $opt = Option::all();
        $Options=[];
        foreach ($opt as $value) {
            $Options[$value->name] = $value->value;
        }
        $data['options'] = $Options;
        ///// end get option ///
        
        return $this->renderer->render($response, 'frontdesk/reports/guest-activity-report', $data);
    }
}
