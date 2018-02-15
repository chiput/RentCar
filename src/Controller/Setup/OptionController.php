<?php

namespace App\Controller\Setup;

use Slim\Http\Request;
use Slim\Http\Response;
use App\Controller\Controller;
use App\Model\Option;
use App\Model\Account;
use Illuminate\Database\Capsule\Manager as DB;

class OptionController extends Controller
{
    public function __invoke(Request $request, Response $response, Array $args)
    {

    	$data['app_profile'] = $this->app_profile;
        if($request->isPost())
        {
            $postData = $request->getParsedBody();

            $case="";
            //$postData["name"]['profile_logo']
            foreach ($postData["name"] as $name => $value) {
                $opt = Option::where('name', '=', $name)
                            ->update(
                                ['value' => $value]
                            );
                // $opt = Option::where("name","=",$name)->first();
                // $opt->value = $value;
                // $opt->save();
                // if($value!=""){
            	// $case.="when name='".$name."' then '".$value."' ";
                // }
            }
            //print_r($case);
            //return false;
            $option=Option::where("name","=","profile_logo")->first();
            $logo=$option->value;
            
            //print_r($postData);
            //return false;

            $option=Option::where("name","=","profile_logo")->first();
            $option->value=$logo;
            $option->save();

            $files = $request->getUploadedFiles();
            //print_r(); return false;


            // echo "UPDATE options SET value = (case
            //                     $case
            //                         end)";
            if ($files['logofile']->getClientFilename()=="") {
                //throw new Exception('Expected a newfile');
            }else{
                // var_dump($files['logofile']->getClientFilename());
                // return false;
                $newfile = $files['logofile'];
                $ext=end(explode(".",$newfile->getClientFilename()));
                // move new file
                //if()
                if ($newfile->getError() === UPLOAD_ERR_OK) {
                    $uploadFileName = $newfile->getClientFilename();
                    $newfile->moveTo(__PUBLICPATH__.'/img/logo.'.$ext);
                }

                $option=Option::where("name","=","profile_logo")->first();
                $option->value='logo.'.$ext;
                $option->save();
            }

            return $response->withRedirect($this->router->pathFor('setup-options'));
        }else{
        	$options= Option::all();
	        $data["accounts"]= Account::all();
	        foreach ($options as $option) {
	        	$data['options'][$option->name]=$option;
	        }
	        $data['app_profile'] = $this->app_profile;
	        return $this->renderer->render($response, 'setup/option', $data);
        }

    }
}
