<?php

namespace App\Controller\Accounting;

use Slim\Http\Request;
use Slim\Http\Response;
use App\Controller\Controller;
use App\Model\Spaterapis;
use App\Model\Option;
use App\Model\Spakasir;
use App\Model\Spakasirdetail;
use Kulkul\Options;
use Illuminate\Database\Capsule\Manager as Capsule;

class Pendapatan1Controller extends Controller
{
    public function __invoke(Request $request, Response $response, $args)
    {

        // app profile
        $data['app_profile'] = $this->app_profile;


        if($request->isPost()){

            $postData = $request->getParsedBody();
                
            $data['d_start'] = $postData['start'];
            $data['d_end'] = $postData['end'];

            $start = $this->convert_date($postData['start']);
            $end = $this->convert_date($postData['end']);

            $data['options'] = Options::all();

            return $this->renderer->render($response, 'accounting/pendapatan-checkout-print', $data);

        } else {

            return $this->renderer->render($response, 'accounting/pendapatan', $data);
        }

    private function convert_date($date){
        $exp = explode('-', $date);
        if (count($exp)==3) {
            $date = $exp[2].'-'.$exp[1].'-'.$exp[0];
        }
        return $date;
    }
}
