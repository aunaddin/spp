<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Kategori_pengeluaran_model extends CI_Model {

    public function __construct()
    {
        parent::__construct();
    }

    public function get_all()
    {
        return $this->db->order_by('nama_kategori', 'ASC')->get('kategori_pengeluaran')->result();
    }

    public function get_all_aktif()
    {
        return $this->db->get_where('kategori_pengeluaran', ['status' => 'aktif'])->result();
    }

    public function get_by_id($id)
    {
        return $this->db->get_where('kategori_pengeluaran', ['id' => $id])->row();
    }

    public function create($data)
    {
        return $this->db->insert('kategori_pengeluaran', $data);
    }

    public function update($id, $data)
    {
        $this->db->where('id', $id);
        return $this->db->update('kategori_pengeluaran', $data);
    }

    public function delete($id)
    {
        return $this->db->delete('kategori_pengeluaran', ['id' => $id]);
    }

    public function is_used_in_pengeluaran($id)
    {
        return $this->db->get_where('pengeluaran', ['kategori_id' => $id])->num_rows() > 0;
    }
}