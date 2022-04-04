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
 * Description of Blogsingle
 *
 * @author RAMPA
 */
class Blogsingle extends BaseController {
    
    private $model;
    private $modul;
    
    public function __construct() {
        $this->model = new Mcustom();
        $this->modul= new Modul();
    }
    
    public function index() {
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
            $data['logo'] = base_url().'/assets/images/no_image.png';
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
            $jml = $this->model->getAllQR("select count(*) as jml from blog where idblog = '".$kode."';")->jml;
            if($jml > 0){
                $tersimpan_berita = $this->model->getAllQR("select a.*, date_format(tanggal, '%d %M %Y') as tgl, b.nama from blog a, users b where a.idusers = b.idusers and a.idblog = '".$kode."';");
                $defthumb = base_url().'/assets/img/noimg.jpg';
                if(strlen($tersimpan_berita->thumb) > 0){
                    if(file_exists($tersimpan_berita->thumb)){
                        $defthumb = base_url().substr($tersimpan_berita->thumb, 1);
                    }
                }
                $data['thumb'] = $defthumb;
                $data['kode'] = $tersimpan_berita->idblog;
                $data['judul'] = $tersimpan_berita->judul;
                $data['tanggal'] = $tersimpan_berita->tgl;
                $data['penulis'] = $tersimpan_berita->nama;
                $data['konten'] = $tersimpan_berita->konten;
                $data['jml_komentar'] = $this->model->getAllQR("select count(*) as jml from blog_komentar where idblog = '".$tersimpan_berita->idblog."';")->jml;
                
                // berita lainnya
                $data['beritalain'] = $this->model->getAllQ("select *, date_format(tanggal,'%d %M %Y') as tgl from blog where idblog <> '".$tersimpan_berita->idblog."';");
                
                
                echo view('frontend/blogsingle', $data);
            }else{
                $this->modul->halaman("welcome");
            }
        }else{
            $this->modul->halaman("welcome");
        }
    }
    
    public function ajax_komentar() {
        $idblog = $this->request->uri->getSegment(3);
        
        $str = '';
        $listkomentar = $this->model->getAllQ("SELECT email, nama, komentar, date_format(tanggal, '%d %M %Y') as tgl, time(tanggal) as wkt FROM blog_komentar where idblog = '".$idblog."';");
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
            'idblog_komentar' => $this->model->autokode("K","idblog_komentar","blog_komentar", 2, 7),
            'nama' => $this->request->getVar('nama'),
            'email' => $this->request->getVar('email'),
            'komentar' => $this->request->getVar('komentar'),
            'idblog' => $this->request->getVar('kode'),
            'tanggal' => $this->modul->TanggalWaktu()
        );
        $simpan = $this->model->add("blog_komentar",$data);
        if($simpan == 1){
            $status = "Komentar tersimpan";
        }else{
            $status = "Komentar gagal tersimpan";
        }
        echo json_encode(array("status" => $status));
    }
}
