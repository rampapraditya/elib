<?php

namespace App\Controllers;

use App\Models\Mcustom;
use App\Libraries\Modul;
use App\Libraries\Nativesession;

/**
 * Description of Profile
 *
 * @author rampa
 */
class Profile extends BaseController {
    
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
            $data['korps'] = $this->model->getAll("korps");
            $data['pangkat'] = $this->model->getAll("pangkat");
            $data['tersimpan'] = $this->model->getAllQR("select * from users where idusers = '".$ses['idusers']."';");
            
            
            echo view('backend/head', $data);
            echo view('backend/menu');
            echo view('backend/profile/index');
            echo view('backend/foot');
        }else{
            $this->modul->halaman('login');
        }
    }
    
    public function proses() {
        if($this->nativesession->get('logged_in')){
            $ses = $this->nativesession->get('logged_in');
            $idusers = $ses['idusers'];
            
            $data = array(
                'nrp' => $this->request->getVar('nrp'),
                'nama' => $this->request->getVar('nama'),
                'tgl_lahir' => $this->request->getVar('tgllahir'),
                'agama' => $this->request->getVar('agama'),
                'kota_asal' => $this->request->getVar('kota'),
                'satuan_kerja' => $this->request->getVar('satker'),
                'idkorps' => $this->request->getVar('korps'),
                'idpangkat' => $this->request->getVar('pangkat')
            );
            $kond['idusers'] = $idusers;
            $update = $this->model->update("users",$data,$kond);
            if($update == 1){
                $status = "Profile tersimpan";
            }else{
                $status = "Profile gagal tersimpan";
            }
            echo json_encode(array("status" => $status));
        }else{
            $this->modul->halaman('login');
        }
    }
}
