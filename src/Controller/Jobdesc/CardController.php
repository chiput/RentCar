<?php
namespace App\Controller\Jobdesc;
use Slim\Http\Request;
use Slim\Http\Response;
use App\Controller\Controller;
use App\Model\Card;
use App\Model\Activity;
use App\Model\Lists;

class CardController extends Controller
{
	public function __invoke(Request $request, Response $response, Array $args)
	{
		$data['cards'] = Card::where('list', $args['id'])->get();
		$data['title'] = "Task Manager";
		return $this->renderer->render($response, 'card', $data);
	}

	public function create_card(Request $request, Response $response, Array $args)
	{
		$data = [];
		
		if(null != $this->session->getFlash('postCard')) {
			$data['cards'] = (object)$this->session->getFlash('postCard');
		}
		if(isset($args['id']))
			$data['card'] = Card::find($args['id']);
		$data['title'] = "Form Card";
		return $this->renderer->render($response, 'card-form', $data);
	}

	public function save(Request $request, Response $response, Array $args)
	{
		$postData = $request->getParsedBody();
		 // insert
        if ($postData['pk'] == '') {
        	$this->session->setFlash('success', 'Card Berhasil Dibuat');

            $card = new card();
	        $card->id = $postData['id'];
	        $card->list = $postData['idlist'];
	        $card->cardname = ($postData['cardname']);
	        $card->save();

	        $list = Lists::find($postData['idlist'])->get();
	        foreach ($list as $list) {
	        	$listname = $list->listname;
	        }

        	$activity = new Activity();
        	$activity->user_id = $postData['userid'];
        	$activity->board_id = $postData['board'];
        	$activity->list_id = $postData['idlist'];
        	$activity->ket = 'created card "'.$postData['cardname'].'" to '.$listname;
        	$activity->save();

	        return $response->withRedirect('/board/list/'.$postData['board']);
	        
        } else {
        // update
        	$this->session->setFlash('success', 'Card Berhasil Diperbaharui');
            $card = Card::find($postData['pk']);
            $card->description = $postData['value'];
            $card->save();
        }
	}

	public function attachment(Request $request, Response $response, Array $args)
	{
		$postData = $request->getParsedBody();
		$files = $request->getUploadedFiles();

        if ($files['attachment']->getClientFilename()=="") {

        } else {

            $newfile = $files['attachment'];
            $ext=end(explode(".",$newfile->getClientFilename()));
            $name=explode(".", $newfile->getClientFilename());
            $name = $name[0];

            // move new file to attachment folder in public
            if ($newfile->getError() === UPLOAD_ERR_OK) {
                $uploadFileName = $newfile->getClientFilename();
                $newfile->moveTo(__PUBLICPATH__.'/attachment/'.$name.'.'.$ext);
            }

            $card=Card::where("id","=",$postData['idcard'])->first();
            $card->attachment= $name.'.'.$ext;
            $card->save();

            return $response->withRedirect('/board/list/'.$_SESSION['board']);
        }
	}
	
	public function delete(Request $request, Response $response, Array $args)
	{
		$card = Card::find($args['id'])->get();

		foreach ($card as $card) {
			$cardname = $card->cardname;
			$idlist = $card->	list;
		}

		$card->delete();

		$list = Lists::find($idlist)->get();

		foreach ($list as $list) {
			$listname = $list->listname;
		}

		$activity = new Activity();
    	$activity->user_id = $_SESSION['id'];
    	$activity->board_id = $args['board'];
    	$activity->list_id = $idlist;
    	$activity->card_id = $args['id'];
    	$activity->ket = 'archived card '.$cardname.' from '.$listname;
    	$activity->save();

		return $response->withRedirect('/board/list/'.$args['board']);
	}
}