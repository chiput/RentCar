<?php

namespace App\Controller\FrontDesk;

use App\Controller\Controller;
use Slim\Http\Request;
use Slim\Http\Response;
use App\Model\Reservationdetail;
use App\Model\Creditcard;
use Kulkul\CodeGenerator\CheckoutCode;
use App\Model\Addcharge;
use App\Model\CheckOut;
use App\Model\CheckOutDetail;
use App\Model\Reservation;
use App\Model\Deposit;
use App\Model\Option;
use App\Model\RoomStatus;
use Kulkul\Accounting\AccountingServiceProvider;
use Illuminate\Database\Capsule\Manager as DB;
use Illuminate\Support\Collection;
use Kulkul\Options;
use Kulkul\CurrencyFormater\FormaterAdapter;

class CheckoutController extends Controller
{
	/**
	* Display checkouts
	**/
	public function __invoke(Request $request, Response $response, Array $args)
	{
		$data['checkouts'] = Checkout::orderBy('id','desc')->get();
		$data['app_profile'] = $this->app_profile;

		return $this->renderer->render($response, 'frontdesk/checkout', $data);
	}

	/**
	* add checkout
	**/
	public function form (Request $request, Response $response, Array $args)
	{
		// $data['checkins'] = Reservationdetail::where('checkin_code', '!=', null)
		// 										->whereNull('check_out_id')->get();
		$data['checkins'] = Reservationdetail::where('checkin_code', '!=', null)
												->doesntHave('checkoutDetails')->orderBy('id','DESC')->get();

		$data['checkout_code'] = CheckoutCode::generate();
		$data['creditcards'] = Creditcard::all();
		$data['app_profile'] = $this->app_profile;
		$data['option'] = Options::all();

		// dummy reservation detail
		$data['selected_checkins'] = Reservationdetail::whereIn('id', [11, 12])->get();

		return $this->renderer->render($response, 'frontdesk/checkout-add', $data);
	}

	/**
	* get addition services for add checkout,
	* @return ajax response
	**/
	public function getAddServices (Request $request, Response $response, Array $args)
	{
		$reservation_detail_id = $request->getParsedBody()['selectedCheckin'];

		//$additionalServices = Addcharge::whereIn('reservationdetails_id', $reservation_detail_id)->with('reservation_detail')->get();

		$additionalServices = DB::table('addchargedetails')
			->select('addcharges.*', 'rooms.id as room_id', 'rooms.number as room_number', 'addchargetypes.code', 'addchargetypes.name', 'addchargedetails.qty', 'addchargedetails.sell')
			->join('addcharges', 'addcharges.id', '=', 'addchargedetails.addcharges_id')
			->join('reservationdetails', 'addcharges.reservationdetails_id', '=', 'reservationdetails.id')
			->join('addchargetypes', 'addchargedetails.addchargetypes_id', '=', 'addchargetypes.id')
			->join('rooms', 'reservationdetails.rooms_id', '=', 'rooms.id')
			->whereIn('reservationdetails_id', $reservation_detail_id)
			->get();

		// var_dump($additionalServices);
		foreach ($additionalServices as $addser) {
			# code...
			$addser->subtotal = FormaterAdapter::convert($addser->sell * $addser->qty);
			$addser->sell = FormaterAdapter::convert($addser->sell);

			//$addser->harga = FormaterAdapter::convert($addser->price*$addser->priceExtra);
		}

		// $jsonResponse = $response->withJson($additionalServices, 200, JSON_NUMERIC_CHECK);
		$jsonResponse = $response->withJson($additionalServices);
		$jsonResponse = $jsonResponse->withHeader('Content-type', 'application/json');
		return $jsonResponse;
	}

