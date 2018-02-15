<?php

namespace App\Controller\FrontDesk;

use Slim\Http\Request;
use Slim\Http\Response;
use App\Controller\Controller;
use App\Model\Agent;
use App\Model\AgentRate;
use App\Model\Room;
use Kulkul\CurrencyFormater\FormaterAdapter;

class AgentRateController extends Controller
{
    public function __invoke(Request $request, Response $response, Array $args)
    {
        $agent_id = $args['agent_id'];
        $data['agent'] = Agent::find($agent_id);
        $data['room_types'] = RoomType::all();
        $data['bed_types'] = BedType::all();
        $data['rates'] = AgentRate::where('agents_id','=',$agent_id)->get();
        return $this->renderer->render($response, 'frontdesk/agent-rate', $data);
    }

    public function form(Request $request, Response $response, Array $args)
    {
        $data = [];
        // if update
        $data['agent'] = Agent::find(@$args['agent_id']);
        $data['room'] = Room::find(@$args['room_id']);
            
        $data['rate'] = AgentRate::where("agents_id","=",@$args['agent_id'])
                        ->where("room_id","=",@$args['room_id'])
                        ->first(); 
        // if error
        $data['errors'] = $this->session->getFlash('error_messages');
        if (!is_null($data['errors'])) {
            $data['rate'] = (object) $this->session->getFlash('post_data');
        }

        return $this->renderer->render($response, 'frontdesk/agent-rate-form', $data);
    }

    public function save(Request $request, Response $response, Array $args)
    {
        $postData = $request->getParsedBody();


        // insert
        if ($postData['id'] == '') {
            $this->session->setFlash('success', 'Data harga agen ditambahkan');
            $rate = new AgentRate();
        } else {
        // update
            $this->session->setFlash('success', 'Data harga agen diperbarui');
            $rate = AgentRate::find($postData['id']);
        }
        $rate->agents_id = $postData['agents_id'];
        $rate->room_id = $postData['room_id'];
        $rate->room_only_price = FormaterAdapter::reverse($postData['room_only_price']);
        $rate->breakfast_price = FormaterAdapter::reverse($postData['breakfast_price']);
        $rate->room_price = FormaterAdapter::reverse($postData['room_price']);
        $rate->users_id=$this->session->get('activeUser')["id"];
        $rate->save();
        return $response->withRedirect($this->router->pathFor('setup-room'));
    }

    public function delete(Request $request, Response $response, Array $args)
    {
        $rate = AgentRate::find($args['id']);
        $agent_id=$rate->agents_id;
        $rate->delete();
        $this->session->setFlash('success', 'Data harga agen telah dihapus');
        return $response->withRedirect($this->router->pathFor('setup-room'));
    }
}
