<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH . 'controllers/api/Restdata.php';

class Apikomentar extends Restdata {

  public function __construct()
  {
    parent::__construct();
    //Codeigniter : Write Less Do More
    $this->load->model(array('UGApimodel'));
    $this->checktoken();
  }

  function komentar_get()
  {
    $id = (int) $this->get('id',true);
    $data = ($id) ? $this->UGApimodel->getKomentarW($id) : $this->UGApimodel->getKomentar();

    if ($data) {
      //mengembalikan respon http ok 200 dengan data dari select di atas
      $this->response($data,Restdata::HTTP_OK);
    } else {
      $this->notfound('Maaf, komentar tidak ditemukan');
    }
  }

  function komentar_post()
  {
    $listPengaduan  = implode(',',array_column($this->UGApimodel->selectkPengaduan(),'kjp_id'));
    $listPengguna  = implode(',',array_column($this->UGApimodel->selectPengguna(),'pn_id'));

    $data = [
      'pg_id'=>$this->post('pengaduan',TRUE),
      'pn_id'=>$this->post('pengguna',TRUE),
      'km_deskripsi'=>$this->post('deskripsi',TRUE),
      'km_media'=>$this->post('media',TRUE)
    ];

    $this->form_validation->set_rules('pengaduan','Pengaduan','trim|max_length[11]|required|numeric|in_list['.$listPengaduan.']',
                                array('max_length' => 'Panjang maksimal 11 karakter',
                                      'required' => 'Pengaduan ID dibutuhkan',
                                      'numeric' => 'Karakter harus berupa numeric',
                                      'in_list' => 'Pengaduan yang anda masukkan salah'));
    $this->form_validation->set_rules('pengguna','Pengguna','trim|max_length[11]|required|numeric|in_list['.$listPengguna.']',
                                array('max_length' => 'Panjang maksimal 11 karakter',
                                      'required' => 'Pengguna ID dibutuhkan',
                                      'numeric' => 'Karakter harus berupa numeric',
                                      'in_list' => 'Pengguna tidak terdaftar'));
    $this->form_validation->set_rules('deskripsi','Deskripsi','trim|max_length[200]|required',
                                  array('max_length' => 'Panjang maksimal 200 karakter',
                                        'required' => 'Deskripsi dibutuhkan'));
    $this->form_validation->set_rules('media','Media','trim|max_length[128]|required',
                                  array('max_length' => 'Panjang maksimal 128 karakter',
                                        'required' => 'Media dibutuhkan'));
    if (!$this->form_validation->run()) {
      //mengembalikan respon bad request dengan validasi error
      $this->badreq($this->validation_errors());
    } else {
      //jika berhasil di masukan maka akan di respon kembali sesuai dengan data yang di masukan
      if ($this->UGApimodel->addKomentar($data)) {
        $this->success('Komentar anda berhasil ditambahkan');
      } else {
        $this->badreq('Maaf, proses menambahkan komentar gagal');
      }
    }
  }

  function komentar_put()
  {
    $id = (int) $this->get('id',TRUE);

    //mendapatkan data json yang kemudian dilakukan json decode
    $data = json_decode(file_get_contents('php://input'),TRUE);

    $this->form_validation->set_data($data);
    $this->form_validation->set_rules('deskripsi','Deskripsi','trim|max_length[200]|required',
                                array('max_length' => 'Panjang maksimal 200 karakter',
                                      'required' => 'Deskripsi dibutuhkan'));
    $this->form_validation->set_rules('media','Media','trim|max_length[128]|required',
                                array('max_length' => 'Panjang maksimal 128 karakter',
                                      'required' => 'Media dibutuhkan'));

    if (!$this->form_validation->run()) {
      //mengembalikan respon bad request dengan validasi error
      $this->badreq($this->validation_errors());
    }else {
      if ($this->UGApimodel->updateKomentar($id,$data)) {
        $this->success('Komentar anda telah diperbaharui');
      }else {
        $this->badreq('Maaf, proses pembaharuan gagal');
      }
    }
  }

  function komentar_delete()
  {
    $id = (int) $this->get('id',TRUE);

    if ($this->UGApimodel->deleteKomentar($id)) {
      $this->success('Komentar telah terhapus');
    } else {
      $this->badreq('Maaf, proses penghapusan gagal');
    }
  }

}
