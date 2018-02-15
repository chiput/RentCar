<?php

namespace App\Controller\Setup;

use Slim\Http\Request;
use Slim\Http\Response;
use App\Controller\Controller;
use App\Model\BedType;

class BedTypeController extends Controller
{
    public function __invoke(Request $request, Response $response, Array $args)
    {
        $data['bed_types'] = BedType::all();
        $data['message'] = $this->session->getFlash('success');
        $data['app_profile'] = $this->app_profile;
        return $this->renderer->render($response, 'setup/bed-type', $data);
        return $response;
    }

    public function form(Request $request, Response $response, Array $args)
    {
        $data = [];
        // if update
        if (isset($args['id'])) $data['bed_type'] = BedType::find($args['id']);

        // if error
        $data['errors'] = $this->session->getFlash('error_messages');
        if (!is_null($data['errors'])) {
            $data['bed_type'] = (object) $this->session->getFlash('post_data');
        }
        $data['app_profile'] = $this->app_profile;
        return $this->renderer->render($response, 'setup/bed-type-form', $data);
    }

    public function save(Request $request, Response $response, Array $args)
    {
        $postData = $request->getParsedBody();

        // validation
        $this->validation->validate([
            'name|Nama Jenis Tempat Tidur' => [$postData['name'], 'required'],
        ]);
        if (!$this->validation->passes()) {

            $this->session->setFlash('error_messages', $this->validation->errors()->all());
            $this->session->setFlash('post_data', $postData);

            if ($postData['id'] == '') {
                return $response->withRedirect($this->router->pathFor('setup-bed-type-new'));
            } else {
                return $response->withRedirect($this->router->pathFor('setup-bed-type-update'));
            }
        }

        // insert
        if ($postData['id'] == '') {
            $this->session->setFlash('success', 'Jenis tempat tidur ditambahkan');
            $bedType = new BedType();
        } else {
        // update
            $this->session->setFlash('success', 'Jenis tempat tidur diperbarui');
            $bedType = BedType::find($postData['id']);
        }
        $bedType->name = $postData['name'];
        $bedType->is_active = @$postData['is_active'];
        $bedType->save();

        return $response->withRedirect($this->router->pathFor('setup-bed-type'));
    }

    public function delete(Request $request, Response $response, Array $args)
    {
        $department = BedType::find($args['id']);
        $department->delete();
        $this->session->setFlash('success', 'Jenis tempat tidur telah dihapus');
        return $response->withRedirect($this->router->pathFor('setup-bed-type'));
    }
}
