<?php

namespace App\Controller\Accounting;

use Slim\Http\Request;
use Slim\Http\Response;
use App\Controller\Controller;
use App\Model\Currency;
use App\Model\CurrencyRate;


class CurrencyController extends Controller
{

    public function __invoke(Request $request, Response $response, Array $args)
    {

    }
    public function currency(Request $request, Response $response, Array $args)
    {

        $postData=$request->getParsedBody();
        
        $data=[];
        $data['app_profile'] = $this->app_profile;
        $data['currencies'] = Currency::all();

        if($request->isPost()){
            //print_r($postData); return;
            $this->validation->validate([
                'name|Nama Mata Uang' => [$postData['name'], 'required'],
                'code|Kode Mata Uang' => [$postData['code'], 'required'],
                'symbol|Simbol Mata Uang' => [$postData['symbol'], 'required'],
            ]);
            if (!$this->validation->passes()) {

                $this->session->setFlash('error_messages', $this->validation->errors()->all());
                $this->session->setFlash('post_data', $postData);

                return $response->withRedirect($this->router->pathFor('accounting-currency'));
            }

            //print_r($postData); return;

            if(@$postData["defa"]==1){
                $currencies=Currency::where("id",">",0)
                ->update(['defa'=>'0']);
            }else{
                
                $currency=Currency::where('code','=','IDR')->first();
                $currency->defa=1;
                $currency->save();
                
            }

            if($postData["id"]==""){
                $currency=new Currency();    
            }else{
                $currency=Currency::find($postData["id"]);
            }
            $currency->code=$postData["code"];
            $currency->symbol=$postData["symbol"];
            $currency->name=$postData["name"];
            $currency->defa=(@$postData["defa"]==""?0:1);
            $currency->users_id=$this->session->get('activeUser')["id"];
            $currency->save();

            return $response->withRedirect($this->router->pathFor('accounting-currency'));

        }else{
            return $this->renderer->render($response, 'accounting/currency', $data);
        }

    }

    public function currency_delete(Request $request, Response $response, Array $args)
    {
        $currency=Currency::find(@$args["id"]);
        $default=$currency->defa;
        $currency->delete();

        if($default==1){
            $currency=Currency::where('code','=','IDR')->first();
            $currency->defa=1;
            $currency->save();
        }
        
        $this->session->setFlash('success',"Mata uang telah dihapus !");

        return $response->withRedirect($this->router->pathFor('accounting-currency'));
    }

    public function rate(Request $request, Response $response, Array $args)
    {

        $postData=$request->getParsedBody();
        $getData=$request->getQueryParams();

        // print_r($postData);
        // return;

        $data=[];
        $data['app_profile'] = $this->app_profile;
        $data['currency'] = Currency::find(@$args["id"]);
        
        $month=(isset($getData["month"])?substr("0".$getData["month"],-2):date("m"));
        $year=(isset($getData["year"])?$getData["year"]:date("Y"));
        $data["month"]=$month;
        $data["year"]=$year;
        
        // print_r($data["month"]);
        // return;

        $rates=CurrencyRate::where("currency_id","=",$args["id"])->whereRaw("left(date,7)='$year-$month'")->get();
        $data["rates"]=[];
        foreach ($rates as $rate) {
            $data["rates"][$rate->date]=$rate->rate;
        }
        //print_r($data["rates"]);

        if($request->isPost()){

            foreach ($postData["rate"] as $date => $value) {
                
                $rate=CurrencyRate::where("currency_id","=",$args["id"])
                ->where("date","=",$date);

                if($rate->count()<1&&floatval($value)>0.1){
                    $rate=new CurrencyRate();
                    $rate->currency_id=$args["id"];
                    $rate->date=$date;
                    $rate->rate=$value;
                    $rate->users_id=$this->session->get('activeUser')["id"];
                    $rate->save();
                }else{
                    if(floatval($value)>0.1){
                        $rate=CurrencyRate::where("currency_id","=",$args["id"])
                        ->where("date","=",$date)->update(["rate"=>$value]);
                        // $rate->rate=$value;
                        // $rate->save();
                    }else{
                        $rate->delete();
                    }
                }                                                           
            }
            //return;
            return $response->withRedirect($this->router->pathFor('accounting-currency-rate',["id"=>$args["id"]],["month"=>$postData["month"],"year"=>$postData['year']]));

        }else{
            
            
            return $this->renderer->render($response, 'accounting/currency-rate', $data);
        }

    }
}


