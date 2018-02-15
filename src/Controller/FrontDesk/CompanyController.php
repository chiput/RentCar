<?php

namespace App\Controller\FrontDesk;

use Slim\Http\Request;
use Slim\Http\Response;
use App\Controller\Controller;
use App\Model\Company;

class CompanyController extends Controller
{
    public function __invoke(Request $request, Response $response, Array $args)
    {
        $data['companies'] = Company::all();
        $data['message'] = $this->session->getFlash('success');
        return $this->renderer->render($response, 'frontdesk/company', $data);
    }

    public function form(Request $request, Response $response, Array $args)
    {
        $data = [];
        // if update
        if (isset($args['id'])) $data['company'] = Company::find($args['id']);

        // if error
        $data['errors'] = $this->session->getFlash('error_messages');
        if (!is_null($data['errors'])) {
            $data['company'] = (object) $this->session->getFlash('post_data');
        }

        return $this->renderer->render($response, 'frontdesk/company-form', $data);
    }

    public function save(Request $request, Response $response, Array $args)
    {
        $postData = $request->getParsedBody();

        // validation
        $this->validation->validate([
            'name|Nama Perusahaan' => [$postData['name'], 'required'],
        ]);
        if (!$this->validation->passes()) {

            $this->session->setFlash('error_messages', $this->validation->errors()->all());
            $this->session->setFlash('post_data', $postData);

            if ($postData['id'] == '') {
                return $response->withRedirect($this->router->pathFor('frontdesk-company-new'));
            } else {
                return $response->withRedirect($this->router->pathFor('frontdesk-company-update'));
            }
        }

        // insert
        if ($postData['id'] == '') {
            $this->session->setFlash('success', 'Data perusahaan ditambahkan');
            $company = new Company();
        } else {
        // update
            $this->session->setFlash('success', 'Data perusahaan diperbarui');
            $company = Company::find($postData['id']);
        }
        $company->name = $postData['name'];
        $company->discount = 0;
        $company->is_active = (@$postData['is_active']==""?0:1);
        
        $company->users_id=$this->session->get('activeUser')["id"];
        $company->save();

        return $response->withRedirect($this->router->pathFor('frontdesk-company'));
    }

    public function delete(Request $request, Response $response, Array $args)
    {
        $company = Company::find($args['id']);
        $company->delete();
        $this->session->setFlash('success', 'Data perusahaan telah dihapus');
        return $response->withRedirect($this->router->pathFor('frontdesk-company'));
    }
}
