<?php

namespace App\Controller\Pembelian;

use Slim\Http\Request;
use Slim\Http\Response;
use App\Controller\Controller;
use App\Model\Supplier;
use App\Model\Kota;

class SupplierController extends Controller
{
	public function __invoke(Request $request, Response $response, Array $args)
	{
		$data['suppliers'] = Supplier::all();
		$data['app_profile'] = $this->app_profile;
		$data['message'] = $this->session->getFlash('success');
		return $this->renderer->render($response, 'pembelian/supplier', $data);

	}

	public function form(Request $request, Response $response, Array $args)
	{
		$data = [];
		if(null != $this->session->getFlash('postData')) {
			$data["supplier"]=(object)$this->session->getFlash('postData');
		}

		$data['kotas'] = Kota::all();
		if (@$args['id'] != '') {
			$data['supplier'] = Supplier::find($args['id']);
		}

		$data['errors'] = $this->session->getFlash('error_messages');
        if (!is_null($data['errors'])) {
            $data['supplier'] = (object) $this->session->getFlash('post_data');
        }

		return $this->renderer->render($response, 'pembelian/supplier-form', $data);

	}

	public function save(Request $request, Response $response, Array $args)
	{
		
		
		$postData = $request->getParsedBody();

		// validation
		 $this->validation->validate([
            'kode|Kode Supplier'        => [$postData['kode'], 'required'],
            'nama|Nama Supplier'      => [$postData['nama'], 'required'],
            'contact|Contact'      => [$postData['contact'], 'required'],
            'kotaid|Kota'  => [$postData['kotaid'], 'required'],
            'telepon|Telepon'  => [$postData['telepon'], 'required|number'],
        ]);

		 if (!$this->validation->passes()) {

            $this->session->setFlash('error_messages', $this->validation->errors()->all());
            $this->session->setFlash('post_data', $postData);

            if ($postData['id'] == '') {
                return $response->withRedirect($this->router->pathFor('pembelian-supplier-add'));
            } else {
                return $response->withRedirect($this->router->pathFor('pembelian-supplier-update'));
            }
        }

         // insert
        if ($postData['id'] == '') {
            $this->session->setFlash('success', 'Supplier Tersimpan');
            $supplier = new Supplier();
        } else {
        // update
            $this->session->setFlash('success', 'Supplier Terbaharui');
            $supplier = Supplier::find($postData['id']);
        }

        $supplier->kode = $postData['kode'];
        $supplier->nama = $postData['nama'];
        $supplier->contact = $postData['contact'];
        $supplier->alamat = $postData['alamat'];
        $supplier->kotaid = $postData['kotaid'];
        $supplier->telepon = $postData['telepon'];
        $supplier->users_id=$this->session->get('activeUser')["id"];

        $supplier->save();

        return $response->withRedirect($this->router->pathFor('pembelian-supplier'));

	}

	public function delete(Request $request, Response $response, Array $args)
	{
		$supplier=Supplier::find($args["id"]);
		$supplier->delete();
		$this->session->setFlash('success', 'Supplier Terhapus');
        return $response->withRedirect($this->router->pathFor('pembelian-supplier'));
	}
}
