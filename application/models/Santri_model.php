<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Santri_model extends CI_Model {

    public function __construct()
    {
        parent::__construct();
    }

    public function get_all($keyword = null, $limit = null, $offset = 0)
    {
        $this->db->select('santri.*, users.nama as nama_wali, kelas.nama_kelas, kelas.jenjang');
        $this->db->from('santri');
        $this->db->join('users', 'users.id = santri.wali_id', 'left');
        $this->db->join('kelas', 'kelas.id = santri.kelas_id', 'left');

        if (!empty($keyword)) {
            $this->db->group_start();
            $this->db->like('santri.nama', $keyword);
            $this->db->or_like('santri.nis', $keyword);
            $this->db->or_like('kelas.nama_kelas', $keyword);
            $this->db->group_end();
        }

        $this->db->order_by('santri.nama', 'ASC');
        if ($limit !== null) {
            $this->db->limit($limit, $offset);
        }
        return $this->db->get()->result();
    }

    public function count_all($keyword = null)
    {
        $this->db->from('santri');
        $this->db->join('kelas', 'kelas.id = santri.kelas_id', 'left');

        if (!empty($keyword)) {
            $this->db->group_start();
            $this->db->like('santri.nama', $keyword);
            $this->db->or_like('santri.nis', $keyword);
            $this->db->or_like('kelas.nama_kelas', $keyword);
            $this->db->group_end();
        }
        return $this->db->count_all_results();
    }

    public function get_by_id($id)
    {
        return $this->db->get_where('santri', ['id' => $id])->row();
    }

    public function create($data)
    {
        return $this->db->insert('santri', $data);
    }

    public function update($id, $data)
    {
        $this->db->where('id', $id);
        return $this->db->update('santri', $data);
    }

    public function delete($id)
    {
        return $this->db->delete('santri', ['id' => $id]);
    }

    public function has_tagihan($santri_id)
    {
        return $this->db
            ->where('santri_id', $santri_id)
            ->count_all_results('tagihan') > 0;
    }

    public function is_nis_exists($nis, $exclude_id = null)
    {
        $this->db->where('nis', $nis);
        if ($exclude_id) {
            $this->db->where('id !=', $exclude_id);
        }
        return $this->db->get('santri')->num_rows() > 0;
    }

    // Untuk dropdown pilih wali saat tambah/edit santri
    public function get_wali_options()
    {
        return $this->db->get_where('users', ['role' => 'wali_santri', 'status' => 'aktif'])->result();
    }

    // Dipakai nanti di dashboard/riwayat wali santri, filter berdasarkan wali_id
    public function get_by_wali_id($wali_id)
    {
        return $this->db->get_where('santri', ['wali_id' => $wali_id])->result();
    }

    public function get_by_kelas_ids($kelas_ids)
    {
        return $this->db->where_in('kelas_id', $kelas_ids) ->where('status', 'aktif') ->get('santri')->result();
    }
}