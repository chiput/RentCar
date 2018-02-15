<?php

namespace Kulkul\Reservation;

use Illuminate\Database\Capsule\Manager as DB;
use App\Model\Room;
use App\Model\RoomRate as RoomRateModel;
use App\Model\DayName;
use App\Model\RoomType;

class RoomRate
{
    protected $checkin;
    protected $checkout;

    public function __construct($checkin, $checkout)
    {
        $this->checkin = $checkin;
        $this->checkout = $checkout;
    }

    public function getRoomRates()
    {
        $dates = $this->dates();

        $roomTable = 'rooms';
        $roomRateTable = 'room_rates';
        $roomDayName = 'day_names';
        $roomTypeTable = 'room_types';
        $bedTypeTable = 'bed_types';

        foreach ($dates as $key => $date) {
            $dateDayNumber = date('w', strtotime($date));
            $roomRatesSubQuery[$key] = DB::table($roomTable)
                            ->join($roomTypeTable, "{$roomTypeTable}.id", '=', "{$roomTable}.room_type_id")
                            //->join($bedTypeTable, "{$bedTypeTable}.id", '=', "{$roomTable}.bed_type_id")
                            ->join($roomRateTable, "{$roomTable}.id", '=', "{$roomRateTable}.room_id")
                            ->join($roomDayName, "{$roomDayName}.id", '=', "{$roomRateTable}.dayname_id")
                            ->select(
                                "{$roomTable}.id",
                                "{$roomTable}.number",
                                "{$roomTypeTable}.id AS type_id",
                                "{$roomTypeTable}.name AS room_type_name",
                                "{$roomTable}.level AS level",
                                //"{$bedTypeTable}.id AS bed_type_id",
                                //"{$bedTypeTable}.name AS bed_type_name",
                                DB::raw("'{$date}' as date"),
                                "{$roomDayName}.dayname",
                                "{$roomRateTable}.room_price",
                                "{$roomRateTable}.room_only_price",
                                "{$roomRateTable}.breakfast_price")
                            ->where("{$roomDayName}.number", $dateDayNumber)
                            ->where("{$roomTable}.deleted_at", null);
        }

        $roomRates = $roomRatesSubQuery[0];
        unset($dates[0]);
        foreach ($dates as $key => $date) {
            $roomRates = $roomRates->unionAll($roomRatesSubQuery[$key]);
        }

        return $roomRates->get();
    }

    public function getRoomRatesJson()
    {

    }

    public function getRoom()
    {
        return Room::all()->toArray();
    }

    public function getRate($roomId, $date)
    {
        $dateDayNumber = date('w', strtotime($date));
        $dateDay = DayName::where('number', $dateDayNumber)
                    ->get()
                    ->first();

        return RoomRateModel::where('room_id', $roomId)
                    ->where('dayname_id', $dateDay->id)
                    ->first()
                    ->toArray();
    }

    public function dates()
    {
        $begin = new \DateTime($this->checkin);
        $end = new \DateTime($this->checkout);

        $daterange = new \DatePeriod($begin, new \DateInterval('P1D'), $end);

        $dates = [];

        foreach($daterange as $date){
            $dates[] = $date->format("Y-m-d");
        }

        return $dates;
    }

    public function _getRoomRates()
    {
        $rooms = $this->getRoom();
        $dates = $this->dates();

        foreach ($rooms as $key => $room) {
            $rooms[$key]['dates'] = $dates;
            foreach ($dates as $keyDate => $date) {
                $rooms[$key]['rates'][] = $this->getRate($room['id'], $date);
            }
        }

        return $rooms;
    }
}
