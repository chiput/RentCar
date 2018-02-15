<?php
namespace Harmoni\LogAuditing;

use App\Model\Logauditing;
use Slim\Http\Request;
use Slim\Http\Response;
use App\Controller\Controller;
use Kulkul\Authentication\Session;
use Illuminate\Database\Capsule\Manager as DB;

class LogAuditingProvider 
{

  public function logactivity($new,$old,$table)
  {
      $user = Session::getActiveUser();

      foreach ($old as $key => $value):

        if($key=="updated_at" || $key=="created_at" || $key=="deleted_at")
          continue;
        
          if($old[$key] != $new->$key){
            $log = new Logauditing;
            $log->id_table = $new->id;
            $log->table = $table;
            $log->field = $key;
            $log->new = $new->$key;
            $log->old = $old[$key];
            $log->tanggal = date('Y-m-d H:i:s');
            $log->users_id = $user["id"];
            $log->save();
          }

      endforeach;

  }

  public function logactivitydetails($new,$old,$table,$id)
  {
      $user = Session::getActiveUser();
      
      foreach ($old as $key => $value):
        $arr = json_decode($old[$key],true);
        $orr = $new[$key];
        foreach ($arr as $key => $value) {

            if($key=="updated_at" || $key=="created_at" || $key=="deleted_at" || $key =="id")
            continue;
            if($orr->$key != NULL){
              if($arr[$key] != $orr->$key){
                $log = new Logauditing;
                $log->id_table = $id;
                $log->table = $table;
                $log->field = $key;
                $log->new = $orr->$key;
                $log->old = $arr[$key];
                $log->tanggal = date('Y-m-d H:i:s');
                $log->users_id = $user["id"];
                $log->save();
              }
            }


        } 
      endforeach;

  }

}

?>
