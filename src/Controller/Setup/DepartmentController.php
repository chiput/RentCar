<?php

namespace App\Controller\Setup;

use Slim\Http\Request;
use Slim\Http\Response;
use App\Controller\Controller;
use App\Model\Department;

class DepartmentController extends Controller
{
    public function __invoke(Request $request, Response $response, Array $args)
    {
        $data['departments'] = Department::all();
        $data['message'] = $this->session->getFlash('success');
        $data['app_profile'] = $this->app_profile;
        return $this->renderer->render($response, 'setup/department', $data);
        return $response;
    }

    public function form(Request $request, Response $response, Array $args)
    {
        $data = [];
        // if update
        if (isset($args['id'])) $data['department'] = Department::find($args['id']);

        // if error
        $data['errors'] = $this->session->getFlash('error_messages');
        if (!is_null($data['errors'])) {
            $data['department'] = (object) $this->session->getFlash('post_data');
        }
        $data['app_profile'] = $this->app_profile;
        return $this->renderer->render($response, 'setup/department-form', $data);
    }

    public function save(Request $request, Response $response, Array $args)
    {
        $postData = $request->getParsedBody();

        // validation
        $this->validation->validate([
            'code|Kode' => [$postData['code'], 'required'],
            'name|Nama' => [$postData['name'], 'required'],
        ]);
        if (!$this->validation->passes()) {

            $this->session->setFlash('error_messages', $this->validation->errors()->all());
            $this->session->setFlash('post_data', $postData);

            if ($postData['id'] == '') {
                return $response->withRedirect($this->router->pathFor('setup-department-new'));
            } else {
                return $response->withRedirect($this->router->pathFor('setup-department-update'));
            }
        }

        // insert
        if ($postData['id'] == '') {
        // save    
            $department = new Department();
        } else {
        // update
            $department = Department::find($postData['id']);
        }

        $department->code = $postData['code'];
        $department->name = $postData['name'];
        $department->ket = $postData['ket'];
        $department->is_active = (!isset($postData['is_active']) ? 0 : 1);
        $department->users_id = $this->session->get('activeUser')["id"];
        
        try
        {
            $department->save();    
        }catch (\Exception $e){
            $errorCode = $e->errorInfo[1];
            if($errorCode == 1062){
                $this->session->setFlash('error_messages', ["Duplikat data"]);
            }else{
                $this->session->setFlash('error_messages', $e->errorInfo);
            }
            $this->session->setFlash('post_data', $postData);
            if ($postData['id'] == '') {
                return $response->withRedirect($this->router->pathFor('setup-department-new'));
            } else {
                return $response->withRedirect($this->router->pathFor('setup-department-update'));
            }
        }
        $this->session->setFlash('success', 'Department saved');

        return $response->withRedirect($this->router->pathFor('setup-department'));
    }

    public function delete(Request $request, Response $response, Array $args)
    {
        $department = Department::find($args['id']);
        $department->delete();
        $this->session->setFlash('success', 'Department deleted');
        return $response->withRedirect($this->router->pathFor('setup-department'));
    }
}
