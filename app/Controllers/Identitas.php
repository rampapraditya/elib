<?php

namespace App\Controllers;

use App\Models\Mcustom;
use App\Libraries\Modul;
use App\Libraries\Nativesession;
use CodeIgniter\Controller;

/**
 * Description of Identitas
 *
 * @author RAMPA
 */
class Identitas extends Controller{
    
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
            
            $jml_identitas = $this->model->getAllQR("SELECT count(*) as jml FROM identitas;")->jml;
            if($jml_identitas > 0){
                $tersimpan = $this->model->getAllQR("SELECT * FROM identitas;");
                $data['instansi'] = $tersimpan->instansi;
                $data['slogan'] = $tersimpan->slogan;
                $data['tahun'] = $tersimpan->tahun;
                $data['pimpinan'] = $tersimpan->pimpinan;
                $data['alamat'] = $tersimpan->alamat;
                $data['kdpos'] = $tersimpan->kdpos;
                $data['tlp'] = $tersimpan->tlp;
                $data['fax'] = $tersimpan->fax;
                $data['website'] = $tersimpan->website;
                $deflogo = base_url().'/assets/img/noimg.jpg';
                if(strlen($tersimpan->logo) > 0){
                    if(file_exists($tersimpan->logo)){
                        $deflogo = base_url().substr($tersimpan->logo, 1);
                    }
                }
                $data['logo'] = $deflogo;
                $data['lat'] = $tersimpan->lat;
                $data['lon'] = $tersimpan->lon;
                $data['email'] = $tersimpan->email;
                
            }else{
                $data['instansi'] = "";
                $data['slogan'] = "";
                $data['tahun'] = "";
                $data['pimpinan'] = "";
                $data['alamat'] = "";
                $data['tlp'] = "";
                $data['fax'] = "";
                $data['website'] = "";
                $data['logo'] = base_url().'/assets/img/noimg.jpg';
                $data['lat'] = "";
                $data['lon'] = "";
                $data['email'] = "";
            }
                
