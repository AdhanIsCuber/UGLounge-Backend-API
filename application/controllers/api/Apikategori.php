<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH . 'controllers/api/Restdata.php';

class Apikategori extends Restdata {

  public function __construct()
  {
    parent::__construct();
    //Codeigniter : Write Less Do More
    $this->load->model(array('UGApimodel'));
    $this->checktoken();
  }

  function jabatan_get()
  {
    $id = (int) $this->get('id',true);
    $data = ($id) ? $this->UGApimodel->getKJabatanW($id) : $this->UGApimodel->getKJabatan();

    if ($data) {
      //mengembalikan respon http ok 200 dengan data dari select di atas
      $this->response($data,Restdata::HTTP_OK);
    } else {
      $this->notfound('Maaf, kategori jabatan tidak ditemukan');
    }
  }

  function jabatan_post()
  {

    $data = [
      'kjb_nama'=>$this->post('jabatan',TRUE)
    ];

    $this->form_validation->set_rules('jabatan','Jabatan','trim|max_length[30]|required',
                                array('max_length' => 'Panjang maksimal 30 karakter',
                                      'required' => 'Jabatan dibutuhkan'));
    if (!$this->form_validation->run()) {
      //mengembalikan respon bad request dengan validasi error
      $this->badreq($this->validation_errors());
    } else {
      //jika berhasil di masukan maka akan di respon kembali sesuai dengan data yang di masukan
      if ($this->UGApimodel->addKJabatan($data)) {
        $this->success('Kategori jabatan anda berhasil ditambahkan');
      } else {
        $this->badreq('Maaf, proses menambahkan jabatan gagal');
      }
    }
  }

  function jabatan_put()
  {
    $id = (int) $this->get('id',TRUE);

    //mendapatkan data json yang kemudian dilakukan json decode
    $data = json_decode(file_get_contents('php://input'),TRUE);

    $this->form_validation->set_data($data);
    $this->form_validation->set_rules('jabatan','Jabatan','trim|max_length[30]|required',
                                array('max_length' => 'Panjang maksimal 30 karakter',
                                      'required' => 'Jabatan dibutuhkan'));

    if (!$this->form_validation->run()) {
      //mengembalikan respon bad request dengan validasi error
      $this->badreq($this->validation_errors());
    }else {
      if ($this->UGApimodel->updateKJabatan($id,$data)) {
        $this->success('Kategori jabatan anda telah diperbaharui');
      }else {
        $this->badreq('Maaf, proses pembaharuan gagal');
      }
    }
  }

  function jabatan_delete()
  {
    $id = (int) $this->get('id',TRUE);

    if ($this->UGApimodel->deleteKJabatan($id)) {
      $this->success('Kategori jabatan telah terhapus');
    } else {
      $this->badreq('Maaf, proses penghapusan gagal');
    }
  }

  function pengaduan_get()
  {
    $id = (int) $this->get('id',true);
    $data = ($id) ? $this->UGApimodel->getKPengaduanW($id) : $this->UGApimodel->getKPengaduan();

    if ($data) {
      //mengembalikan respon http ok 200 dengan data dari select di atas
      $this->response($data,Restdata::HTTP_OK);
    } else {
      $this->notfound('Maaf, kategori pengaduan tidak ditemukan');
    }
  }

  function pengaduan_post()
  {

    $data = [
      'kjp_nama'=>$this->post('pengaduan',TRUE)
    ];

    $this->form_validation->set_rules('pengaduan','Pengaduan','trim|max_length[30]|required',
                                array('max_length' => 'Panjang maksimal 30 karakter',
                                      'required' => 'Kategori pengaduan dibutuhkan'));

    if (!$this->form_validation->run()) {
      //mengembalikan respon bad request dengan validasi error
      $this->badreq($this->validation_errors());
    } else {
      //jika berhasil di masukan maka akan di respon kembali sesuai dengan data yang di masukan
      if ($this->UGApimodel->addKPengaduan($data)) {
        $this->success('Kategori pengaduan anda berhasil ditambahkan');
      } else {
        $this->badreq('Maaf, proses menambahkan jabatan gagal');
      }
    }
  }

  function pengaduan_put()
  {
    $id = (int) $this->get('id',TRUE);

    //mendapatkan data json yang kemudian dilakukan json decode
    $data = json_decode(file_get_contents('php://input'),TRUE);

    $this->form_validation->set_data($data);
    $this->form_validation->set_rules('pengaduan','Pengaduan','trim|max_length[30]|required',
                                array('max_length' => 'Panjang maksimal 30 karakter',
                                      'required' => 'Kategori pengaduan dibutuhkan'));

    if (!$this->form_validation->run()) {
      //mengembalikan respon bad request dengan validasi error
      $this->badreq($this->validation_errors());
    }else {
      if ($this->UGApimodel->updateKPengaduan($id,$data)) {
        $this->success('Kategori pengaduan anda telah diperbaharui');
      }else {
        $this->badreq('Maaf, proses pembaharuan gagal');
      }
    }
  }

  function pengaduan_delete()
  {
    $id = (int) $this->get('id',TRUE);

    if ($this->UGApimodel->deleteKPengaduan($id)) {
      $this->success('Kategori pengaduan telah terhapus');
    } else {
      $this->badreq('Maaf, proses penghapusan gagal');
    }
  }

}
