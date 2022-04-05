<?php

namespace App\Controllers;

use App\Models\Mcustom;
use App\Libraries\Modul;

class Home extends BaseController
{
    private $model;
    private $modul;
    
    public function __construct() {
        $this->model = new Mcustom();
        $this->modul= new Modul();
    }
    
    public function index() {
        $model = new Mcustom();
        
        $jml_identitas = $this->model->select_count("identitas", "kode");
        if($jml_identitas > 0){
            $tersimpan_iden = $model->getAllQR("SELECT logo, alamat, email, tlp FROM identitas;");
            $logo = base_url().'assets/images/no_image.png';
            if(strlen($tersimpan_iden->logo) > 0){
                if(file_exists($tersimpan_iden->logo)){
                    $logo = base_url().substr($tersimpan_iden->logo, 2);
                }
            }
            $data['logo'] = $logo;
            $data['alamat'] = $tersimpan_iden->alamat;
            $data['tlp'] = $tersimpan_iden->tlp;
            $data['email'] = $tersimpan_iden->email;
            
        }else{
            $data['logo'] = base_url().'assets/images/no_image.png';
            $data['alamat'] = '';
            $data['tlp'] = '';
            $data['email'] = '';
        }
        
        // about
        $jml_tentang = $this->model->select_count("tentang", "idtentang");
        if($jml_tentang > 0){
            $tersimpan_tentang = $this->model->getAllQR_nontb("tentang");
            $data['tentang'] = $tersimpan_tentang->pesan;
        }else{
            $data['tentang'] = "";
        }
        $data['jmlslider'] = $this->model->select_count("slider_tentang", "idslider_tentang");
        $data['slider'] = $this->model->getAll("slider_tentang");
        
        // media sosial
        $jml = $model->select_count("medsos", "idmedsos");
        if($jml > 0){
            $tersimpan_med = $model->getAllQR_nontb("medsos");
            $data['tw'] = $tersimpan_med->tw;
            $data['ig'] = $tersimpan_med->ig;
            $data['fb'] = $tersimpan_med->fb;
            $data['lk'] = $tersimpan_med->lk;
            
        }else{
            $data['tw'] = "";
            $data['ig'] = "";
            $data['fb'] = "";
            $data['lk'] = "";
        }
        
        $data['subkategori'] = $this->model->getAll("kategori_penelitian_sub");
        // kategori penelitian
        $data['kategori'] = $this->model->getAll("kategori_penelitian");
        // penelitian
        $data['penelitian'] = $this->model->getAllQ("select * from penelitian order by tanggal desc limit 6;");
        // berita
        $data['berita'] = $this->model->getAllQ("select *, date_format(tanggal, '%d %M %Y') as tgl from blog order by idblog desc limit 3;");
        
        echo view('frontend/index', $data);
    }
    
    public function kirimpesan() {
        $data = array(
            'idinbox' => $this->model->autokode("I","idinbox","inbox", 2, 7),
            'nama' => $this->request->getVar('nama'),
            'email' => $this->request->getVar('email'),
            'judul' => $this->request->getVar('judul'),
            'pesan' => $this->request->getVar('pesan')
        );
        $simpan = $this->model->add("inbox",$data);
        if($simpan == 1){
            $status = "Pesan tersimpan";
        }else{
            $status = "Pesan gagal tersimpan";
        }
        echo json_encode(array("status" => $status));
    }
    
    public function coba(){
        echo "Atika";
    }
}
