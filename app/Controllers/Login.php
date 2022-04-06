<?php

namespace App\Controllers;

use App\Models\Mcustom;
use App\Libraries\Modul;
use App\Libraries\Nativesession;

/**
 * Description of Login
 *
 * @author RAMPA
 */
class Login extends BaseController{
    
    private $model;
    private $modul;
    private $nativesession;
    
    public function __construct() {
        $this->model = new Mcustom();
        $this->modul= new Modul();
        $this->nativesession = new Nativesession();
    }
    
    public function index() {
        if($this->nativesession->get('logged_in')){
            $this->modul->halaman('beranda');
        }else{
           echo view('backend/login');
        }
    }
    
    public function proses() {
        clearstatcache();
        
        $user = strtolower(trim($this->request->getVar('nrp')));
        $pass = trim($this->request->getVar('pass'));
        
        $enkrip_pass = $this->modul->enkrip_pass($pass);
        $jml = $this->model->getAllQR("SELECT count(*) as jml FROM users where nrp = '".$user."';")->jml;
        if($jml > 0){
            $jml1 = $this->model->getAllQR("select count(*) as jml from users where nrp = '".$user."' and pass = '".$enkrip_pass."';")->jml;
            if($jml1 > 0){
                $data = $this->model->getAllQR("select idusers, nrp, nama, idrole from users where nrp = '".$user."';");
                
                $this->nativesession->set('subfolder', $data->idusers);
                $this->nativesession->set('tautan_utama', substr(base_url(), 0, strlen(base_url())-1));
                // membuat folder
                $path_source = ROOTPATH."public/media/".$data->idusers;
                $path_thumbs = ROOTPATH."public/thumbs/".$data->idusers;
                $this->modul->buat_folder($path_source);
                $this->modul->buat_folder($path_thumbs);

                $sess_array = array('idusers' => $data->idusers, 'nrp' => $data->nrp, 'nama' => $data->nama, 'grup' => $data->idrole);
                $this->nativesession->set('logged_in', $sess_array);    
                $status = "ok";
                
            }else{
                $status = "Anda tidak berhak mengakses !";
            }
        }else{
            // cek pada table siswa
            $jml_siswa = $this->model->getAllQR("SELECT count(*) as jml FROM pengguna where nrp = '".$user."';")->jml;
            if($jml_siswa > 0){
                $jml2 = $this->model->getAllQR("select count(*) as jml from pengguna where nrp = '".$user."' and pass = '".$enkrip_pass."';")->jml;
                if($jml2 > 0){
                    $data_siswa = $this->model->getAllQR("select idsiswa, nrp, nama from pengguna where nrp = '".$user."';");
                    
                    $sess_array = array('idusers' => $data_siswa->idsiswa, 'nrp' => $data_siswa->nrp, 'nama' => $data_siswa->nama, 'grup' => "siswa");
                    $this->nativesession->set('logged_siswa', $sess_array);    
                    $status = "ok_siswa";
                }else{
                    $status = "Anda tidak berhak mengakses !";
                }
            }else{
                $status = "Maaf, user tidak ditemukan !";
            }
        }
        echo json_encode(array("status" => $status));   
    }
    
    public function logout(){
        $this->nativesession->delete('subfolder');
        $this->nativesession->delete('tautan_utama');
        $this->nativesession->delete('logged_in');
        clearstatcache();
        
        $this->modul->halaman('home');
    }
    
    public function logoutsiswa(){
        $this->nativesession->delete('logged_siswa');
        clearstatcache();
        
        $this->modul->halaman('home');
    }
}
