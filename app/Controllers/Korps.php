<?php

namespace App\Controllers;

use App\Models\Mcustom;
use App\Libraries\Modul;
use App\Libraries\Nativesession;

/**
 * Description of Korps
 *
 * @author rampa
 */
class Korps extends BaseController {
    
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
            $ses = $this->nativesession->get('logged_in');
            $data['idusers'] = $ses['idusers'];
            $data['nrp'] = $ses['nrp'];
            $data['nama'] = $ses['nama'];
            $data['golongan'] = $ses['grup'];
            
            echo view('backend/head', $data);
            echo view('backend/menu');
            echo view('backend/korps/index');
            echo view('backend/foot');
        }else{
           $this->modul->halaman('login');
        }
    }
    
    public function ajaxlist() {
        if($this->nativesession->get('logged_in')){
            $data = array();
            $list = $this->model->getAll("korps");
            foreach ($list->getResult() as $row) {
                $val = array();
                $val[] = $row->nama_korps;
                $val[] = '<div style="text-align: center;">'
                        . '<button type="button" class="btn btn-outline-primary btn-fw" onclick="ganti('."'".$row->idkorps."'".')">Ganti</button>&nbsp;'
                        . '<button type="button" class="btn btn-outline-danger btn-fw" onclick="hapus('."'".$row->idkorps."'".','."'".$row->nama_korps."'".')">Hapus</button>'
                        . '</div>';
                $data[] = $val;
            }
            $output = array("data" => $data);
            echo json_encode($output);
        }else{
            $this->modul->halaman('login');
        }
    }
    
    public function ajax_add() {
        if($this->nativesession->get('logged_in')){
            $data = array(
                'idkorps' => $this->model->autokode("K","idkorps","korps", 2, 7),
                'nama_korps' => $this->request->getVar('nama')
            );
            $simpan = $this->model->add("korps",$data);
            if($simpan == 1){
                $status = "Data tersimpan";
            }else{
                $status = "Data gagal tersimpan";
            }
            echo json_encode(array("status" => $status));
        }else{
            $this->modul->halaman('login');
        }
    }
    
    public function ganti(){
        if($this->nativesession->get('logged_in')){
            $kondisi['idkorps'] = $this->request->uri->getSegment(3);
            $data = $this->model->get_by_id("korps", $kondisi);
            echo json_encode($data);
        }else{
            $this->modul->halaman('login');
        }
    }
    
    public function ajax_edit() {
        if($this->nativesession->get('logged_in')){
            $data = array(
                'nama_korps' => $this->request->getVar('nama')
            );
            $kond['idkorps'] = $this->request->getVar('kode');
            $update = $this->model->update("korps",$data, $kond);
            if($update == 1){
                $status = "Data terupdate";
            }else{
                $status = "Data gagal terupdate";
            }
            echo json_encode(array("status" => $status));
        }else{
            $this->modul->halaman('login');
        }
    }
    
    public function hapus() {
        if($this->nativesession->get('logged_in')){
            $kondisi['idkorps'] = $this->request->uri->getSegment(3);
            $hapus = $this->model->delete("korps",$kondisi);
            if($hapus == 1){
                $status = "Data terhapus";
            }else{
                $status = "Data gagal terhapus";
            }
            echo json_encode(array("status" => $status));
        }else{
            $this->modul->halaman('login');
        }
    }
}
