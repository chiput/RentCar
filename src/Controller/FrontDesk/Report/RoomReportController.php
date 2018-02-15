<?php

namespace App\Controller\FrontDesk\Report;

use Slim\Http\Request;
use Slim\Http\Response;
use App\Controller\Controller;
use App\Model\Room;
use App\Model\Option;
//use Kulkul\Options;
class RoomReportController extends Controller
{
    public function __invoke(Request $request, Response $response, $args)
    {
        $data['rooms'] = Room::orderBy('number', 'asc')
                            ->get();
                        
        ///// get option ///
        $opt = Option::all();
        $Options=[];
        foreach ($opt as $value) {
    		$Options[$value->name] = $value->value;
        }
        $data['options'] = $Options;
        ///// end get option ///
        return $this->renderer->render($response, 'frontdesk/reports/room', $data);
    }
}
