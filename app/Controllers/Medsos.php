<?php

namespace App\Controllers;

use App\Models\Mcustom;
use App\Libraries\Modul;
use App\Libraries\Nativesession;

/**
 * Description of Medsos
 *
 * @author rampa
 */
class Medsos extends BaseController {
    
    private $model;
    private $modul;
    private $nativesession;
    
    public function __construct() {
        $this->model = new Mcustom();
        $this->modul= new Modul();
        $this->nativesession = new Nativesession();
    }
    
    public function index(){
        if($this->nativesession->get('logged_in')){
            $ses = $this->nativesession->get('logged_in');
            $data['idusers'] = $ses['idusers'];
            $data['nrp'] = $ses['nrp'];
            $data['nama'] = $ses['nama'];
            $data['golongan'] = $ses['grup'];
            
            $jml = $this->model->getAllQR("select count(*) as jml from medsos;")->jml;
            if($jml > 0){
                $tersimpan = $this->model->getAllQR("select * from medsos;");
                $data['tw'] = $tersimpan->tw;
                $data['ig'] = $tersimpan->ig;
                $data['fb'] = $tersimpan->fb;
                $data['lk'] = $tersimpan->lk;
            }else{
                $data['tw'] = "";
                $data['ig'] = "";
                $data['fb'] = "";
                $data['lk'] = "";
            }
            
            echo view('backend/head', $data);
            echo view('backend/menu');
            echo view('backend/medsos/index');
            echo view('backend/foot');
        }else{
            $this->modul->halaman('login');
        }
    }
    
    public function proses() {
        if($this->nativesession->get('logged_in')){
            $jml = $this->model->getAllQR("select count(*) as jml from medsos;")->jml;
            if($jml > 0){
                $status = $this->ganti();
            }else{
                $status = $this->simpan();
            }
            echo json_encode(array("status" => $status));
        }else{
            $this->modul->halaman('login');
        }
    }
    
    private function simpan() {
        $data = array(
            'idmedsos' => $this->model->autokode('M', "idmedsos", "medsos", 2, 7),
            'tw' => $this->request->getVar('tw'),
            'fb' => $this->request->getVar('fb'),
            'ig' => $this->request->getVar('ig'),
            'lk' => $this->request->getVar('lk')
        );
        $update = $this->model->add("medsos",$data);
        if($update == 1){
            $status = "Data tersimpan";
        }else{
            $status = "Data gagal tersimpan";
        }
        return $status;
    }
    
    private function ganti() {
        $data = array(
            'tw' => $this->request->getVar('tw'),
            'fb' => $this->request->getVar('fb'),
            'ig' => $this->request->getVar('ig'),
            'lk' => $this->request->getVar('lk')
        );
        $update = $this->model->updateNK("medsos",$data);
        if($update == 1){
            $status = "Data tersimpan";
        }else{
            $status = "Data gagal tersimpan";
        }
        return $status;
    }
}
