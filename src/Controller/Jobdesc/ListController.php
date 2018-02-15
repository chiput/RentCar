<?php
namespace App\Controller\Jobdesc;
use Slim\Http\Request;
use Slim\Http\Response;
use App\Controller\Controller;
use App\Model\Lists;
use App\Model\Board;
use App\Model\Card;
use App\Model\Activity;
use App\Model\User;

class ListController extends Controller
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

		$data['lists'] = Lists::where('board', $args['id'])->get();
		$data['boardlist'] = Board::whereRaw('find_in_set(? , user_id)', comma_separated_to_array($_SESSION['id']))->limit(5)->get();
		$data['boardrecent'] = Board::whereRaw('find_in_set(? , user_id)', comma_separated_to_array($_SESSION['id']))->orderBy('id', 'DESC')->limit(5)->get();
		$data['title'] = "Job Desc - Hospitality Platform";
		$data['acts'] = Activity::where('board_id', $args['id'])->orderBy('id','DESC')->limit(15)->get();
		$data['archives'] = Lists::onlyTrashed()->where('board', $args['id'])->get();
		$alluser= Board::select('user_id')->where('id', $args['id'])->get();

		foreach ($alluser as $user) { 
			$array_one = comma_separated_to_array($user->user_id);
		}

		$data['users'] = User::whereIn('id', $array_one)->get();

		if(isset($args['id'])){
			$data['boards'] = Board::find($args['id']);
		}

		return $this->renderer->render($response, 'jobdesc/list', $data);
	}	

	public function create_list(Request $request, Response $response, Array $args)
	{
		$data = [];
		
		if(null != $this->session->getFlash('postList')) {
			$data['lists'] = (object)$this->session->getFlash('postList');
		}
		if(isset($args['id']))
			$data['list'] = Lists::find($args['id']);
		$data['title'] = "Form List";

		return $this->renderer->render($response, 'list-form', $data);
	}

	public function save(Request $request, Response $response, Array $args)
	{
		$postData = $request->getParsedBody();


		 // insert
        if ($postData['pk'] == '') {
        	$this->session->setFlash('success', 'List Berhasil Dibuat');
            $list = new Lists();
	        $list->board = $postData['idboard'];
	        $list->listname = ($postData['listname']);

	        $activity = new Activity();
	        $activity->board_id = $postData['idboard'];
	        $activity->user_id = $postData['iduser'];
	        $activity->ket = 'created list "'.$postData['listname'].'" on this board';
	        $activity->save();
        } else {
        // update
        	$this->session->setFlash('success', 'List Berhasil Diperbaharui');
            $list = lists::find($postData['pk']);
	        $list->listname = ($postData['value']);
        }
        $list->save();

        return $response->withRedirect('/board/list/'.$list->board);
	}

	public function restoredata()
	{
		// restore softdelet 
		$list->restore();
	}

	public function savecard(Request $request, Response $response, Array $args)
	{
		$postData = $request->getParsedBody();

        $card = new Card();
        $card = Card::find($postData['pk']);
	    $card->cardname = ($postData['value']);
	    
	    $cards = Card::where('id', $postData['pk'])->get();
	    $encode = json_encode($cards);
		$cardname = json_decode($encode, true);

        $activity = new Activity();
        $activity->board_id = $_SESSION['board'];
        $activity->user_id = $_SESSION['id'];
        $activity->list_id = $cardname['0']['list'];
        $activity->ket = 'rename job from "'.$cardname['0']['cardname'].'" to "'.$postData['value'].'"';

        $card->save();
        $activity->save();	
	}

	public function delete(Request $request, Response $response, Array $args)
	{
		$list = Lists::find($args['id']);
		$list->delete();
		$this->session->setFlash('success', 'List Terhapus');

		return $response->withRedirect($this->router->pathFor('tampil-list'));
	}
}