<?php

namespace App\Controller\Management;

use Slim\Http\Request;
use Slim\Http\Response;
use App\Controller\Controller;
use App\Model\Reservation;
use App\Model\Guest;
use Illuminate\Database\Capsule\Manager as DB;

class AnalisaTamuController extends Controller
{
  
    public function __invoke(Request $request, Response $response, Array $args){

        $postData = $request->getParsedBody();

        if($request->isPost()){        
            $start=$postData["start"];
            $end=$postData["end"];
        }else{
            $start=date("d-m-Y");
            $end=date("d-m-Y");
        }

        $data["start"]=$this->convert_date($start);
        $data['end']=$this->convert_date($end);

        $data['datas'] = Reservation::whereBetween("tanggal",[$this->convert_date($start),$this->convert_date($end)])
                                        ->select(DB::raw('Count(*) as jumlah, reservations.*'))
                                        ->groupBy('guests_id')
                                        ->orderBy('jumlah','desc')
                                        ->get();

        return $this->renderer->render($response, 'management/tamu-favorit', $data);
    }  

    public function birthday(Request $request, Response $response, Array $args){

        $postData = $request->getParsedBody();

       if ($request->isPost()) {

            $postData = $request->getParsedBody();

            $data["d_start"]=$postData["start"];
            $data["d_end"]=$postData["end"];
            $data['status']=$postData['status'];

        } else {
            $data['status']=1;
            $data["d_start"]=date("d-m-Y");
            $data["d_end"]=date("d-m-Y",strtotime("tomorrow"));
        }

        $start = explode('-', $data["d_start"]);
        $end = explode('-', $data["d_end"]);

        $data['datas'] = Guest::select(DB::raw('date_format(date_of_birth, "%d-%m") as date'),'guests.*')
                            ->whereBetween(DB::raw('date_format(date_of_birth, "%d")'),[$start[0],$end[0]])
                            ->whereBetween(DB::raw('date_format(date_of_birth, "%m")'),[$start[1],$end[1]])
                            ->get();

        return $this->renderer->render($response, 'management/tamu-birthday', $data);
    }

    private function convert_date($date){
        $exp = explode('-', $date);
        if (count($exp)==3) {
            $date = $exp[2].'-'.$exp[1].'-'.$exp[0];
        }
        return $date;
    }

}
