<?php

namespace App\Controller\Jobdesc;

use Slim\Http\Request;
use Slim\Http\Response;
use App\Controller\Controller;
use App\Model\Childlist;
use App\Model\Card;
use App\Model\Lists;
use App\Model\Activity;

class ChildlistController extends Controller
{
	public function __invoke(Request $request, Response $response, Array $args)
	{
		$data['childs'] = Childlist::where('checklist_id', $args['id'])->get();

		return $this->renderer->render($response, 'jobdesc/childlist', $data);
	}

	public function delete(Request $reqest, Response $response, Array $args)
	{
		$child = Childlist::find($args['id']);
		$child->delete();
	}

	public function save(Request $request, Response $response, Array $args)
	{
		$postData = $request->getParsedBody();

		 // insert
	    	$this->session->setFlash('success', 'Child Berhasil Dibuat');
	        $child = new Childlist();
	   		$child->checklist_id = $postData['cheklistid'];
	   		$child->childname = $postData['childname'];
        $child->save();
	}

	public function saveactive(Request $request, Response $response, Array $args)
	{
		$ces = $args['status'];
		if($ces == 1){
			$ces = 'completed';
		} else {
			$ces = 'discompleted';
		}

		$activity = new Activity();
		$activity->user_id = $_SESSION['id'];
		$activity->board_id = $_SESSION['board'];
		$activity->card_id = $args['card'];
		$activity->ket = $ces.' checklist "'.$args['nama'].'"';
		$activity->save();

		$child = Childlist::find($args['id']);
		$child->status = $args['status'];
		$child->save();
	}
}