<?php

namespace App\Controller\Setup;

use Slim\Http\Request;
use Slim\Http\Response;
use App\Controller\Controller;
use App\Model\Building;

class BuildingController extends Controller
{
    public function __invoke(Request $request, Response $response, Array $args)
    {
        $data['buildings'] = Building::all();
        $data['message'] = $this->session->getFlash('success');
        $data['app_profile'] = $this->app_profile;
        return $this->renderer->render($response, 'setup/building', $data);
    }

    public function form(Request $request, Response $response, Array $args)
    {
        $data = [];
        // if update
        $data['building'] = Building::find($args['id']);

        // if error
        $data['errors'] = $this->session->getFlash('error_messages');
        if (!is_null($data['errors'])) {
            $data['building'] = (object) $this->session->getFlash('post_data');
        }
        $data['app_profile'] = $this->app_profile;
        return $this->renderer->render($response, 'setup/building-form', $data);
    }

    public function save(Request $request, Response $response, Array $args)
    {
        $postData = $request->getParsedBody();

        // validation
        $this->validation->validate([
            'name|Name' => [$postData['name'], 'required'],
        ]);
        if (!$this->validation->passes()) {

            $this->session->setFlash('error_messages', $this->validation->errors()->all());
            $this->session->setFlash('post_data', $postData);

            if ($postData['id'] == '') {
                return $response->withRedirect($this->router->pathFor('setup-building-new'));
            } else {
                return $response->withRedirect($this->router->pathFor('setup-building-update'));
            }
        }

        // insert
        if ($postData['id'] == '') {
        // save    
            $building = new Building();
        } else {
        // update
            $building = Building::find($postData['id']);
        }

        $building->desc = $postData['desc'];
        $building->name = $postData['name'];
        $building->users_id = $this->session->get('activeUser')["id"];

        try
        {
            $building->save();    
        }catch (\Exception $e){
            $errorCode = $e->errorInfo[1];
            if($errorCode == 1062){
                $this->session->setFlash('error_messages', "Duplikat data");
                $this->session->setFlash('post_data', $postData);
                if ($postData['id'] == '') {
                    return $response->withRedirect($this->router->pathFor('setup-building-new'));
                } else {
                    return $response->withRedirect($this->router->pathFor('setup-building-update'));
                }
            }
        }
        $this->session->setFlash('success', 'Gedung tersimpan');

        return $response->withRedirect($this->router->pathFor('setup-building'));
    }

    public function delete(Request $request, Response $response, Array $args)
    {
        $building = Building::find($args['id']);
        $building->delete();
        $this->session->setFlash('success', 'Gedung terhapus');
        return $response->withRedirect($this->router->pathFor('setup-building'));
    }
}
