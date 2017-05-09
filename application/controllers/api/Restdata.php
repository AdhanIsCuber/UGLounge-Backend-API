<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH . '/libraries/REST_Controller.php';

//uncomment di bawah ini atau gunakan autoload yang di config->config->composer_autoload default ada di composer_autoload
//require_once FCPATH . 'vendor/autoload.php';

use Restserver\Libraries\REST_Controller;

use \Firebase\JWT\JWT;

class Restdata extends REST_Controller{

  private $secretkey = 'c0b4d1b4c4uggun4d4rm4uj14nm4nd1rim4n14s4dj4h3h3h3';

  public function __construct(){
    parent::__construct();
    $this->load->library('form_validation');
  }

  //method untuk not found 404
  public function success($pesan)
  {
    $this->response([
      'status' => true,
      'message' => $pesan
    ],REST_Controller::HTTP_OK);
  }

  //method untuk not found 404
  public function notfound($pesan)
  {
    $this->response([
      'status' => false,
      'message' => $pesan
    ],REST_Controller::HTTP_NOT_FOUND);
  }

  //method untuk bad request 400
  public function badreq($pesan)
  {
    $this->response([
      'status' => false,
      'message' => $pesan
    ],REST_Controller::HTTP_BAD_REQUEST);
  }

  //method untuk melihat token pada user
  public function login_post()
  {
    $this->load->model('UGApimodel');
    $date = new DateTime();
    $nama = $this->post('nama',TRUE);
    $pass = $this->post('sandi',TRUE);
    $dataadmin = $this->UGApimodel->checkPengguna($nama);
    if ($dataadmin) {
      if (password_verify($pass,$dataadmin->pn_sandi)) {
        $payload['id'] = $dataadmin->pn_id;
        $payload['nama'] = $dataadmin->pn_nama;
        $payload['iat'] = $date->getTimestamp(); //waktu di buat
        $payload['exp'] = $date->getTimestamp() + 2629746; //satu bulan

        $output['token_key'] = JWT::encode($payload,$this->secretkey);
        $this->response($output,HTTP_OK);
      } else {
        $this->viewtokenfail($nama,$pass);
      }
    } else {
      $this->viewtokenfail($nama,$pass);
    }
  }

  //method untuk jika view token diatas fail
  public function loginfail($nama,$pass)
  {
    $this->response([
      'status' => false,
      'message' => 'Gagal dalam pemberian token'
      ],HTTP_BAD_REQUEST);
  }

//method untuk mengecek token setiap melakukan post, put, etc
  public function checktoken()
  {
    $this->load->model('UGApimodel');
    $jwt = $this->input->get_request_header('Authorization');
    try {
      $decode = JWT::decode($jwt,$this->secretkey,array('HS256'));
      //melakukan pengecekan database, jika nama tersedia di database maka return true
      if ($this->UGApimodel->checkPenggunaN($decode->nama)>0) {
        return true;
      }

    } catch (Exception $e) {
      exit('Token key salah / tidak terdaftar.');
    }

  }

}
