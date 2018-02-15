<?php

namespace App\Controller\Management;

use Slim\Http\Request;
use Slim\Http\Response;
use App\Controller\Controller;

use App\Model\Logauditing;

use Illuminate\Database\Capsule\Manager as DB;

class LogAuditingController extends Controller
{
  
    public function __invoke(Request $request, Response $response, Array $args)
    {
        
        // $data['app_profile'] = $this->app_profile;
        $data["log"] = Logauditing::where('table',$args['table'])
                                        ->where('id_table',$args['id'])
                                        ->get();

        return $this->renderer->render($response, 'management/log-auditing', $data);
    } 

}
