<?php

namespace App\Controller\Setup;

use Slim\Http\Request;
use Slim\Http\Response;
use App\Controller\Controller;
use App\Model\Room;
use App\Model\RoomType;
use App\Model\BedType;
use App\Model\PeriodicRate;
use App\Model\PeriodicRateDetail;
use Kulkul\CurrencyFormater\FormaterAdapter;

class PeriodicRateController extends Controller
{
    public function __invoke(Request $request, Response $response, Array $args)
    {
        $data['rates'] = PeriodicRate::all();
        $data['message'] = $this->session->getFlash('success');
        $data['app_profile'] = $this->app_profile;
        return $this->renderer->render($response, 'setup/periodic-rate', $data);
    }

    public function form(Request $request, Response $response, Array $args)
    {
        $data = [];
        // if update

        $data['bedtypes'] = BedType::all();
        $data['roomtypes'] = RoomType::all();
        $data['app_profile'] = $this->app_profile;
        $rooms = Room::with("roomType")->with("bedType")->get();
        $data['rooms']=[];//$rooms;
        foreach ($rooms as $key => $room) {
            $data['rooms'][$room->id]=$room;
        }

        $data['rate']->start_date = "";
        $data['rate']->end_date = "";
        
        if (isset($args['id'])) $data['rate'] = PeriodicRate::find($args['id']); 

        $data['errors'] = $this->session->getFlash('error_messages');
        if (!is_null($data['errors'])) {
            $data['rate'] = (object) $this->session->getFlash('post_data');
            $postData = (object) $this->session->getFlash('post_data');
            $details = [];
            foreach($postData->rooms_id as $room_id){
                $details[] = (object)["rooms_id"=>$room_id];
            }
            $data['rate']->details = $details;
        }
        return $this->renderer->render($response, 'setup/periodic-rate-form', $data);

    }

    public function save(Request $request, Response $response, Array $args)
    {
        $postData = $request->getParsedBody();
        function convert_date($date){
            $exp = explode('-', $date);
            if (count($exp)==3) {
                $date = $exp[2].'-'.$exp[1].'-'.$exp[0];
            }
            return $date;
        }

        // validation
        $this->validation->validate([
            'name|Nama Periode'        => [$postData['name'], 'required'],
            'rooms_id|Kamar'        => [$postData['rooms_id'], 'required'],
        ]);

        //return $response->write(print_r($postData, true));

        if (!$this->validation->passes()) {

            $this->session->setFlash('error_messages', $this->validation->errors()->all());
            $this->session->setFlash('post_data', $postData);

            if ($postData['id'] == '') {
                return $response->withRedirect($this->router->pathFor('setup-periodic-rate-new'));
            } else {
                return $response->withRedirect($this->router->pathFor('setup-periodic-rate-update',['id'=>$postData['id']]));
            }
        }

        // insert
        if ($postData['id'] == '') {
            $this->session->setFlash('success', 'Harga Periodic Tersimpan');
            $rate = new PeriodicRate();
        } else {
        // update
            $this->session->setFlash('success', 'Harga Periodik Tersimpan');
            $rate = PeriodicRate::find($postData['id']);
        }

        $rate->name = $postData['name'];
        $rate->start_date = convert_date($postData['start_date']);
        $rate->end_date = convert_date($postData['end_date']);
        $rate->markup = FormaterAdapter::reverse($postData['markup']) | 0;
        $rate->markup_percent = @$postData['markup_percent'] | 0;
        $rate->disc = FormaterAdapter::reverse($postData['disc']) | 0 ;
        $rate->disc_percent = @$postData['disc_percent'] | 0;
        $rate->remark = $postData['remark'];
        $rate->room_types_id = $postData['room_types_id'] | 0;
        $rate->bed_types_id = $postData['bed_types_id'] | 0;
        $rate->users_id=$this->session->get('activeUser')["id"];
        $rate->save();

        PeriodicRateDetail::where("periodic_rates_id","=",$rate->id)->delete();

        foreach ($postData['rooms_id'] as $key => $rooms_id) {
            $detail= new PeriodicRateDetail();
            $detail->periodic_rates_id=$rate->id;
            $detail->rooms_id=$rooms_id;
            $detail->users_id=$this->session->get('activeUser')["id"];
            $detail->save();
        }

        return $response->withRedirect($this->router->pathFor('setup-periodic-rate'));
    }

    public function delete(Request $request, Response $response, Array $args)
    {
        $rate = PeriodicRate::find($args['id']);
        PeriodicRateDetail::where("periodic_rates_id","=",$rate->id)->delete();
        $rate->delete();
        $this->session->setFlash('success', 'Harga Periodik Terhapus');
        return $response->withRedirect($this->router->pathFor('setup-periodic-rate'));
    }
}