            echo view('backend/head', $data);
            echo view('backend/menu');
            echo view('backend/identitas/index');
            echo view('backend/foot');
        }else{
            $this->modul->halaman('login');
        }
    }
    
    public function proses() {
        if($this->nativesession->get('logged_in')){
            $mode = "simpan";
            $jml = $this->model->getAllQR("SELECT count(*) as jml FROM identitas;")->jml;
            if($jml > 0){
                $mode = "update";
            }

            if (isset($_FILES['file']['name'])) {
                if(0 < $_FILES['file']['error']) {
                    $status = "Error during file upload ".$_FILES['file']['error'];
                }else{
                    if($mode == "simpan"){
                        $status = $this->simpandenganfoto();
                    }else if($mode == "update"){
                        $status = $this->updatedenganfoto();
                    }
                }
            }else{
                if($mode == "simpan"){
                    $status = $this->simpantanpafoto();
                }else if($mode == "update"){
                    $status = $this->updatetanpafoto();
                }
            }
            echo json_encode(array("status" => $status));
        }else{
            $this->modul->halaman('login');
        }
    }
    
    private function simpandenganfoto($config) {
        $this->load->library('upload', $config);
        if ($this->upload->do_upload('file')) {

            $datafile = $this->upload->data();
            $path = $config['upload_path'].$datafile['file_name'];
            $newpath = $config['upload_newpath'].$datafile['file_name'];

            $resize_foto = $this->resizeImage($path, $newpath);
            if($resize_foto){
                $data = array(
                    'kode' => $this->model->autokode('I','kode', 'identitas', 2, 7),
                    'instansi' => $this->input->getVar('nama'),
                    'slogan' => $this->input->getVar('slogan'),
                    'tahun' => $this->input->getVar('tahun'),
                    'pimpinan' => $this->input->getVar('pimpinan'),
                    'alamat' => $this->input->getVar('alamat'),
                    'kdpos' => $this->input->getVar('kdpos'),
                    'tlp' => $this->input->getVar('tlp'),
                    'fax' => $this->input->getVar('fax'),
                    'email' => $this->input->getVar('email'),
                    'website' => $this->input->getVar('web'),
                    'logo' => $newpath,
                    'lat' => $this->input->getVar('lat'),
                    'lon' => $this->input->getVar('lon')
                );
                $simpan = $this->model->add("identitas",$data);
                if($simpan == 1){
                    unlink($path);
                    $status = "Identitas tersimpan";
                }else{
                    $status = "Identitas gagal tersimpan";
                }
            }else{
                $status = "Resize foto gagal";
            }
        } else {
            $status = $this->upload->display_errors();
        }
        return $status;
    }
    
    private function updatedenganfoto() {
        $logo = $this->model->getAllQR("SELECT logo FROM identitas;")->logo;
        if(strlen($logo) > 0){
            if(file_exists(ROOTPATH.'public/uploads/'.$logo)){
                unlink(ROOTPATH.'public/uploads/'.$logo); 
            }
        }
        
        $file = $this->request->getFile('file');
        $info_file = $this->modul->info_file($file);
        
        // cek nama file ada apa tidak
        if(file_exists(ROOTPATH.'public/uploads/'.$info_file['name'])){
            $status = "Gunakan nama file lain";
        }else{
            $status_upload = $file->move(ROOTPATH.'public/uploads');
            if($status_upload){
                $data = array(
                    'instansi' => $this->request->getVar('nama'),
                    'slogan' => $this->request->getVar('slogan'),
                    'tahun' => $this->request->getVar('tahun'),
                    'pimpinan' => $this->request->getVar('pimpinan'),
                    'alamat' => $this->request->getVar('alamat'),
                    'kdpos' => $this->request->getVar('kdpos'),
                    'tlp' => $this->request->getVar('tlp'),
                    'fax' => $this->request->getVar('fax'),
                    'email' => $this->request->getVar('email'),
                    'website' => $this->request->getVar('web'),
                    'lat' => $this->request->getVar('lat'),
                    'lon' => $this->request->getVar('lon'),
                    'logo' => $info_file['name']
                );
                $update = $this->model->updateNK("identitas",$data);
                if($update == 1){
                    $status = "Identitas terupdate";
                }else{
                    $status = "Identitas gagal terupdate";
                }
            }else{
                $status = "File gagal terupload";
            }
        }
        
        return $status;
    }
    
    private function simpantanpafoto() {
        $data = array(
            'kode' => $this->model->autokode('I','kode', 'identitas', 2, 7),
            'instansi' => $this->input->getVar('nama'),
            'slogan' => $this->input->getVar('slogan'),
            'tahun' => $this->input->getVar('tahun'),
            'pimpinan' => $this->input->getVar('pimpinan'),
            'alamat' => $this->input->getVar('alamat'),
            'kdpos' => $this->input->getVar('kdpos'),
            'tlp' => $this->input->getVar('tlp'),
            'fax' => $this->input->getVar('fax'),
            'email' => $this->input->getVar('email'),
            'website' => $this->input->getVar('web'),
            'logo' => '',
            'lat' => $this->input->getVar('lat'),
            'lon' => $this->input->getVar('lon')
        );
        $simpan = $this->model->add("identitas",$data);
        if($simpan == 1){
            $status = "Identitas tersimpan";
        }else{
            $status = "Identitas gagal tersimpan";
        }
        return $status;
    }
    
    private function updatetanpafoto() {
        $data = array(
            'instansi' => $this->request->getVar('nama'),
            'slogan' => $this->request->getVar('slogan'),
            'tahun' => $this->request->getVar('tahun'),
            'pimpinan' => $this->request->getVar('pimpinan'),
            'alamat' => $this->request->getVar('alamat'),
            'kdpos' => $this->request->getVar('kdpos'),
            'tlp' => $this->request->getVar('tlp'),
            'fax' => $this->request->getVar('fax'),
            'email' => $this->request->getVar('email'),
            'website' => $this->request->getVar('web'),
            'lat' => $this->request->getVar('lat'),
            'lon' => $this->request->getVar('lon')
        );
        $update = $this->model->updateNK("identitas",$data);
        if($update == 1){
            $status = "Identitas terupdate";
        }else{
            $status = "Identitas gagal terupdate";
        }
        return $status;
    }
    
    private function resizeImage($path, $newpath){
        $config_manip = array(
            'image_library' => 'gd2',
            'source_image' => $path,
            'new_image' => $newpath,
            'maintain_ratio' => TRUE,
            'width' => 150,
            'height' => 150
        );
        $this->load->library('image_lib', $config_manip);
        $hasil = $this->image_lib->resize();
        $this->image_lib->clear();
        return $hasil;
    }
}
