<?php

namespace App\Controller\Telepon;

use Slim\Http\Request;
use Slim\Http\Response;
use App\Controller\Controller;
use App\Model\Telpbiaya;
use App\Model\Telpextension;
use App\Model\Telpbilling;
use App\Model\Room;
use Kulkul\CurrencyFormater\FormaterAdapter;
use Illuminate\Database\Capsule\Manager as Capsule;

class TeleponController extends Controller
{
    // Biaya Telepon
    public function __invoke(Request $request, Response $response, Array $args){
        
        $data['biayas'] = Telpbiaya::all();

        return $this->renderer->render($response, 'telepon/biayatelepon', $data);
    }  

    public function formbiaya(Request $request, Response $response, Array $args)
    {
        if (isset($args['id'])) {
            $data['biaya'] = Telpbiaya::find($args['id']);
        }

        $data['app_profile'] = $this->app_profile;

        $data['errors'] = $this->session->getFlash('error_messages');
        if (!is_null($data['errors'])) {
            $data['biaya'] = (object) $this->session->getFlash('post_data');
        }



        return $this->renderer->render($response, 'telepon/biayatelepon-form', $data);
    } 

    public function biayasave(Request $request, Response $response, Array $args)
    {
        $postData = $request->getParsedBody();

        // validation
        $this->validation->validate([
            //'nodepan|Nomer Depan' => [$postData['nodepan'], 'required'],
            'durasi|Durasi' => [$postData['durasi'], 'required'],
            'harga|Harga' => [$postData['harga'], 'required']

        ]);
        if (!$this->validation->passes()) {
            $this->session->setFlash('error_messages', $this->validation->errors()->all());
            $this->session->setFlash('post_data', $postData);

            if ($postData['id'] == '') {
                return $response->withRedirect($this->router->pathFor('telpbiaya-new'));
            } else {
                return $response->withRedirect($this->router->pathFor('telpbiaya-edit'));
            }
        }

        // insert
        if ($postData['id'] == '') {
            $this->session->setFlash('post_data', array('Data Biaya Telepon ditambahkan'));

            $telpbiaya = new Telpbiaya();
            $telpbiaya->created_at = date('Y-m-d H:i:s');
        }
        else {
        // update
            $this->session->setFlash('success', 'Data Biaya Telepon diperbarui');
            $telpbiaya = Telpbiaya::find($postData['id']);
            $telpbiaya->updated_at = date('Y-m-d H:i:s');
        }

        $telpbiaya->nodepan =$postData['nodepan'];
        $telpbiaya->durasi = $postData['durasi'];
        $telpbiaya->harga = FormaterAdapter::reverse($postData['harga']);
        $telpbiaya->stts = strlen($postData['nodepan']);
        $telpbiaya->save();

        return $response->withRedirect($this->router->pathFor('telpbiaya'));
    } 

    public function deletebiaya(Request $request, Response $response, Array $args)
    {
        $telpbiaya = Telpbiaya::find($args['id']);
        $telpbiaya->delete();
        $this->session->setFlash('success', 'Data Biaya Telepon telah dihapus');
        return $response->withRedirect($this->router->pathFor('telpbiaya'));
    } 

    // Extension
    public function telpextension(Request $request, Response $response, Array $args){
        
        $data['extions'] = Telpextension::all();

        return $this->renderer->render($response, 'telepon/extensiontelepon', $data);
    }

    public function formextention(Request $request, Response $response, Array $args)
    {
        if (isset($args['id'])) {
            $data['extion'] = Telpextension::find($args['id']);
        }

        $data['app_profile'] = $this->app_profile;

        $data['errors'] = $this->session->getFlash('error_messages');
        if (!is_null($data['errors'])) {
            $data['extion'] = (object) $this->session->getFlash('post_data');
        }
        $data['kamar'] = Room::all();
        return $this->renderer->render($response, 'telepon/extensiontelepon-form', $data);
    } 

