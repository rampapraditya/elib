<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Controllers;

use App\Models\Mcustom;
use App\Libraries\Modul;

/**
 * Description of Singlepenelitian
 *
 * @author RAMPA
 */
class Singlepenelitian extends BaseController {
    
    private $model;
    private $modul;
    
    public function __construct() {
        $this->model = new Mcustom();
        $this->modul= new Modul();
    }
    
    public function index() {
        // identitas
        $jml_identitas = $this->model->getAllQR("SELECT count(*) as jml FROM identitas;")->jml;
        if($jml_identitas > 0){
            $tersimpan_iden = $this->model->getAllQR("SELECT logo, alamat, email, tlp FROM identitas;");
            $logo = base_url().'/assets/images/no_image.png';
            if(strlen($tersimpan_iden->logo) > 0){
                if(file_exists($tersimpan_iden->logo)){
                    $logo = base_url().substr($tersimpan_iden->logo, 1);
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
        $jml_tentang = $this->model->getAllQR("SELECT count(*) as jml FROM tentang;")->jml;
        if($jml_tentang > 0){
            $tersimpan_tentang = $this->model->getAllQR("select * from tentang;");
            $data['tentang'] = $tersimpan_tentang->pesan;
        }else{
            $data['tentang'] = "";
        }
        
        // media sosial
        $jml = $this->model->getAllQR("select count(*) as jml from medsos")->jml;
        if($jml > 0){
            $tersimpan_med = $this->model->getAllQR("select * from medsos");
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
        
        $temp = $this->request->uri->getSegment(3);
        if(strlen($temp) > 0){
            $kode = $this->modul->dekrip_url($temp);
            $jml = $this->model->getAllQR("select count(*) as jml from penelitian where idpenelitian = '".$kode."';")->jml;
            if($jml > 0){
                $penelitian = $this->model->getAllQR("select a.*, date_format(a.tanggal, '%d %M %Y') as tgl, time(tanggal) as wkt, b.nama_kategori from penelitian a, kategori_penelitian b where a.idkategori = b.idkategori and a.idpenelitian = '".$kode."';");
                $defthumb = base_url().'/assets/img/noimg.jpg';
                if(strlen($penelitian->thumbnail) > 0){
                    if(file_exists($penelitian->thumbnail)){
                        $defthumb = base_url().substr($penelitian->thumbnail, 1);
                    }
                }
                
                $data['thumb'] = $defthumb;
                $data['kode'] = $penelitian->idpenelitian;
                $data['judul'] = $penelitian->judul;
                $data['tanggal'] = $penelitian->tgl;
                $data['penulis'] = "Administrator";
                $data['foto_penulis'] = $data['logo'];
                $data['konten'] = $penelitian->sinopsis;
                $data['kategori'] = $penelitian->nama_kategori;
                $data['keyword'] = $penelitian->katakunci;
                $data['jml_komentar'] = $this->model->getAllQR("select count(*) as jml from penelitian_komentar where idpenelitian = '".$penelitian->idpenelitian."';")->jml;
                if(strlen($penelitian->sandi) > 0){
                    $data['rahasia'] = "ya";
                }else{
                    $data['rahasia'] = "tidak";
                }
                
                // lainnya
                $data['lainnya'] = $this->model->getAllQ("select *, date_format(tanggal, '%d %M %Y') as tgl from penelitian where idpenelitian <> '".$penelitian->idpenelitian."' order by tanggal desc;");
                
                // dokumen
                $data['dokumen'] = $this->model->getAllQ("SELECT * FROM dokumen where idpenelitian = '".$penelitian->idpenelitian."';");
                
                echo view('frontend/singlepenelitian', $data);
            }else{
                $this->modul->halaman("welcome");
            }
        }else{
            $this->modul->halaman("welcome");
        } 
    }
    
    public function ajax_komentar() {
        $kode = $this->request->uri->getSegment(3);
        
        $str = '';
        $listkomentar = $this->model->getAllQ("SELECT email, nama, komentar, date_format(tanggal, '%d %M %Y') as tgl, time(tanggal) as wkt FROM penelitian_komentar where idpenelitian = '".$kode."';");
        foreach ($listkomentar->getResult() as $row) {
            $str .= '<div class="d-flex">
                        <div>
                            <h5>'.$this->modul->antixss($row->nama).'</h5>
                            <time>'.$row->tgl.' '.$row->wkt.'</time>
                            <p>'.$this->modul->antixss($row->komentar).'</p>
                        </div>
                    </div>
                    <hr>';
        }
        echo $str;
    }
    
    public function proseskomentar() {
        $data = array(
            'idkomen' => $this->model->autokode("K","idkomen","penelitian_komentar", 2, 7),
            'nama' => $this->request->getVar('nama'),
            'email' => $this->request->getVar('email'),
            'komentar' => $this->request->getVar('komentar'),
            'tanggal' => $this->modul->TanggalWaktu(),
            'idpenelitian' => $this->request->getVar('kode')
        );
        $simpan = $this->model->add("penelitian_komentar",$data);
        if($simpan == 1){
            $status = "Komentar tersimpan";
        }else{
            $status = "Komentar gagal tersimpan";
        }
        echo json_encode(array("status" => $status));
    }
    
    public function unduhfile() {
        if($this->nativesession->get('logged_siswa')){
            $ses = $this->nativesession->get('logged_siswa');
            $idusers = $ses['idusers'];
            
            $this->load->helper('download');
            $kode = $this->uri->segment(3);
            
            // mencari kode penelitian dari iddokumen
            $idpenelitian = $this->model->getAllQR("SELECT idpenelitian FROM dokumen where iddokumen = '".$kode."';")->idpenelitian;
            
            // cek dia sudah download brp x hari ini
            $jml_download = $this->model->getAllQR("SELECT count(*) as jml FROM logdownload where idsiswa = '".$idusers."' and tanggal = '".$this->modul->TanggalSekarang()."';")->jml;
            if($jml_download > 2){
                $this->modul->pesan_halaman("Batas download 3 penelitian setiap hari", "listpenelitian");
            }else{
                // simpan log
                $data = array(
                    'idlog' => $this->model->autokode("L","idlog","logdownload", 2, 7),
                    'idsiswa' => $idusers,
                    'tanggal' => $this->modul->TanggalWaktu(),
                    'idpenelitian' => $idpenelitian,
                    'iddokumen' => $kode
                );
                $simpan = $this->model->add("logdownload",$data);
                if($simpan == 1){
                    $tmt2 = $this->model->getAllQR("select path from dokumen where iddokumen = '".$kode."';")->path;
                    force_download($tmt2, null);
                }else{
                    $status = "Gagal menyimpan log unduh";
                    $this->modul->pesan_halaman($status, "listpenelitian");
                }
            }
        }else{
            $this->modul->halaman('login');
        }
    }
    
    public function ceksandi() {
        if($this->nativesession->get('logged_siswa')){
            $idpenelitian = $this->input->post('kode');
            $sandi_input = $this->input->post('sandi');
            
            // mencari password tersimpan
            $sandi_tersimpan = $this->model->getAllQR("select sandi from penelitian where idpenelitian = '".$idpenelitian."';")->sandi;
            if($sandi_input == $sandi_tersimpan){
                $status = "oke";
            }else{
                $status = "Sandi dokumen salah";
            }
            echo json_encode(array("status" => $status));
        }else{
            $this->modul->halaman('login');
        }
    }
}
