<?php

namespace App\Controller\Accounting;

use Slim\Http\Request;
use Slim\Http\Response;
use App\Model\Deposit;
use App\Controller\Controller;


class DepositController extends Controller
{
    public function __invoke(Request $request, Response $response, Array $args)
    {        
        if ($request->isPost()) {

            $postData = $request->getParsedBody();
            $data["d_start"]=$postData["start"];
            $data["d_end"]=$postData["end"];

        } else {
            $data["d_start"]=date("d-m-Y");
            $data["d_end"]=date("d-m-Y",strtotime("tomorrow"));
        }


        $data['deposits'] = Deposit::whereBetween('tanggal',array($this->convert_date($data["d_start"]), $this->convert_date($data["d_end"])))
                                    ->where('reservations_id', '!=', 0)->get();

        return $this->renderer->render($response, 'accounting/deposit-form', $data); 
    }

    private function convert_date($date){
        $exp = explode('-', $date);
        if (count($exp)==3) {
            $date = $exp[2].'-'.$exp[1].'-'.$exp[0];
        }
        return $date;
    }
}