    public function extentionsave(Request $request, Response $response, Array $args)
    {
         $postData = $request->getParsedBody();

        // validation
        $this->validation->validate([
            'ext|Extention' => [$postData['ext'], 'required'],
            'room|Room' => [$postData['room'], 'required']

        ]);
        if (!$this->validation->passes()) {
            $this->session->setFlash('error_messages', $this->validation->errors()->all());
            $this->session->setFlash('post_data', $postData);

            if ($postData['id'] == '') {
                return $response->withRedirect($this->router->pathFor('telpextention-new'));
            } else {
                return $response->withRedirect($this->router->pathFor('telpextention-edit'));
            }
        }

        // insert
        if ($postData['id'] == '') {
            $this->session->setFlash('post_data', array('Data Extention Telepon ditambahkan'));

            $extion = new Telpextension();
            $extion->created_at = date('Y-m-d H:i:s');
        }
        else {
        // update
            $this->session->setFlash('success', 'Data Extention Telepon diperbarui');
            $extion = Telpextension::find($postData['id']);
            $extion->updated_at = date('Y-m-d H:i:s');
        }

        $extion->extno =$postData['ext'];
        $extion->roomid = $postData['room'];
        $extion->save();

        return $response->withRedirect($this->router->pathFor('telpextention'));
    } 

    public function deleteextention(Request $request, Response $response, Array $args)
    {
        $telpbiaya = Telpextension::find($args['id']);
        $telpbiaya->delete();
        $this->session->setFlash('success', 'Data Extention Telepon telah dihapus');
        return $response->withRedirect($this->router->pathFor('telpextention'));
    } 

    public function billingview(Request $request, Response $response, Array $args)
    {
        $data['bill'] = Telpbilling::all();

        return $this->renderer->render($response, 'telepon/billingtelepon', $data);
    } 


