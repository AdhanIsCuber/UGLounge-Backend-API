<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH . 'controllers/api/Restdata.php';

class Apipengaduan extends Restdata {

  public function __construct()
  {
    parent::__construct();
    //Codeigniter : Write Less Do More
    $this->load->model(array('UGApimodel'));
    $this->checktoken();
  }

  function pengaduan_get()
  {
    $id = (int) $this->get('id',true);

    $data = ($id) ? $this->UGApimodel->getPengaduanW($id) : $this->UGApimodel->getPengaduan();

    if ($data) {
      //mengembalikan respon http ok 200 dengan data dari select di atas
      $this->response($data,Restdata::HTTP_OK);
    } else {
      $this->notfound('Maaf, pengaduan tidak ditemukan');
    }
  }

  function pengaduan_post()
  {

    $listPengguna  = implode(',',array_column($this->UGApimodel->selectPengguna(),'pn_id'));
    $listKategori  = implode(',',array_column($this->UGApimodel->selectkPengaduan(),'kjp_id'));

    $data = [
      'pn_id'=>$this->post('pengguna',TRUE),
      'kjp_id'=>$this->post('pengaduan',TRUE),
      'pg_judul'=>$this->post('judul',TRUE),
      'pg_deskripsi'=>$this->post('deskripsi',TRUE),
      'pg_media'=>$this->post('media',TRUE)
    ];

    $this->form_validation->set_rules('pengguna','Pengguna','trim|max_length[11]|required|numeric|in_list['.$listPengguna.']',
                                  array('max_length' => 'Panjang maksimal 11 karakter',
                                        'required' => 'Pengguna dibutuhkan',
                                        'numeric' => 'Karakter harus berupa numeric',
                                        'in_list' => 'Pengguna tidak terdaftar'));
    $this->form_validation->set_rules('pengaduan','Pengaduan','trim|max_length[11]|required|numeric|in_list['.$listKategori.']',
                                  array('max_length' => 'Panjang maksimal 11 karakter',
                                        'required' => 'Kategori Pengaduan dibutuhkan',
                                        'numeric' => 'Karakter harus berupa numeric',
                                        'in_list' => 'Kategori yang anda masukkan salah'));
    $this->form_validation->set_rules('judul','Judul','trim|max_length[48]|required',
                                  array('max_length' => 'Panjang maksimal 48 karakter',
                                        'required' => 'Judul dibutuhkan'));
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
      if ($this->UGApimodel->addPengaduan($data)) {
        $this->success('Pengaduan anda sudah dilaporkan');
      } else {
        $this->badreq('Maaf, proses pengaduan gagal');
      }
    }
  }

  function pengaduan_put()
  {
    $id = (int) $this->get('id',TRUE);

    $listKategori  = implode(',',array_column($this->UGApimodel->selectkPengaduan(),'kjp_id'));

    //mendapatkan data json yang kemudian dilakukan json decode
    $data = json_decode(file_get_contents('php://input'),TRUE);

    $this->form_validation->set_data($data);
    $this->form_validation->set_rules('pengaduan','Pengaduan','trim|max_length[11]|required|numeric|in_list['.$listKategori.']',
                                  array('max_length' => 'Panjang maksimal 11 karakter',
                                        'required' => 'Kategori Pengaduan dibutuhkan',
                                        'numeric' => 'Karakter harus berupa numeric.',
                                        'in_list' => 'Kategori yang anda masukkan salah'));
    $this->form_validation->set_rules('judul','Judul','trim|max_length[48]|required',
                                  array('max_length' => 'Panjang maksimal 48 karakter',
                                        'required' => 'Judul dibutuhkan'));
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
      if ($this->UGApimodel->updatePengaduan($id,$data)) {
        $this->success('Pengaduan anda telah diperbaharui');
      } else {
        $this->badreq('Maaf, proses pembaharuan gagal');
      }
    }
  }

  function pengaduan_delete()
  {
    $id = (int) $this->get('id',TRUE);

    if ($this->UGApimodel->deletePengaduan($id)) {
      $this->success('Pengaduan berhasil dihapus');
    } else {
      $this->badreq('Maaf, proses penghapusan gagal');
    }
  }

}
