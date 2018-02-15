<?php

namespace App\Controller\Spa\Report;

use Slim\Http\Request;
use Slim\Http\Response;
use App\Controller\Controller;

class SpaReportController extends Controller
{
    public function __invoke(Request $request, Response $response, $args)
    {
        $data['jenis_laporan'] = $args["jenislaporan"];
        $data['app_profile'] = $this->app_profile;
        return $this->renderer->render($response, 'spa/reports/report', $data);
    }
}