    public function billing(Request $request, Response $response, Array $args){

        $conf = parse_ini_file("config.ini");
        $today = date('Ymd');
        $dir = $conf['datfol'];
        $file = $dir.$today.".dat";
        $send = array();

        $files = file_get_contents($file);
        if ($files != '') {
            
            $lines = preg_split("/[\n,]+/", file_get_contents($file));
            $i = 0;
            
            foreach ($lines as $line) {
                $d = preg_split("/[\s,]+/", $line);
                
                if (!empty($d[0]) && !preg_match('/[\-]/', $d[0])) {
                    
                    $roomid = Capsule::select("SELECT roomid from telpextension where extno = ".$d[2]);
                    //$roomid->execute(array('extno' => ));
                    //$roomid = $roomid->fetchAll();
                    if (!empty($roomid[0]->roomid)) {

                        //get reservations id
                        $roomid = $roomid[0]->roomid;
                        $reservation_id = Capsule::select("SELECT id from reservationdetails where rooms_id = ".$roomid." and NOT (checkin_at <=> NULL) and checkout_at IS NULL");

                        if (count($reservation_id) > 0) {
                            $reservation_id = $reservation_id[0]->id;

                            //biaya -----------------------------
                            $durasi = explode(":", $d[5]);
                            $durasi1 = explode("'", $durasi[1]);
                            $convJam = 3600 * $durasi[0];
                            $convMenit = 60 * $durasi1[0];
                            $detik = $durasi1[1];
                            $total = $convJam+$convMenit+$detik;

                            $jumNomor = strlen($d[4]);
                            $iStart = ($jumNomor > 10) ? 10 : $jumNomor;
                            $qBiaya = array();

                            for ($j=$iStart; $j > 0; $j--) { 
                                $nomor_awal = substr($d[4], 0, $j);

                                $qBiayas = Capsule::select("SELECT durasi,harga from telpbiaya where nodepan = ".$nomor_awal." and stts = ".$j);

                                if (count($qBiayas) > 0) {
                                    $qBiaya = $qBiayas;
                                    break;
                                }
                            }

                            $biaya = (count($qBiaya) > 0) ? ceil($total/$qBiaya[0]->durasi)*$qBiaya[0]->harga : 0;
                            //echo $biaya;

                            //-----------------------------------
                            
                            $today = date("Y-m-d");
                            $nobukti = 'TP'.date('Y').date('m');
                            $jam = explode(":",$d[1]);
                            $durasi = $durasi[0].$durasi1[0].$durasi1[1];
                            $remark = "Telephone".$today.$jam[0].$jam[1].$durasi.$d[4];

                            //check if data exits
                            $checkAdd = Capsule::select("SELECT COUNT(id) as jml from addcharges where tanggal='".$today."' and ntotal='".$biaya."' and remark='".$remark."'");

                            if ($checkAdd[0]->jml == 0) {
                                
                                $nourut = Capsule::select("SELECT nobukti from addcharges where nobukti LIKE '%".$nobukti."%' ORDER BY nobukti DESC LIMIT 1");
                                
                                $nourut = (count($nourut) > 0) ? substr($nourut[0]->nobukti,8) : 0;
                                $nourut = ($nourut != 0) ? $nobukti.((int)$nourut+1) : $nobukti."1";

                                //insert to addcharges
                                Capsule::insert("INSERT into addcharges value('','$today','$nourut','$reservation_id',0,0,0,0,0,$biaya,'$remark',0,1,0,NULL,NULL)");
                                $addcharges = Capsule::select("SELECT id from addcharges ORDER BY id DESC LIMIT 1");
                                foreach ($addcharges as $data) {
                                    $addcharges = $data->id;
                                }

                                //insert to addchargedetails
                                Capsule::insert("INSERT into addchargedetails value('','$addcharges',2,0,'$remark',1,$biaya,0,1,NULL,NULL)");

                                $ddt = explode('/', $d[0]);
                                $day = $ddt[0];
                                $month = $ddt[1];
                                $year = $ddt[2];
                                $datenya = '20'.$year.'-'.$month.'-'.$day;

                                //Simpan data ke database
                                $telpbilling = new Telpbilling();
                                $telpbilling->roomid = $roomid;
                                $telpbilling->biaya = $biaya;
                                $telpbilling->tanggal = $datenya;
                                $telpbilling->jam = $d[1];
                                $telpbilling->notelp = $d[4];
                                $telpbilling->durasi = $d[5];
                                $telpbilling->save();


                            }

                            //send data as json
                            $send[$i][0] = $i+1; // No
                            $send[$i][1] = $roomid; // Room Id
                            $send[$i][2] = (count($qBiaya) > 0) ? "Rp ".number_format($biaya,0, "", ".") : "Biaya Belum Di Set"; // biaya
                            $send[$i][3] = $d[0]; //tanggal
                            $send[$i][4] = $d[1]; //jam
                            $send[$i][5] = $d[4]; //no Telp
                            $send[$i][6] = $d[5]; //durasi
                            $i++;

                        }
                    }

                }
            }
        }

        $send = array('data' => $send, 'file' => $file); 
        return $response->write(json_encode($send));
    }

     public function setup(Request $request, Response $response, Array $args)
     {
        function get_file_dir() {
            global $argv;
            $dir = dirname(getcwd() . '/' . $argv[0]);
            $curDir = getcwd();
            chdir($dir);
            $dir = getcwd();
            chdir($curDir);
            return $dir;
        }
        //$postData = $request->getParsedBody();
        if($request->isPost()){
            $body = $request->getParsedBody();
            $string = "datfol=".$body['datfol'];

            $dir = get_file_dir().'/src/Controller/Telepon/config.ini';

            $server = $_SERVER['SERVER_NAME'];
            $file = fopen($dir,"w");
            
            if(fwrite($file, $string)){
                fclose($file);

                return $response->withJson(array('success'=>true),200);  
            }

            $response->withJson(array('success'=>false),400);
        } else {
            $conf = parse_ini_file("config.ini");

            $send = array();
            $send[0]["datfol"] = $conf['datfol'];

             return $response->write($send[0]["datfol"]);
        }
     }

}
