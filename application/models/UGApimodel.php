<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class UGApimodel extends CI_Model {

  public function __construct()
  {
    parent::__construct();
    //Codeigniter : Write Less Do More
    $this->load->database();
  }

  public function checkPengguna($nama){
    $this->db->select('*');
    $this->db->from('daftar_pengguna');
    $this->db->where('pn_nama',$nama);
    $query = $this->db->get();
    return $query->row();
  }

  public function checkPenggunaN($nama){
    $this->db->select('*');
    $this->db->from('daftar_pengguna');
    $this->db->where('pn_nama',$nama);
    $query = $this->db->get();
    return $query->num_rows();
  }

  public function selectPengguna(){
    $this->db->select('pn_id');
    $this->db->from('daftar_pengguna');
    $query = $this->db->get();
    return $query->result_array();
  }

  public function selectPengaduan(){
    $this->db->select('pg_id');
    $this->db->from('daftar_pengaduan');
    $query = $this->db->get();
    return $query->result_array();
  }

  public function selectkPengaduan(){
    $this->db->select('kjp_id');
    $this->db->from('kategori_pengaduan');
    $query = $this->db->get();
    return $query->result_array();
  }

  public function selectkJabatan(){
    $this->db->select('kjb_id');
    $this->db->from('kategori_jabatan');
    $query = $this->db->get();
    return $query->result_array();
  }

  public function getKomentar()
  {
    $this->db->select('km.km_id as id, pn.pn_nama as nama, pn.pn_namalengkap as nama_lengkap, pn.pn_foto as foto_profil,
                      km.km_deskripsi as komentar, km.km_media as gambar_komentar, km.km_terbuat as terbuat');
    $this->db->from('daftar_komentar as km');
    $this->db->join('daftar_pengaduan as pg','km.pg_id = pg.pg_id');
    $this->db->join('daftar_pengguna as pn','km.pn_id = pn.pn_id');
    $query = $this->db->get();
    return $query->result();
  }

  public function getKomentarW($id)
  {
    $this->db->select('km.km_id as id, pn.pn_nama as nama, pn.pn_namalengkap as nama_lengkap, pn.pn_foto as foto_profil,
                      km.km_deskripsi as komentar, km.km_media as gambar_komentar, km.km_terbuat as terbuat');
    $this->db->from('daftar_komentar as km');
    $this->db->join('daftar_pengaduan as pg','km.pg_id = pg.pg_id');
    $this->db->join('daftar_pengguna as pn','km.pn_id = pn.pn_id');
    $this->db->where('km.km_id', $id);
    $query = $this->db->get();
    return $query->row();
  }

  public function addKomentar($data)
  {
    if ($this->db->insert('daftar_komentar', $data)) {
      return true;
    }
  }

  public function updateKomentar($id, $data)
  {
    $this->db->set($data);
    $this->db->where('km_id', $id);
    if ($this->db->update('daftar_komentar')) {
      return true;
    }
  }

  public function deleteKomentar($id)
  {
    $this->db->where('km_id', $id);
    $this->db->delete('daftar_komentar');
    if ($this->db->affected_rows()>0) {
      return true;
    }
  }

  public function getPengaduan()
  {
    $this->db->select('pg.pg_id as id, pn.pn_nama as nama, pn.pn_namalengkap as nama_lengkap, kjp.kjp_nama as jabatan,
                      pg.pg_judul as judul, pg.pg_deskripsi as deskripsi, pg.pg_media as meda, pg.pg_terbuat as terbuat');
    $this->db->from('daftar_pengaduan as pg');
    $this->db->join('daftar_pengguna as pn','pg.pn_id = pn.pn_id');
    $this->db->join('kategori_pengaduan as kjp','pg.kjp_id = kjp.kjp_id');
    $query = $this->db->get();
    return $query->result();
  }

  public function getPengaduanW($id)
  {
    $this->db->select('pg.pg_id as id, pn.pn_nama as nama, pn.pn_namalengkap as nama_lengkap, kjp.kjp_nama as kategori_pengaduan,
                      pg.pg_judul as judul, pg.pg_deskripsi as deskripsi, pg.pg_media as meda, pg.pg_terbuat as terbuat');
    $this->db->from('daftar_pengaduan as pg');
    $this->db->join('daftar_pengguna as pn','pg.pn_id = pn.pn_id');
    $this->db->join('kategori_pengaduan as kjp','pg.kjp_id = kjp.kjp_id');
    $this->db->where('pg.pg_id', $id);
    $query = $this->db->get();
    return $query->row();
  }

  public function addPengaduan($data)
  {
    if ($this->db->insert('daftar_pengaduan', $data)) {
      return true;
    }
  }

  public function updatePengaduan($id, $data)
  {
    $this->db->set($data);
    $this->db->where('pg_id', $id);
    if ($this->db->update('daftar_pengaduan')) {
      return true;
    }
  }

  public function deletePengaduan($id)
  {
    $this->db->where('pg_id', $id);
    $this->db->delete('daftar_pengaduan');
    if ($this->db->affected_rows()>0) {
      return true;
    }
  }

  public function getPengguna()
  {
    $this->db->select('pn.pn_id as id, kjb.kjb_nama as jabatan, pn.pn_nama as nama, pn.pn_namalengkap as nama_lengkap,
                      pn.pn_kelamin as kelamin, pn.pn_status as status, pn.pn_jumlahpengaduan as jumlah_pengaduan, pn.pn_telepon as telepon,
                      pn.pn_email as email, pn.pn_foto as foto, pn.pn_terbuat as terdaftar');
    $this->db->from('daftar_pengguna as pn');
    $this->db->join('kategori_jabatan as kjb','pn.kjb_id = kjb.kjb_id');
    $query = $this->db->get();
    return $query->result();
  }

  public function getPenggunaW($id)
  {
    $this->db->select('pn.pn_id as id, kjb.kjb_nama as jabatan, pn.pn_nama as nama, pn.pn_namalengkap as nama_lengkap,
                      pn.pn_kelamin as kelamin, pn.pn_status as status, pn.pn_jumlahpengaduan as jumlah_pengaduan, pn.pn_telepon as telepon,
                      pn.pn_email as email, pn.pn_foto as foto, pn.pn_terbuat as terdaftar');
    $this->db->from('daftar_pengguna as pn');
    $this->db->join('kategori_jabatan as kjb','pn.kjb_id = kjb.kjb_id');
    $this->db->where('pn.pn_id', $id);
    $query = $this->db->get();
    return $query->row();
  }

  public function addPengguna($data)
  {
    if ($this->db->insert('daftar_pengguna', $data)) {
      return true;
    }
  }

  public function updatePengguna($id, $data)
  {
    $this->db->set($data);
    $this->db->where('pn_id', $id);
    if ($this->db->update('daftar_pengguna')) {
      return true;
    }
  }

  public function deletePengguna($id)
  {
    $this->db->where('pn_id', $id);
    $this->db->delete('daftar_pengguna');
    if ($this->db->affected_rows()>0) {
      return true;
    }
  }

  public function getKJabatan()
  {
    $this->db->select('kjb_id as id, kjb_nama as kategori_jabatan');
    $this->db->from('kategori_jabatan');
    $query = $this->db->get();
    return $query->result();
  }

  public function getKJabatanW($id)
  {
    $this->db->select('kjb_id as id, kjb_nama as kategori_jabatan');
    $this->db->from('kategori_jabatan');
    $this->db->where('kjb_id', $id);
    $query = $this->db->get();
    return $query->row();
  }

  public function addKJabatan($data)
  {
    if ($this->db->insert('kategori_jabatan', $data)) {
      return true;
    }
  }

  public function updateKJabatan($id, $data)
  {
    $this->db->set($data);
    $this->db->where('kjb_id', $id);
    if ($this->db->update('kategori_jabatan')) {
      return true;
    }
  }

  public function deleteKJabatan($id)
  {
    $this->db->where('kjb_id', $id);
    $this->db->delete('kategori_jabatan');
    if ($this->db->affected_rows()>0) {
      return true;
    }
  }

  public function getKPengaduan()
  {
    $this->db->select('kjp_id as id, kjp_nama as kategori_pengaduan');
    $this->db->from('kategori_pengaduan');
    $query = $this->db->get();
    return $query->result();
  }

  public function getKPengaduanW($id)
  {
    $this->db->select('kjp_id as id, kjp_nama as kategori_pengaduan');
    $this->db->from('kategori_pengaduan');
    $this->db->where('kjp_id', $id);
    $query = $this->db->get();
    return $query->row();
  }

  public function addKPengaduan($data)
  {
    if ($this->db->insert('kategori_pengaduan', $data)) {
      return true;
    }
  }

  public function updatePKPengaduan($id, $data)
  {
    $this->db->set($data);
    $this->db->where('kjp_id', $id);
    if ($this->db->update('kategori_pengaduan')) {
      return true;
    }
  }

  public function deleteKPengaduan($id)
  {
    $this->db->where('kjp_id', $id);
    $this->db->delete('kategori_pengaduan');
    if ($this->db->affected_rows()>0) {
      return true;
    }
  }

}
