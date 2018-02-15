<?php

namespace App\Extension\League\Plates;

use League\Plates\Engine as PlatesEngine;
use League\Plates\Extension\ExtensionInterface;
use Illuminate\Database\Capsule\Manager as DB;
use App\Model\Reservation;
use App\Model\Reservationdetail;

class ReservationChartExtension implements ExtensionInterface
{
    private $dates = [];

    public function __construct()
    {
    }

    public function register(PlatesEngine $engine)
    {
        $engine->registerFunction('resvDetailTd', [$this, 'td']);
        $engine->registerFunction('resvDates', [$this, 'getDates']);
    }

    public function td($room_id, $date)
    {
        $reservationDetailTable = 'reservationdetails';
        $reservationTable = 'reservations';
        $guestTable = 'guests';

        $this->dates[] = $date;

        $reservationDetail = DB::table($reservationDetailTable)
                                ->join($reservationTable, $reservationDetailTable.'.reservations_id', '=', $reservationTable.'.id')
                                ->join($guestTable, $guestTable.'.id', '=', $reservationTable.'.guests_id')
                                ->select($reservationDetailTable.'.*', $guestTable.'.name AS guest_name', $reservationTable.'.checkout', $reservationTable.'.checkin', $reservationTable.'.guests_id')
                                ->where($reservationDetailTable.'.rooms_id', $room_id)
                                ->where($reservationTable.'.checkin', '<=', $date)
                                ->where($reservationTable.'.checkout', '>=', $date)
                                /*->where(function ($query) use ($reservationDetailTable, $reservationTable, $date) {
                                    $query->where($reservationTable.'.checkin', '>=', $date)
                                    ->orWhere($reservationTable.'.checkout', '<=', $date);
                                })*/
                                ->get();
        if ($reservationDetail->count() > 0) {
            $resvFirst = $reservationDetail->first();
            $nextDate = $this->dateOnly($resvFirst->checkout.' + 1 day');
            $lenght = $this->dateDiff($resvFirst->checkout, $resvFirst->checkin);
            return [
                'html' => '<td colspan="'. ($lenght * 2) .'" class="confirm">'.$resvFirst->guest_name.'</td>',
                'resvStatus' => 1,
                'next_date' => $nextDate,
                'lenght' => $lenght,
            ];
        } else {
            $nextDate = date('Y-m-d', strtotime($date.' + 1 day'));
            //return '<td>-</td><td>1</td>';
            return [
                'html' => '<td>1</td>',
                'resvStatus' => 0,
                'next_date' => $nextDate,
                'lenght' => 1,
            ];
        }
    }

    public function getDates()
    {
        return $this->dates;
    }

    protected function dateOnly($date)
    {
        return date('Y-m-d', strtotime($date));
    }

    protected function dateDiff($date1, $date2)
    {
        $datetime1 = new \DateTime($this->dateOnly($date1));
        $datetime2 = new \DateTime($this->dateOnly($date2));
        $interval = $datetime1->diff($datetime2);
        return $interval->format('%a');
    }
}
