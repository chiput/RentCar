<?php

namespace App\Controller\FrontDesk\Report;

use Slim\Http\Request;
use Slim\Http\Response;
use App\Controller\Controller;
use App\Model\CheckOut;
use App\Model\CheckOutDetail;
use App\Model\Deposit;
use App\Model\Option;

class CashierReportController extends Controller
{
    public function filter(Request $request, Response $response, $args)
    {
        $data['submit_form'] = $this->router->pathFor('frontdesk-report-cashier-display');
        $data['customDataLyout'] = [
            'title' => 'Laporan Kasir'
        ];

        return $this->renderer->render($response, 'frontdesk/reports/cashier-filter', $data);
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

        $dates=[];
        $deposits = Deposit::whereBetween('tanggal', [$start , $end])->orderBy('tanggal')->get();

        foreach ($deposits as $key => $value) {
            if(!isset($dates[$value->tanggal])) $dates[$value->tanggal]=[];
            if(!is_array($dates[$value->tanggal])) $dates[$value->tanggal]=[];

            array_push($dates[$value->tanggal],$value);

        }
        // $checkOut = CheckOutDetail::whereHas('checkout', function ($query) use ($postData) {
        //             $query->whereBetween('checkout_date',array_values($postData))->orderBy('checkout_date');
        //             })->get();
        $checkOut = CheckOut::whereBetween('checkout_date',[$start , $end])->orderBy('checkout_date')->get();
         
        foreach ($checkOut as $key => $value) {
            // if(!isset($dates[$value->checkout->checkout_date])) $dates[$value->checkout->checkout_date]=[];
            // if(!is_array($dates[$value->checkout->checkout_date])) $dates[$value->checkout->checkout_date]=[];
            // array_push($dates[$value->checkout->checkout_date],$value);

            if(!isset($dates[$value->checkout_date])) $dates[$value->checkout_date]=[];
            if(!is_array($dates[$value->checkout_date])) $dates[$value->checkout_date]=[];
            array_push($dates[$value->checkout_date],$value);            

        }                       

        $data['dates']=$dates;

        ///// get option ///
        $opt = Option::all();
        $Options=[];
        foreach ($opt as $value) {
            $Options[$value->name] = $value->value;
        }
        ///// end get option ///
        $data['options'] = $Options;
        return $this->renderer->render($response, 'frontdesk/reports/cashier-report', $data);
    }
}
