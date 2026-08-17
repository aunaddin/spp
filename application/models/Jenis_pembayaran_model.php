<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Jenis_pembayaran_model extends CI_Model {

    public function __construct()
    {
        parent::__construct();
    }

    public function get_all($limit = null, $offset = 0)
    {
        $this->db->order_by('nama_pembayaran', 'ASC');
        if ($limit !== null) {
            $this->db->limit($limit, $offset);
        }
        return $this->db->get('jenis_pembayaran')->result();
    }

    public function count_all()
    {
        return $this->db->count_all_results('jenis_pembayaran');
    }

    public function get_all_aktif()
    {
        return $this->db->get_where('jenis_pembayaran', ['status' => 'aktif'])->result();
    }

    public function get_by_id($id)
    {
        return $this->db->get_where('jenis_pembayaran', ['id' => $id])->row();
    }

    public function create($data)
    {
        return $this->db->insert('jenis_pembayaran', $data);
    }

    public function update($id, $data)
    {
        $this->db->where('id', $id);
        return $this->db->update('jenis_pembayaran', $data);
    }

    public function delete($id)
    {
        return $this->db->delete('jenis_pembayaran', ['id' => $id]);
    }

    public function is_used_in_tagihan($id)
    {
        return $this->db->get_where('tagihan', ['jenis_pembayaran_id' => $id])->num_rows() > 0;
    }
}