	/**
	* save checkout data including checkout, detail checkout
	* update reservation detail data
	**/
	public function save(Request $request, Response $response, Array $args)
	{
		function convert_date($date){
                    $exp = explode('-', $date);
                    if (count($exp)==3) {
                        $date = $exp[2].'-'.$exp[1].'-'.$exp[0];
                    }
                    return $date;
                }

		$checkoutData = $request->getParsedBody();

		///////////////////
		/////////////////// Posting jurnal
		///////////////////

		$jurnal_id = $this->post_jurnal($checkoutData);

		///////////////////
		/////////////////// Akhir Posting jurnal
		///////////////////


		// get guest id
		$reservation = DB::table('reservations')->select('guests_id')
						->join('reservationdetails', 'reservationdetails.reservations_id', '=', 'reservations.id')
						->where('reservationdetails.id', '=',$checkoutData['reservation_detail_id'][0])
						->get()->first();

		// checkout table
		$checkout = new CheckOut();
		$checkout->users_id = $this->session->get('activeUser')["id"];
		$checkout->checkout_code = $checkoutData['checkout_code'];
		$checkout->checkout_date = date('Y-m-d H:i:s', strtotime($checkoutData['date_checkout'].' '.$checkoutData['time_checkout']));
		$checkout->guest_id = $reservation->guests_id; // nanti
		$checkout->subtotal = FormaterAdapter::reverse($checkoutData['subtotal']);
		$checkout->discount_percent = $checkoutData['discount_percent'];
		$checkout->discount = FormaterAdapter::reverse($checkoutData['discount']);
		$checkout->is_discount_room_only = $checkoutData['is_discount_room_only'];
		$checkout->service_percent = $checkoutData['service_percent'];
		$checkout->service_charge = FormaterAdapter::reverse($checkoutData['service_charge']);
		$checkout->is_service_room_only = $checkoutData['is_service_room_only'];
		$checkout->tax_percent = $checkoutData['tax_percent'];
		$checkout->tax_charge = FormaterAdapter::reverse($checkoutData['tax_charge']);
		$checkout->is_tax_room_only = $checkoutData['is_tax_room_only'];
		$checkout->deposit = FormaterAdapter::reverse($checkoutData['deposit']);
		$checkout->refund = FormaterAdapter::reverse($checkoutData['refund']);
		$checkout->total = FormaterAdapter::reverse($checkoutData['total']);
		$checkout->cash = FormaterAdapter::reverse($checkoutData['cash']);
		$checkout->creditcard_id = $checkoutData['creditcard_id'];
		$checkout->creditcard_number = $checkoutData['creditcard_number'];
		$checkout->creditcard_amount = FormaterAdapter::reverse($checkoutData['creditcard_amount']);
		$checkout->payment_change = FormaterAdapter::reverse($checkoutData['paymentChange']);
		$checkout->accjurnals_id = $jurnal_id;
		$checkout->remarks = $checkoutData['remarks'];
		if($checkoutData['hiddenhrgkamar']==1){
			$checkout->hiddenhrgkamar = $checkoutData['hiddenhrgkamar'];
		}
		$checkout->save();

		foreach ($checkoutData['reservation_detail_id'] as $resv_detail) {
			$checkouDetail = new CheckOutDetail();
			$checkouDetail->check_out_id = $checkout->id;
			$checkouDetail->reservation_detail_id = $resv_detail;
			$checkouDetail->checkout_time = date('Y-m-d H:i:s', strtotime(convert_date($checkoutData['date_checkout']).' '. $checkoutData['time_checkout']));;
			$checkouDetail->save();

			$reservationDetail = ReservationDetail::find($resv_detail);
			$reservationDetail->checkout_at = $checkouDetail->checkout_time;
			$reservationDetail->save();

			$roomstatus = RoomStatus::where('reservationdetail_id', $resv_detail)->first();
			if($roomstatus != null){
				$roomstatus->date = convert_date($checkoutData['date_checkout']);
				$roomstatus->status = 2;
				$roomstatus->save();
			}
		}

		return $response->withRedirect($this->router->pathFor('frondesk-checkout'));

	}

	/**
	* singe report checkout for printout to guest
	**/
	public function reportSingle(Request $request, Response $response, Array $args)
	{
		$checkout_id = $args['id'];

		$data['checkout'] = CheckOut::find($checkout_id);
		$data['checkout_detail'] = CheckOutDetail::with('reservationDetails')
									->where('check_out_id', $checkout_id)
									->get();
		///// get option ///
        $opt = Option::all();
        $Options=[];
        foreach ($opt as $value) {
            $Options[$value->name] = $value->value;
        }
        $data['options'] = $Options;
        ///// end get option ///

		return $this->renderer->render($response, 'frontdesk/reports/checkout-single', $data);
	}

