<?php

namespace App\Controller\Setup;

use Slim\Http\Request;
use Slim\Http\Response;
use App\Controller\Controller;
use App\Model\RoomFacility;

class RoomFacilityController extends Controller
{
    public function __invoke(Request $request, Response $response, Array $args)
    {
        $data['room_facilities'] = RoomFacility::all();
        $data['app_profile'] = $this->app_profile;
        return $this->renderer->render($response, 'setup/room-facility', $data);
    }

    public function form(Request $request, Response $response, Array $args)
    {
        $data = [];
        // if update
        if (isset($args['id'])) $data['room_facility'] = RoomFacility::find($args['id']);

        // if error
        $data['errors'] = $this->session->getFlash('error_messages');
        if (!is_null($data['errors'])) {
            $data['room_facility'] = (object) $this->session->getFlash('post_data');
        }
        $data['app_profile'] = $this->app_profile;
        return $this->renderer->render($response, 'setup/room-facility-form', $data);
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
                return $response->withRedirect($this->router->pathFor('setup-room-facility-new'));
            } else {
                return $response->withRedirect($this->router->pathFor('setup-room-facility-update'));
            }
        }

        // insert
        if ($postData['id'] == '') {
            $this->session->setFlash('success', 'Fasilitas kamar telah ditambahkan');
            $room_facility = new RoomFacility();
        } else {
        // update
            $this->session->setFlash('success', 'Fasilitas kamar telah diperbarui');
            $room_facility = RoomFacility::find($postData['id']);
        }
        $room_facility->name = $postData['name'];
        $room_facility->is_active = $postData['is_active'];
        $room_facility->save();

        return $response->withRedirect($this->router->pathFor('setup-room-facility'));
    }

    public function delete(Request $request, Response $response, Array $args)
    {
        if (!isset($args['id'])) return $response->withRedirect($this->router->pathFor('setup-room-facility'));

        $room_facility = RoomFacility::find($args['id']);
        $room_facility->delete();
        return $response->withRedirect($this->router->pathFor('setup-room-facility'));
    }
}
