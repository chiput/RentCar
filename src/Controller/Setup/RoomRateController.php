<?php

namespace App\Controller\Setup;

use Slim\Http\Request;
use Slim\Http\Response;
use App\Controller\Controller;
use App\Model\Room;
use App\Model\DayName;
use App\Model\RoomRate;
use Kulkul\CurrencyFormater\FormaterAdapter;

class RoomRateController extends Controller
{
    public function __invoke(Request $request, Response $response, Array $args)
    {
        $data['app_profile'] = $this->app_profile;
        $data['room'] = Room::find($args['room_id']);
        $data['daynames'] = DayName::orderBy('number', 'ASC')->get();
        $data ['room_rates'] = RoomRate::where('room_id', $args['room_id'])->get();
        $response = $this->renderer->render($response, 'setup/room-rate', $data);
        return $response;
    }

    public function update(Request $request, Response $response, Array $args)
    {

    }

    public function save(Request $request, Response $response, Array $args)
    {
        $post = $request->getParsedBody();
        if ($post['action'] == 'insert') {
            foreach ($post['dayname_id'] as $key => $dayname_id) {
                $room_rate = new RoomRate();
                $room_rate->room_id = $post['room_id'];
                $room_rate->dayname_id = $dayname_id;
                $room_rate->room_price = FormaterAdapter::reverse($post['room_price'][$dayname_id]);
                $room_rate->room_only_price = FormaterAdapter::reverse($post['room_only_price'][$dayname_id]);
                $room_rate->breakfast_price = FormaterAdapter::reverse($post['breakfast_price'][$dayname_id]);
                $room_rate->save();
            }
        } else {
            foreach ($post['id'] as $key => $idx) {
                $room_rate = RoomRate::find($idx);
                $room_rate->room_price = FormaterAdapter::reverse($post['room_price'][$idx]);
                $room_rate->room_only_price = FormaterAdapter::reverse($post['room_only_price'][$idx]);
                $room_rate->breakfast_price = FormaterAdapter::reverse($post['breakfast_price'][$idx]);
                $room_rate->save();
            }
        }

        return $response->withRedirect(
            $this->router->pathFor('setup-room')
        );
    }
}
