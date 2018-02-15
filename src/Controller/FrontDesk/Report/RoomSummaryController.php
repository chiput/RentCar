<?php

namespace App\Controller\FrontDesk\Report;

use Slim\Http\Request;
use Slim\Http\Response;
use App\Controller\Controller;
use App\Model\Room;
use App\Model\RoomType;
use App\Model\Option;

class RoomSummaryController extends Controller
{
    public function __invoke(Request $request, Response $response, $args)
    {
        $data['room_types'] = RoomType::all();
        ///// get option ///
        $opt = Option::all();
        $Options=[];
        foreach ($opt as $value) {
    		$Options[$value->name] = $value->value;
        }
        $data['options'] = $Options;
        ///// end get option ///
        return $this->renderer->render($response, 'frontdesk/reports/room-summary', $data);
    }
}
