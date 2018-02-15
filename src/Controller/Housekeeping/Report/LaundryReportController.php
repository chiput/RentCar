<?php

namespace App\Controller\Housekeeping\Report;

use Slim\Http\Request;
use Slim\Http\Response;
use App\Controller\Controller;
use App\Model\Laundrykasir;
use App\Model\Option;

class LaundryReportController extends Controller
{
    public function filter(Request $request, Response $response, $args)
    {
        $data['submit_form'] = $this->router->pathFor('housekeeping-report-pendapatanlaundry');

        return $this->renderer->render($response, 'housekeeping/report/pendapatanlaundry-filter', $data);
    }
    public function display(Request $request, Response $response, $args)
    {
        $postData = $request->getParsedBody();

        $data['menu'] = Laundrykasir::whereBetween('tanggal', array_values($postData))->get();
        $data['tanggal'] = $postData;
        ///// get option ///
        $opt = Option::all();
        $Options=[];
       foreach ($opt as $value) {
          $Options[$value->name] = $value->value;
        }
        $data['options'] = $Options;
        ///// end get option ///

        return $this->renderer->render($response, 'housekeeping/report/pendapatanlaundry', $data);
    }
}
