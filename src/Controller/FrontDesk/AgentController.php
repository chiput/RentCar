<?php

namespace App\Controller\FrontDesk;

use Slim\Http\Request;
use Slim\Http\Response;
use App\Controller\Controller;
use App\Model\Agent;
use App\Model\Idtype;

class AgentController extends Controller
{
    public function __invoke(Request $request, Response $response, Array $args)
    {
        $data['agents'] = Agent::orderBy('id','desc')->get();
        $data['message'] = $this->session->getFlash('success');
        return $this->renderer->render($response, 'frontdesk/agent', $data);
    }

    public function form(Request $request, Response $response, Array $args)
    {
        $data = [];
        // if update
        if (isset($args['id'])) $data['agent'] = Agent::find($args['id']);

        // if error
        $data['errors'] = $this->session->getFlash('error_messages');
        if (!is_null($data['errors'])) {
            $data['agent'] = (object) $this->session->getFlash('post_data');
        }

        return $this->renderer->render($response, 'frontdesk/agent-form', $data);
    }

    public function save(Request $request, Response $response, Array $args)
    {
        $postData = $request->getParsedBody();

        // validation
        $this->validation->validate([
            'name|Nama Agent' => [$postData['name'], 'required'],
        ]);
        if (!$this->validation->passes()) {

            $this->session->setFlash('error_messages', $this->validation->errors()->all());
            $this->session->setFlash('post_data', $postData);

            if ($postData['id'] == '') {
                return $response->withRedirect($this->router->pathFor('frontdesk-agent-new'));
            } else {
                return $response->withRedirect($this->router->pathFor('frontdesk-agent-update',["id"=>$postData['id']]));
            }
        }

        // insert
        if ($postData['id'] == '') {
            $this->session->setFlash('success', 'Data Sopir ditambahkan');
            $agent = new Agent();
        } else {
        // update
            $this->session->setFlash('success', 'Data Sopir diperbarui');
            $agent = Agent::find($postData['id']);
        }
        $agent->name = $postData['name'];
        $agent->code = $postData['code'];
        $agent->is_active = (@$postData['is_active']==""?0:1);
        
        $agent->users_id=$this->session->get('activeUser')["id"];
        $agent->save();

        return $response->withRedirect($this->router->pathFor('frontdesk-agent'));
    }

    public function delete(Request $request, Response $response, Array $args)
    {
        $agent = Agent::find($args['id']);
        $agent->delete();
        $this->session->setFlash('success', 'Data sopir telah dihapus');
        return $response->withRedirect($this->router->pathFor('frontdesk-agent'));
    }
}
