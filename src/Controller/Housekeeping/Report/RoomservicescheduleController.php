<?php

namespace App\Controller\Housekeeping\Report;

use Slim\Http\Request;
use Slim\Http\Response;
use App\Controller\Controller;
use App\Model\Hotservice;
use App\Model\Option;

class RoomservicescheduleController extends Controller
{
  public function filter(Request $request, Response $response, $args)
  {
      $data['submit_form'] = $this->router->pathFor('housekeeping-report-roomserviceschedule');

      return $this->renderer->render($response, 'housekeeping/report/roomserviceschedule-filter', $data);
  }
  public function display(Request $request, Response $response, $args)
  {
        function convert_date($date){
                    $exp = explode('-', $date);
                    if (count($exp)==3) {
                        $date = $exp[2].'-'.$exp[1].'-'.$exp[0];
                    }
                    return $date;
                }
      $postData = $request->getParsedBody();

      $data['range'] = $postData;

        $start = convert_date($data['range']['start']);
        $end = convert_date($data['range']['end']);


      $data['menu'] = Hotservice::whereBetween('tanggal', array($start,$end))
                                    ->get();
      // $data['tanggal'] = $postData;
      ///// get option ///
      $opt = Option::all();
      $Options=[];
      foreach ($opt as $value) {
        $Options[$value->name] = $value->value;
      }
      $data['options'] = $Options;
      ///// end get option ///

      return $this->renderer->render($response, 'housekeeping/report/roomserviceschedule', $data);
  }
  public function display1(Request $request, Response $response, $args)
  {
      $menus = Hotservice::find($args['id']);
      $data['menu'] = $menus;
      ///// get option ///
      $opt = Option::all();
      $Options=[];
      foreach ($opt as $value) {
        $Options[$value->name] = $value->value;
      }
      $data['options'] = $Options;
      ///// end get option ///

      return $this->renderer->render($response, 'housekeeping/report/roomserviceschedule0', $data);
  }
}
