<?php

namespace App\Controller\Jobdesc;

use Slim\Http\Request;
use Slim\Http\Response;
use App\Controller\Controller;
use App\Model\Board;
use App\Model\User;
use App\Model\Activity;

class BoardController extends Controller
{
	public function __invoke(Request $request, Response $response, Array $args)
	{
		function comma_separated_to_array($string, $separator = ',')
		{
		  $vals = explode($separator, $string);
		  foreach($vals as $key => $val) {
		    $vals[$key] = trim($val);
		  }
		  return array_diff($vals, array(""));
		}

		$data['boards'] = Board::whereRaw('find_in_set(? , user_id)', comma_separated_to_array($args['id']))->get();
		$data['title'] = "Job Desc - Hospitality Platform";

		return $this->renderer->render($response, 'jobdesc/board', $data);
	}

	public function form(Request $request, Response $response, Array $args)
	{
		$data = [];
		
		if(null != $this->session->getFlash('postBoard')) {
			$data['boards'] = (object)$this->session->getFlash('postBoard');
		}

		if(isset($args['id']))
			$data['board'] = Board::find($args['id']);


		$data['title'] = "Form Board";

		return $this->renderer->render($response, 'board-form', $data);
	}

	public function save(Request $request, Response $response, Array $args)
	{
		$postData = $request->getParsedBody();

		 // insert
        if ($postData['pk'] == '') {

        	$this->session->setFlash('success', 'Board Berhasil Dibuat');
            $board = new Board();
       		$board->boardname = ($postData['boardname']);
       		$board->user_id = $_SESSION['id'];
        } else {
        // update
        	$board = Board::find($postData['pk']);
	        $board->boardname = ($postData['value']);
        }

        $board->save();

        return $response->withRedirect('/board/'.$_SESSION['id']);

	}

	public function delete(Request $request, Response $response, Array $args)
	{
		$board = Board::find($args['id']);
		$board->delete();
		$this->session->setFlash('success', 'Board Terhapus');
		return $response->withRedirect($this->router->pathFor('tampil-board'));
	}

	public function member(Request $request, Response $response, Array $args)
	{
		$postData = $request->getParsedBody();

		$listmember = User::where('name', $postData['addmember'])->get();
		$board = Board::where('id', $_SESSION['board'])->get();

		foreach ($board as $board) {
			$member = $board->user_id;
		}

		foreach ($listmember as $list) {
			$id = $list->id;
			$username = $list->name;
		}

		function comma_separated_to_array($string, $separator = ',')
		{
		  $vals = explode($separator, $string);

		  foreach($vals as $key => $val) {
		    $vals[$key] = trim($val);
		  }

		  return array_diff($vals, array(""));
		}

		if(isset($id)){
			$member = comma_separated_to_array($member.','.$id);
			$update = array();

			foreach ($member as $member) {
				$update[] = $member;
			}

			$update = array_unique($update);
			$update = implode(',', $update);
			$board->user_id = $update;
			$board->save();

			$activity = new Activity();
	        $activity->board_id = $_SESSION['board'];
	        $activity->user_id = $_SESSION['id'];
	        $activity->ket = 'added "'.$username.'" on this board';
	        $activity->save();

			return $response->withRedirect('/board/list/'.$_SESSION['board']);	

		} else {

			$this->session->setFlash('success', 'User tidak ditemukan');

			return $response->withRedirect('/board/list/'.$_SESSION['board']);	
		}		
	}
}