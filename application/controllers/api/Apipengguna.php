<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH . 'controllers/api/Restdata.php';

class Apipengguna extends Restdata {

  public function __construct()
  {
    parent::__construct();
    //Codeigniter : Write Less Do More
    $this->load->model(array('UGApimodel'));
    //$this->cektoken();
  }

  function pengguna_get()
  {
    $this->checktoken();
    $id = (int) $this->get('id',true);
    $data = ($id) ? $this->UGApimodel->getPenggunaW($id) : $this->UGApimodel->getPengguna();

    if ($data) {
      //mengembalikan respon http ok 200 dengan data dari select di atas
      $this->response($data,Restdata::HTTP_OK);
    } else {
      $this->notfound('Maaf, pengguna tidak ditemukan');
    }
  }

  function pengguna_post()
  {
    $listJabatan  = implode(',',array_column($this->UGApimodel->selectkJabatan(),'kjb_id'));

    $data = [
      'kjb_id' => $this->post('jabatan'),
      'pn_nama' => $this->post('nama'),
      'pn_namalengkap' => $this->post('nama_lengkap'),
      'pn_sandi' => password_hash($this->post('sandi'),PASSWORD_DEFAULT),
      'pn_kelamin' => $this->post('kelamin'),
      'pn_status' => "Silahkan isi status anda.",
      'pn_jumlahpengaduan' => 0,
      'pn_telepon' => $this->post('telepon'),
      'pn_email' => $this->post('email'),
      'pn_foto' => "user.png"
    ];

    $this->form_validation->set_rules('jabatan','Jabatan','trim|max_length[11]|required|numeric|in_list['.$listJabatan.']',
                                  array('max_length' => 'Panjang maksimal 11 karakter',
                                        'required' => 'Jabatan dibutuhkan',
                                        'numeric' => 'Karakter harus berupa numeric',
                                        'in_list' => 'Jabatan yang anda masukkan salah'));
    $this->form_validation->set_rules('nama','Nama','trim|max_length[24]|required|is_unique[daftar_pengguna.pn_nama]',
                                  array('max_length' => 'Panjang maksimal 24 karakter',
                                        'required' => 'Pengguna dibutuhkan',
                                        'is_unique' => 'Pengguna sudah terdaftar'));
    $this->form_validation->set_rules('nama_lengkap','Nama Lengkap','trim|max_length[32]|required',
                                  array('max_length' => 'Panjang maksimal 32 karakter',
                                        'required' => 'Nama lengkap dibutuhkan'));
    $this->form_validation->set_rules('sandi','Sandi','trim|max_length[128]|required',
                                  array('max_length' => 'Panjang maksimal 128 karakter',
                                        'required' => 'Deskripsi dibutuhkan'));
    $this->form_validation->set_rules('kelamin','Kelamin','trim|max_length[16]|required',
                                  array('max_length' => 'Panjang maksimal 16 karakter',
                                        'required' => 'Jenis kelamin dibutuhkan'));
    $this->form_validation->set_rules('telepon','Telepon','trim|max_length[16]|required|numeric',
                                  array('max_length' => 'Panjang maksimal 16 karakter',
                                        'required' => 'Nomor telepon dibutuhkan',
                                        'numeric' => 'Karakter harus berupa numeric'));
    $this->form_validation->set_rules('email','Email','trim|max_length[128]|required|is_unique[daftar_pengguna.pn_email]',
                                  array('max_length' => 'Panjang maksimal 128 karakter',
                                        'required' => 'Alamat email dibutuhkan',
                                        'is_unique' => 'Alamat email sudah terdaftar'));

    if ($this->form_validation->run()==false) {
      $this->badreq($this->validation_errors());
    } else {
      if ($this->UGApimodel->addPengguna($data)) {
        $this->success('Selamat anda berhasil terdaftar');
      } else {
        $this->badreq('Maaf, kami tidak dapat memproses pendaftaran anda');
      }
    }
  }

  function pengguna_put()
  {
    $this->checktoken();
    $id = (int) $this->get('id',TRUE);

    //mendapatkan data json yang kemudian dilakukan json decode
    $data = json_decode(file_get_contents('php://input'),TRUE);

    $this->form_validation->set_data($data);
    $this->form_validation->set_rules('nama_lengkap','Nama Lengkap','trim|max_length[32]|required',
                                  array('max_length' => 'Panjang maksimal 32 karakter',
                                        'required' => 'Nama lengkap dibutuhkan'));
    $this->form_validation->set_rules('sandi','Sandi','trim|max_length[128]|required',
                                  array('max_length' => 'Panjang maksimal 128 karakter',
                                        'required' => 'Deskripsi dibutuhkan'));
    $this->form_validation->set_rules('kelamin','Kelamin','trim|max_length[16]|required',
                                  array('max_length' => 'Panjang maksimal 16 karakter',
                                        'required' => 'Jenis kelamin dibutuhkan'));
    $this->form_validation->set_rules('telepon','Telepon','trim|max_length[16]|required|numeric',
                                  array('max_length' => 'Panjang maksimal 16 karakter',
                                        'required' => 'Nomor telepon dibutuhkan',
                                        'numeric' => 'Karakter harus berupa numeric'));

    if (!$this->form_validation->run()) {
      //mengembalikan respon bad request dengan validasi error
      $this->badreq($this->validation_errors());
    }else {
      if ($this->UGApimodel->updatePengguna($id,$data)) {
        $this->success('Profil anda telah diperbaharui');
      } else {
        $this->badreq('Maaf, proses pembaharuan gagal');
      }
    }
  }

  function pengguna_delete()
  {
    $this->checktoken();
    $id = (int) $this->get('id',TRUE);

    if ($this->UGApimodel->deletePengguna($id)) {
      $this->success('Pengguna telah terhapus');
    } else {
      $this->badreq('Maaf, proses penghapusan gagal');
    }
  }

}
