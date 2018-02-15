<?php

namespace App\Controller\Setup;

use Slim\Http\Request;
use Slim\Http\Response;
use Slim\Http\UploadedFile;
use App\Controller\Controller;
use App\Model\RoomStatusType;

class RoomStatusTypeController extends Controller
{
	public function __invoke(Request $request, Response $response, Array $args)
	{
		$data['roomstatus'] = RoomStatusType::all();
		$data['app_profile'] = $this->app_profile;
		$data['message'] = $this->session->getFlash('success');

		return $this->renderer->render($response, 'setup/roomstatustype', $data);
	}

	public function form(Request $request, Response $response, Array $args)
	{
		$data = [];

		if (@$args['id'] != '') {
			$data['roomstatus'] = RoomStatusType::find($args['id']);
		}

		if( null != $this->session->getFlash('postData')) {
			$data["roomstatus"]=(object)$this->session->getFlash('postData');
		}

		$data['errors'] = $this->session->getFlash('error_messages');
        if (!is_null($data['errors'])) {
            $data['roomstatus'] = (object) $this->session->getFlash('post_data');
        }

		return $this->renderer->render($response, 'setup/roomstatustype-form', $data);

	}

	public function save(Request $request, Response $response, Array $args)
	{
		$postData = $request->getParsedBody();

		// validation
		 $this->validation->validate([
            'code|Kode'        => [$postData['code'], 'required'],
            'desc|Keterangan'      => [$postData['desc'], 'required']
        ]);

        if (!$this->validation->passes()) {

            $this->session->setFlash('error_messages', $this->validation->errors()->all());
            $this->session->setFlash('post_data', $postData);

            if ($postData['id'] == '') {
                 return $response->withRedirect($this->router->pathFor('room-status-type-add'));
            } else {
                return $response->withRedirect($this->router->pathFor('room-status-type-update'));
            }
        }

        if ($postData['id'] != '') {
            $this->session->setFlash('success', 'Status Kamar Terbaharui');
            $roomstatus = RoomStatusType::find($postData['id']);
        } else {
            $this->session->setFlash('success', 'Status Kamar Tersimpan');
            $roomstatus = new RoomStatusType();
        }

        $roomstatus->code = $postData['code'];
        $roomstatus->desc = $postData['desc'];

        if (!empty($_FILES['icon']['name'])) {
            $icon = $_FILES['icon']['tmp_name'];
            $addicon = addslashes(($icon));
            $addicon = file_get_contents($addicon);
            $addicon = base64_encode($addicon);
            $roomstatus->icon = $addicon;
        }
        
        $roomstatus->status = $postData['status'];
        $roomstatus->users_id = $this->session->get('activeUser')["id"];

        $roomstatus->save();

        return $response->withRedirect($this->router->pathFor('setup-room-status-type'));

	}

	public function delete(Request $request, Response $response, Array $args)
	{
		$roomstatus=RoomStatusType::find($args["id"]);
		$roomstatus->delete();
		$this->session->setFlash('success', 'Status Kamar Terhapus');
        return $response->withRedirect($this->router->pathFor('setup-room-status-type'));
	}
}