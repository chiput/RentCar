<?php

namespace App\Controller\FrontDesk\Report;

use Slim\Http\Request;
use Slim\Http\Response;
use App\Controller\Controller;
use App\Model\CheckOutDetail;
use Illuminate\Database\Capsule\Manager as DB;
use App\Model\Option;

class CheckoutReportController extends Controller
{
    public function filter(Request $request, Response $response, $args)
    {
        $data['submit_form'] = $this->router->pathFor('frontdesk-report-checkout');
        $data['customDataLyout'] = [
            'title' => 'Laporan Checkout'
        ];

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

        $checkoutTable = 'check_outs';
        $chekoutDetailTable = 'check_out_details';
        $reservationDetailTable = 'reservationdetails';
        $reservationTable = 'reservations';
        $guestTable = 'guests';
        $roomTable = 'rooms';

        $checkoutData = DB::table($checkoutTable)
                            ->select($checkoutTable.'.id', $checkoutTable.'.checkout_code', $checkoutTable.'.checkout_date',
                                $chekoutDetailTable.'.reservation_detail_id', $chekoutDetailTable.'.checkout_time',
                                $reservationDetailTable.'.rooms_id',
                                $reservationTable.'.nobukti',
                                $guestTable.'.name AS guest_name',
                                $roomTable.'.number AS room_number',$roomTable.'.level AS plat_number'
                            )
                            ->join($chekoutDetailTable, $chekoutDetailTable.'.check_out_id', '=', $checkoutTable.'.id')
                            ->join($reservationDetailTable, $chekoutDetailTable.'.reservation_detail_id', '=', $reservationDetailTable.'.id')
                            ->join($reservationTable, $reservationDetailTable.'.reservations_id', '=', $reservationTable.'.id')
                            ->join($roomTable, $reservationDetailTable.'.rooms_id', '=', $roomTable.'.id')
                            ->join($guestTable, $guestTable.'.id', '=', $reservationTable.'.guests_id')
                            ->whereBetween('checkout_time', array($start,$end))
                            ->get();
        $data['checkouts'] = $checkoutData;

        ///// get option ///
        $opt = Option::all();
        $Options=[];
        foreach ($opt as $value) {
            $Options[$value->name] = $value->value;
        }
        $data['options'] = $Options;
        ///// end get option ///

        return $this->renderer->render($response, 'frontdesk/reports/checkout', $data);
    }
}
