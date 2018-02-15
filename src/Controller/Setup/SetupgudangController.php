<?php

namespace App\Controller\Setup;

use Slim\Http\Request;
use Slim\Http\Response;
use App\Controller\Controller;
use App\Model\Setupgudang;
use App\Model\Gudang;

class SetupgudangController extends Controller
{
    public function __invoke(Request $request, Response $response, Array $args)
    {   
        if($request->isPost())
        {
            $postData = $request->getParsedBody();

            foreach ($postData["name"] as $name => $value) {
                $opt = Setupgudang::where('name', '=', $name)->first();
                $opt->value = $value;
                $opt->save();
            }
            return $response->withRedirect($this->router->pathFor('setup-gudang'));

        } else {

        $setupgudang = Setupgudang::all();
        foreach ($setupgudang as $gudang) {
            $data['setupgudang'][$gudang->name]=$gudang;
        }

        $data['gudang'] = Gudang::all();
        $data['gudangs'] = Gudang::all();
        $data['gudangz'] = Gudang::all();
        $data['gudangx'] = Gudang::all();

        return $this->renderer->render($response, 'setup/gudang-form', $data);

        }
    }

    public function delete(Request $request, Response $response, Array $args)
    {
    }
}
