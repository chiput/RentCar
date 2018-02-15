<?php

namespace Kulkul\Accounting;

use Slim\Http\Response;
use App\Model\Account;
use App\Model\Accaktiva;
use App\Model\Accjurnal;
use App\Model\Accjurnaldetail;
use Kulkul\Authentication\Session;
use Kulkul\CodeGenerator\JurnalCode;


class AccountingServiceProvider 
{

    
    public function jurnal_save($data)
    {

        $user = Session::getActiveUser();

        if(@$data['id']==""){
            $jurnal=new Accjurnal();    
        }else{
            $jurnal = Accjurnal::find($data['id']);
        }

        if(@$data['code']==''){
            $data['code']=JurnalCode::generate();
        }

        $jurnal->code = @$data['code'];
        $jurnal->tanggal = $data['tanggal'];
        $jurnal->nobukti = @$data['nobukti'];
        $jurnal->posted = @$data['posted']==""?"UNPOSTED":@$data['posted'];
        $jurnal->keterangan = @$data['keterangan'];
        $jurnal->users_id=$user["id"];
        $jurnal->save();
        

        if(@$data['id']=="")
        {
            //new
            $accjurnals_id=$jurnal->id;
        }else{
            //update
            $accjurnals_id=$data["id"];
            //delete detail 
            $this->jurnal_detail_delete($data['id']);
        }

        foreach ($data["details"] as $key => $details) 
        {
            $details["accjurnals_id"]=$accjurnals_id;
            $this->jurnal_detail_save($details);
            //print_r($details);
        }

        return ["stat"=>"success", "mess"=>"Jurnal Tersimpan",
                "accjurnals_id"=>$accjurnals_id];
    }

    private function jurnal_detail_save($data)
    {

        $user = Session::getActiveUser();
        $detail=new Accjurnaldetail();

        $detail->accounts_id=$data['accounts_id'];
        $detail->accjurnals_id=$data['accjurnals_id'];
        $detail->debet=$data['debet'];
        $detail->kredit=$data['kredit'];
        $detail->users_id=$user["id"];

        $detail->save();
        
    }

    public function jurnal_delete($id=null)
    {
        if($id==null){
            return ["stat"=>"error", "mess"=>"Jurnal Null (tidak ditentukan)"];
        }
        $jurnal=Accjurnal::find($id);
        if($jurnal!=null){
            $jurnal->delete();
            $this->jurnal_detail_delete($id);
        }


        // if($jurnal->posted!="CLOSED"){
        //     $jurnal->delete();
        //     $this->jurnal_detail_delete($id);

        //     return ["stat"=>"error", "mess"=>"Jurnal sudah di-closing"];
        // }

        return ["stat"=>"success", "mess"=>"Jurnal terhapus"];

    }

    private function jurnal_detail_delete($jurnal_id)
    {
        $detail=Accjurnaldetail::where("accjurnals_id",$jurnal_id);
        if($detail != null){
            $detail->delete();    
        }
    }

}
