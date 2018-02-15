<?php

namespace App\Controller\Restoran;

use Slim\Http\Request;
use Slim\Http\Response;
use App\Controller\Controller;
use App\Model\Gudang;
use App\Model\Resgudang;
use App\Model\Department;

class GudangController extends Controller
{
    public function __invoke(Request $request, Response $response, Array $args)
    {
        $data['app_profile'] = $this->app_profile;
        $data['gudangs'] =$this->getData()->get()->sortByDesc("created_at");

        return $this->renderer->render($response, 'restoran/gudang', $data);
    }

    private function getData()
    {
        $gudang = $this->db->table('resgudang')
                        ->join('gudang', 'resgudang.gudangid', '=', 'gudang.id')
                        ->join('departments', 'gudang.department_id', '=', 'departments.id')
                        ->select('resgudang.id','gudang.nama', 'departments.name');

        return $gudang;
    }

    public function form(Request $request, Response $response, Array $args)
    {

        if (isset($args['id'])){
            $data['gudang'] =$this->db->table('resgudang')
                        ->join('gudang', 'resgudang.gudangid', '=', 'gudang.id')
                        ->join('departments', 'gudang.department_id', '=', 'departments.id')
                        ->select('resgudang.id as id','gudang.nama as namagudang','gudang.id as idgudang', 'departments.name as nama_departments','departments.id as id_dapertemen')->where('resgudang.id','=',$args['id'])->first();

        }
        $data['app_profile'] = $this->app_profile;
        $data['dropgudangs'] = Gudang::all();

        $data['errors'] = $this->session->getFlash('error_messages');
        if (!is_null($data['errors'])) {
            $data['meja'] = (object) $this->session->getFlash('post_data');
        }

        return $this->renderer->render($response, 'restoran/gudang-form', $data);
    }

    public function save(Request $request, Response $response, Array $args)
    {
        $postData = $request->getParsedBody();

        // validation
        $this->validation->validate([
            'gudang|Gudang' => [$postData['gudang'], 'required'],
            'dapertemen|Departemen' => [$postData['id_dapertemen'], 'required'],
            'dapertemen|Departemen' => [$postData['departemen'], 'required']

        ]);
        if (!$this->validation->passes()) {
            $this->session->setFlash('error_messages', $this->validation->errors()->all());
            $this->session->setFlash('post_data', $postData);

            if ($postData['id'] == '') {
                return $response->withRedirect($this->router->pathFor('gudang-new'));
            } else {
                return $response->withRedirect($this->router->pathFor('gudang-edit'));
            }
        }

        $id=explode("!",$postData['gudang']);
        $validasiRowG=Resgudang::where('gudangid','=',$id[0])->get()->count();
        $validasi_idDapertemans= $this->db->table('resgudang')->get();

        if ($validasiRowG>0 && $postData['id'] == '') {
                    $this->session->setFlash('error_messages', array('Data Sudah Ada' ));
                    return $response->withRedirect($this->router->pathFor('gudang-new'));
        }
        else if(($validasiRowG>0)&&$postData['id']!=''){
            foreach ( $validasi_idDapertemans as $validasi_idDaperteman) {
                if($validasi_idDaperteman->id!=$postData['id'] && $validasi_idDaperteman->gudangid==$id[0]){
                    $this->session->setFlash('error_messages', array('Data Sudah Ada' ));
                    return $response->withRedirect($this->router->pathFor('gudang-edit',['id'=>$postData['id']]));
                }
            }
        }

        // insert
        if ($postData['id'] == '') {
            $this->session->setFlash('post_data', array('Data Gudang Restoran ditambahkan'));

            $regudang = new Resgudang();
            $regudang->created_at = date('Y-m-d H:i:s');
        }
        else {
        // update
            $this->session->setFlash('success', 'Data Gudang Restoran diperbarui');
            $regudang = Resgudang::find($postData['id']);
            $regudang->updated_at = date('Y-m-d H:i:s');
        }

        $regudang->gudangid =$id[0] ;

        $regudang->users_id=$this->session->get('activeUser')["id"];
        $regudang->save();

        return $response->withRedirect($this->router->pathFor('gudang'));
    }

    public function delete(Request $request, Response $response, Array $args)
    {
        $Meja = Resgudang::find($args['id']);
        $Meja->delete();
        $this->session->setFlash('success', 'Data Gudang Restoran telah dihapus');
        return $response->withRedirect($this->router->pathFor('gudang'));
    }

    public function ajax(Request $request, Response $response, Array $args)
    {
        $pram='';
        $postData = $request->getParsedBody();
        $id=$postData['id'];
        $id=explode("!",$id);

        $pram=$postData['pram'];//parameter
        $get=$postData['get'];//get data yg mau

        if ($pram=='code'){
           // $data = Department::whereCode($id[1])->first();
            $data = Department::find($id[1]);
        }

        if($get=='name'){
            return $data->name;
        }else if($get=='id'){
             return $data->code;
        }else{
            return "Data Anda Tidak Ada";
        }
    }

}
