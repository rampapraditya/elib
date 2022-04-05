<?php

namespace App\Controllers;

use App\Models\Mcustom;
use App\Libraries\Modul;
use App\Libraries\Nativesession;

/**
 * Description of Gantipass
 *
 * @author rampa
 */
class Gantipass extends BaseController {
    
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
            
            echo view('backend/head', $data);
            echo view('backend/menu');
            echo view('backend/gantipass/index');
            echo view('backend/foot');
        }else{
            $this->modul->halaman('login');
        }
    }
    
    public function proses() {
        if($this->nativesession->get('logged_in')){
            $ses = $this->nativesession->get('logged_in');
            $idusers = $ses['idusers'];
            
            $lama = $this->modul->enkrip_pass($this->request->getVar('lama'));
            $lama_db = $this->model->getAllQR("select pass from users where idusers = '".$idusers."';")->pass;
            
            if($lama == $lama_db){
                $data = array(
                    'pass' => $this->modul->enkrip_pass($this->request->getVar('baru'))
                );
                $kond['idusers'] = $idusers;
                $update = $this->model->update("users",$data,$kond);
                if($update == 1){
                    $status = "Password tersimpan";
                }else{
                    $status = "Password gagal tersimpan";
                }
            }else{
                $status = "Passsword lama tidak sesuai";
            }
            echo json_encode(array("status" => $status));
        }else{
            $this->modul->halaman('login');
        }
    }
}
