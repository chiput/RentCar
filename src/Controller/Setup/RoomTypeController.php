<?php

namespace App\Controller\Setup;

use Slim\Http\Request;
use Slim\Http\Response;
use App\Controller\Controller;
use App\Model\RoomType;

class RoomTypeController extends Controller
{
    public function __invoke(Request $request, Response $response, Array $args)
    {
        $data['room_types'] = RoomType::all();
        $data['app_profile'] = $this->app_profile;
        return $this->renderer->render($response, 'setup/room-type', $data);
    }

    public function form(Request $request, Response $response, Array $args)
    {
        $data = [];
        // if update
        if (isset($args['id'])) $data['room_type'] = RoomType::find($args['id']);

        // if error
        $data['errors'] = $this->session->getFlash('error_messages');
        if (!is_null($data['errors'])) {
            $data['room_type'] = (object) $this->session->getFlash('post_data');
        }
        $data['app_profile'] = $this->app_profile;
        return $this->renderer->render($response, 'setup/room-type-form', $data);
    }

    public function save(Request $request, Response $response, Array $args)
    {
        $postData = $request->getParsedBody();

        // validation
        $this->validation->validate([
            'name|Nama Jenis Kamar' => [$postData['name'], 'required']
        ]);
        if (!$this->validation->passes()) {

            $this->session->setFlash('error_messages', $this->validation->errors()->all());
            $this->session->setFlash('post_data', $postData);

            if ($postData['id'] == '') {
                return $response->withRedirect($this->router->pathFor('setup-room-type-new'));
            } else {
                return $response->withRedirect($this->router->pathFor('setup-room-type-update'));
            }
        }

        // insert
        if ($postData['id'] == '') {
            $this->session->setFlash('success', 'Jenis mobil tersimpan');
            $roomType = new RoomType();
        } else {
        // update
            $this->session->setFlash('success', 'Jenis mobil tersimpan');
            $roomType = RoomType::find($postData['id']);
        }
        $roomType->name = $postData['name'];
        $roomType->is_active = @$postData['is_active'];
        $roomType->save();

        return $response->withRedirect($this->router->pathFor('setup-room-type'));
    } 

    public function delete(Request $request, Response $response, Array $args)
    {
        if (!isset($args['id'])) return $response->withRedirect($this->router->pathFor('setup-room-type'));

        $roomType = RoomType::find($args['id']);
        $roomType->delete();
        return $response->withRedirect($this->router->pathFor('setup-room-type'));
    }
}
