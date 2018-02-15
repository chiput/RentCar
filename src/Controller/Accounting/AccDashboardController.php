<?php

namespace App\Controller\Accounting;

use Slim\Http\Request;
use Slim\Http\Response;
use App\Controller\Controller;
use App\Model\Accjurnal;
use App\Model\Option;
use Kulkul\Options;
use Carbon\Carbon;
use Illuminate\Database\Capsule\Manager as DB;

class AccDashboardController extends Controller
{
  
    public function __invoke(Request $request, Response $response, Array $args)
    {
        // $postData = $request->getParsedBody();
        
        // //$date = date('Y-m-d H:i:s',time()-(7*86400)); // 7 days ago
        // $date = Accjurnal::now();
        //  $data["jurnals"]=Accjurnal::whereWeek('created_at', $date->week)
        //                     ->where("posted","!=","UNPOSTED")
        //                     ->get();

                            
        // $data['options'] = Options::all();
        // // "SELECT * FROM table WHERE date <='$date' ";
            

        // return $this->renderer->render($response, 'accounting/accdashboard', $data);
    } 

    public function jurnal(Request $request, Response $response, Array $args)
    {
        function convert_date($date){
            $exp = explode('-', $date);
            if (count($exp)==3) {
                $date = $exp[2].'-'.$exp[1].'-'.$exp[0];
            }
            return $date;
        }

        $data['app_profile'] = $this->app_profile;

        $currentDay = date("l");
        $currentMonth = date('m');
        $currentYear = date('Y');
        $one_week_ago = Carbon::now()->subWeeks(1);
    
        $data['jurnals'] = Accjurnal::whereRaw('DATE(`tanggal`)')
                            ->where('tanggal', '>=', $one_week_ago)
                            ->get();

        //tampil data per bulan ini tahun ini
        // $data['jurnals'] = Accjurnal::whereRaw('MONTH(tanggal) = ?',[$currentMonth])
        //                     ->whereRaw("YEAR(tanggal) =".$currentYear)
        //                     ->get();
        ///// get option ///
        $opt = Option::all();
        $Options=[];
        foreach ($opt as $value) {
            $Options[$value->name] = $value->value;
        }
        $data['options'] = $Options;

        
            // $postData = $request->getParsedBody();
    
            // //query
            // $currentMonth = date('m');
            // $data["jurnals"]=Accjurnal::whereRaw('MONTH(tanggal) = ?',[$currentMonth])
            //                 ->where("posted","!=","UNPOSTED")
            //                 ->get();

            // $data['options'] = Options::all();

            return $this->renderer->render($response, 'accounting/accdashboard', $data);
        

    }
}

