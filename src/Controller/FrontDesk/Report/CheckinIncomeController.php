<?php

namespace App\Controller\FrontDesk\Report;

use Slim\Http\Request;
use Slim\Http\Response;
use App\Controller\Controller;
use Illuminate\Database\Capsule\Manager as DB;
use App\Model\Option;

class CheckinIncomeController extends Controller
{
    public function filter(Request $request, Response $response, $args)
    {
        $data['submit_form'] = $this->router->pathFor('frontdesk-report-checkin-income-display');
        $data['customDataLyout'] = [
            'title' => 'Laporan Pendapatan Check In'
        ];

        return $this->renderer->render($response, 'frontdesk/reports/reservation-filter', $data);
    }

    public function __invoke(Request $request, Response $response, $args)
    {
        $postData = $request->getParsedBody();

        $depositTable = 'deposits';
        $reservationDetailTable = 'reservationdetails';
        $reservationTable = 'reservations';
        $guestTable = 'guests';
        //$checkoutDetailsTable = 'check_out_details';
        $addChargesTable = 'addcharges';
        $roomTable = 'rooms';

        $start = $this->convert_date($postData['start']);
        $end = $this->convert_date($postData['end']);

        $data['range'] = $postData;
        $data['dates'] = $this->createDateRangeArray($start, $end);

        /* deposit */
        $deposit = function () use ($data, $depositTable, $reservationTable, $guestTable) {
            $deposit = [];
            foreach ($data['dates'] as $date) {
                $dp = DB::table($depositTable)->select('nominal', $guestTable.'.name AS guest_name')
                            ->join($reservationTable, $reservationTable.'.id', '=', $depositTable.'.reservations_id')
                            ->join($guestTable, $guestTable.'.id', '=', $reservationTable.'.guests_id')
                            ->where($depositTable.'.tanggal', $date)->get();
                if ($dp->count() > 0) {
                    $deposit[$date] = $dp;
                }
            }
            return $deposit;
        };
        $data['deposits'] = $deposit();

        // /* checkout */
        // $checkout = function () use (
        //                             $data,
        //                             $checkoutDetailsTable,
        //                             $depositTable,
        //                             $reservationTable,
        //                             $guestTable,
        //                             $reservationDetailTable,
        //                             $roomTable,
        //                             $addChargesTable) {
        //     $checkout = [];
        //     foreach ($data['dates'] as $date) {
        //         $co = DB::table($checkoutDetailsTable)
        //                 ->select($roomTable.'.number AS room_number',
        //                     $reservationDetailTable.'.price AS room_price',
        //                     $addChargesTable.'.ntotal AS additional_charge',
        //                     $guestTable.'.name AS guest_name')
        //                 ->join($reservationDetailTable, $checkoutDetailsTable.'.reservation_detail_id', '=', $reservationDetailTable.'.id')
        //                 ->join($roomTable, $roomTable.'.id', '=', $reservationDetailTable.'.rooms_id')
        //                 ->join($reservationTable, $reservationDetailTable.'.reservations_id', '=', $reservationTable.'.id')
        //                 ->join($guestTable, $guestTable.'.id', '=', $reservationTable.'.guests_id')
        //                 ->leftJoin($addChargesTable, $addChargesTable.'.reservationdetails_id',  $reservationDetailTable.'.id')
        //                 ->where($checkoutDetailsTable.'.checkout_time', 'LIKE', $date.'%')
        //                 ->get();
        //         if ($co->count() > 0) {
        //             $checkout[$date] = $co;
        //         }
        //     }
        //     return $checkout;
        // };
        // $data['checkouts'] = $checkout();


        ///// get option ///
        $opt = Option::all();
        $Options=[];
        foreach ($opt as $value) {
            $Options[$value->name] = $value->value;
        }
        $data['options'] = $Options;
        ///// end get option ///

        return $this->renderer->render($response, 'frontdesk/reports/checkin-income', $data);
    }

    protected function createDateRangeArray($strDateFrom,$strDateTo)
    {
        // takes two dates formatted as YYYY-MM-DD and creates an
        // inclusive array of the dates between the from and to dates.

        // could test validity of dates here but I'm already doing
        // that in the main script

        $aryRange=array();

        $iDateFrom=mktime(1,0,0,substr($strDateFrom,5,2),     substr($strDateFrom,8,2),substr($strDateFrom,0,4));
        $iDateTo=mktime(1,0,0,substr($strDateTo,5,2),     substr($strDateTo,8,2),substr($strDateTo,0,4));

        if ($iDateTo>=$iDateFrom)
        {
            array_push($aryRange,date('Y-m-d',$iDateFrom)); // first entry
            while ($iDateFrom<$iDateTo)
            {
                $iDateFrom+=86400; // add 24 hours
                array_push($aryRange,date('Y-m-d',$iDateFrom));
            }
        }
        return $aryRange;
    }

    private function convert_date($date){
        $exp = explode('-', $date);
        if (count($exp)==3) {
            $date = $exp[2].'-'.$exp[1].'-'.$exp[0];
        }
        return $date;
    }
}