	public function delete(Request $request, Response $response, Array $args)
	{
		$checkout_id = $args['id'];

		$checkout = CheckOut::find($checkout_id);
		$jurnalid = $checkout->accjurnals_id;
		///// hapus jurnal
		$Accprovider = new AccountingServiceProvider();
        $res = $Accprovider->jurnal_delete($jurnalid);
        ////
		$checkout->delete();

		$checkout_detail = CheckOutDetail::with('reservationDetails')
									->where('check_out_id', $checkout_id)
									->get();

		foreach ($checkout_detail as $det) {
			$resDetail = ReservationDetail::find($det->reservation_detail_id);
			if($resDetail!=null){
				$resDetail->checkout_at=null;
				$resDetail->save();

				// Occupied Dirty
				$roomstatus = RoomStatus::where('reservationdetail_id', '=', $det->reservation_detail_id)->first();
				$roomstatus->date = date('Y-m-d');
				$roomstatus->status = 3;
				$roomstatus->save();
			}
		}

		//return false;
		$resDetCheckout=CheckOutDetail::where('check_out_id', $checkout_id);
		if($resDetCheckout!=null){
			$resDetCheckout->delete();
		}

		return $response->withRedirect($this->router->pathFor('frondesk-checkout'));
	}

	public function deposit(Request $request, Response $response, Array $args)
	{
		$deposit = [];

		$post = $request->getParsedBody();
		$checkinIds = $post['selectedCheckin'];

		if (count($checkinIds) == 0) return $response->withJson($deposit);

		$checkin = Reservationdetail::select('reservations_id')
					->whereIn('id', $checkinIds)
					->get();
		$reservationIDs = $checkin->pluck('reservations_id');

		$deposit = Deposit::select('nominal', 'reservations_id')
					->whereIn('reservations_id', $reservationIDs)
					->get();

		$depositNominal = $deposit->pluck('nominal');

		$depositNominalCollection = new Collection($depositNominal);

		return $response->withJson($depositNominalCollection->sum());
	}


	private function post_jurnal($checkoutData){
		if($checkoutData['remarks']){
			$remarks = ", Remarks: ".$checkoutData['remarks'];
		} else {
			$remarks ="";
		}
		$jurnal=[
	            "id"=>"",
	            "code" => "",
	            "tanggal" => date('Y-m-d', strtotime($checkoutData['date_checkout'])),
	            "nobukti" => $checkoutData['checkout_code'],
	            "keterangan" => "Check Out ".$remarks,
	            "details"=>[]
	        ];


	    // Jika tidak ada refund
		if($checkoutData['refund'] <= 0){

	        $jurnal["details"][]=[
	        	"accounts_id"=>Option::where("name","=","kas")->first()->value,
	        	"debet"=>FormaterAdapter::reverse($checkoutData['cash'])-FormaterAdapter::reverse($checkoutData['paymentChange'])+FormaterAdapter::reverse($checkoutData['creditcard_amount']),
	        	"kredit"=>0
	        ]; // simpan ke kas

	        $jurnal["details"][]=[
	        	"accounts_id"=>Option::where("name","=","deposit")->first()->value,
	        	"debet"=>FormaterAdapter::reverse($checkoutData['deposit']),
	        	"kredit"=>0,
	        ]; // kurangi deposit

	        $jurnal["details"][]=[
	        	"accounts_id"=>Option::where("name","=","pend_hotel")->first()->value,
	        	"debet"=>0,
	        	"kredit"=>FormaterAdapter::reverse($checkoutData['deposit'])+FormaterAdapter::reverse($checkoutData['cash'])+FormaterAdapter::reverse($checkoutData['creditcard_amount']),
	        ]; // simpan pendapatan

        } else { //jika ada refund

        	$jurnal['keterangan'].=" Dengan refund ".number_format($checkoutData['refund'],0);
        	$jurnal["details"][]=[
	        	"accounts_id"=>Option::where("name","=","kas")->first()->value,
	        	"debet"=> 0,
	        	"kredit"=> FormaterAdapter::reverse($checkoutData['refund'])
	        ]; // simpan ke kas

	        $jurnal["details"][]=[
	        	"accounts_id"=>Option::where("name","=","deposit")->first()->value,
	        	"debet"=>FormaterAdapter::reverse($checkoutData['deposit']),
	        	"kredit"=>0,
	        ]; // kurangi deposit

	        $jurnal["details"][]=[
	        	"accounts_id"=>Option::where("name","=","pend_hotel")->first()->value,
	        	"debet"=>0,
	        	"kredit"=>FormaterAdapter::reverse($checkoutData['deposit']) - FormaterAdapter::reverse($checkoutData['refund']),
	        ]; // simpan pendapatan
        }

        $Accprovider=new AccountingServiceProvider();

        $accounting=$Accprovider->jurnal_save($jurnal);

        if($accounting["stat"]=="error"){
        	echo $accounting["mess"];
        	return false;
        }

        //print_r($accounting);
        return $accounting["accjurnals_id"];
	}

	public function print_preview(Request $request, Response $response, Array $args){

	}
}
