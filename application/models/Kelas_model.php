<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Kelas_model extends CI_Model {

    public function get_all($limit = null, $offset = 0)
    {
        $this->db->order_by('jenjang', 'ASC')->order_by('nama_kelas', 'ASC');
        if ($limit !== null) {
            $this->db->limit($limit, $offset);
        }
        return $this->db->get('kelas')->result();
    }

    public function count_all()
    {
        return $this->db->count_all_results('kelas');
    }

    public function get_all_aktif()
    {
        return $this->db->order_by('jenjang', 'ASC')->order_by('nama_kelas', 'ASC')
                         ->get_where('kelas', ['status' => 'aktif'])->result();
    }

    public function get_by_id($id)
    {
        return $this->db->get_where('kelas', ['id' => $id])->row();
    }

    public function create($data)
    {
        return $this->db->insert('kelas', $data);
    }

    public function update($id, $data)
    {
        $this->db->where('id', $id);
        return $this->db->update('kelas', $data);
    }

    public function delete($id)
    {
        return $this->db->delete('kelas', ['id' => $id]);
    }

    public function is_used($id)
    {
        return $this->db->get_where('santri', ['kelas_id' => $id])->num_rows() > 0;
    }

    public function get_ids_by_jenjang($jenjang)
    {
        $result = $this->db->select('id')->get_where('kelas', ['jenjang' => $jenjang])->result();
        return array_map(function($k) { return $k->id; }, $result);
    }
}