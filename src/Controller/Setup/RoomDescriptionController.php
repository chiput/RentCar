<?php

namespace App\Controller\Setup;

use Slim\Http\Request;
use Slim\Http\Response;
use App\Controller\Controller;
use App\Model\RoomDescription;

class RoomDescriptionController extends Controller
{
    public function __invoke(Request $request, Response $response, Array $args)
    {
        $data['room_descriptions'] = RoomDescription::all();
        $data['app_profile'] = $this->app_profile;
        return $this->renderer->render($response, 'setup/room-description', $data);
    }

    public function form(Request $request, Response $response, Array $args)
    {
        $data = [];
        // if update
        if (isset($args['id'])) $data['room_facility'] = RoomDescription::find($args['id']);

        // if error
        $data['errors'] = $this->session->getFlash('error_messages');
        if (!is_null($data['errors'])) {
            $data['room_facility'] = (object) $this->session->getFlash('post_data');
        }
        $data['app_profile'] = $this->app_profile;
        return $this->renderer->render($response, 'setup/room-description-form', $data);
    }

    public function save(Request $request, Response $response, Array $args)
    {
        $postData = $request->getParsedBody();

        // validation
        $this->validation->validate([
            'name|Nama Deskripsi Kamar' => [$postData['name'], 'required']
        ]);
        if (!$this->validation->passes()) {

            $this->session->setFlash('error_messages', $this->validation->errors()->all());
            $this->session->setFlash('post_data', $postData);

            if ($postData['id'] == '') {
                return $response->withRedirect($this->router->pathFor('setup-room-description-new'));
            } else {
                return $response->withRedirect($this->router->pathFor('setup-room-description-update'));
            }
        }

        // insert
        if ($postData['id'] == '') {
            $this->session->setFlash('success', 'Deskripsi kamar telah ditambahkan');
            $room_description = new RoomDescription();
        } else {
        // update
            $this->session->setFlash('success', 'Deskripsi kamar telah diperbarui');
            $room_description = RoomDescription::find($postData['id']);
        }
        $room_description->name = $postData['name'];
        $room_description->is_active = @$postData['is_active'];
        $room_description->save();

        return $response->withRedirect($this->router->pathFor('setup-room-description'));
    }

    public function delete(Request $request, Response $response, Array $args)
    {
        if (!isset($args['id'])) return $response->withRedirect($this->router->pathFor('setup-room-description'));

        $room_description = RoomDescription::find($args['id']);
        $room_description->delete();
        return $response->withRedirect($this->router->pathFor('setup-room-description'));
    }
}
