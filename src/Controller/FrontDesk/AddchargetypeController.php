<?php

namespace App\Controller\FrontDesk;

use Slim\Http\Request;
use Slim\Http\Response;
use App\Controller\Controller;
use App\Model\Addchargetype;
use App\Model\Account;
use Kulkul\CurrencyFormater\FormaterAdapter;

class AddchargetypeController extends Controller
{
    public function __invoke(Request $request, Response $response, Array $args)
    {
        $data['types'] = Addchargetype::orderBy('id','desc')->get();
        return $this->renderer->render($response, 'frontdesk/addchargetype', $data);
    }

    public function form(Request $request, Response $response, Array $args)
    {
        $data = [];
        
        $data["accounts"]=Account::all();
        // if update
        if (isset($args['id'])) $data["type"]=Addchargetype::find($args["id"]);;

        // if error
        $data['errors'] = $this->session->getFlash('error_messages');
        if (!is_null($data['errors'])) {
            $data['type'] = (object) $this->session->getFlash('post_data');
        }

        return $this->renderer->render($response, 'frontdesk/addchargetype-form', $data);
    }

    public function save(Request $request, Response $response, Array $args)
    {
        $postData = $request->getParsedBody();

        // validation
        $this->validation->validate([
            'name|Nama Jenis Biaya' => [$postData['name'], 'required'],
            'code|Kode Jenis Biaya' => [$postData['code'], 'required'],
        ]);
        if (!$this->validation->passes()) {

            $this->session->setFlash('error_messages', $this->validation->errors()->all());
            $this->session->setFlash('post_data', $postData);

            if ($postData['id'] == '') {
                return $response->withRedirect($this->router->pathFor('frontdesk-addchargetype-new'));
            } else {
                return $response->withRedirect($this->router->pathFor('frontdesk-addchargetype-update'));
            }
        }

        // insert
        if ($postData['id'] == '') {
            $this->session->setFlash('success', 'Data Jenis Biaya ditambahkan');
            $type = new Addchargetype();
        } else {
        // update
            $this->session->setFlash('success', 'Data Jenis Biaya diperbarui');
            $type = Addchargetype::find($postData['id']);
        }
        $type->code = $postData['code'];
        $type->name = $postData['name'];
        $type->is_active = (@$postData['is_active']==""?0:1);
        $type->is_editable = (@$postData['is_editable']==""?0:1);
        $type->remark=$postData["remark"];
        $type->accincome=$postData["accincome"];
        if(isset($postData["acccost"])){$setnya=$postData["acccost"];}else{$setnya=0;}
        $type->acccost=$setnya;
        $type->sell=FormaterAdapter::reverse($postData["sell"]);
        $type->buy=FormaterAdapter::reverse($postData["buy"]);
        $type->users_id=$this->session->get('activeUser')["id"];
        $type->save();

        return $response->withRedirect($this->router->pathFor('frontdesk-addchargetype'));
    }

    public function delete(Request $request, Response $response, Array $args)
    {
        $type = Addchargetype::find($args['id']);
        $type->delete();
        $this->session->setFlash('success', 'Data biaya jenis telah dihapus');
        return $response->withRedirect($this->router->pathFor('frontdesk-addchargetype'));
    }
}
