<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pengeluaran_model extends CI_Model {

    public function __construct()
    {
        parent::__construct();
    }

    public function get_all($filter = [])
    {
        $this->db->select('pengeluaran.*, kategori_pengeluaran.nama_kategori, users.nama as nama_petugas');
        $this->db->from('pengeluaran');
        $this->db->join('kategori_pengeluaran', 'kategori_pengeluaran.id = pengeluaran.kategori_id');
        $this->db->join('users', 'users.id = pengeluaran.petugas_id');

        if (!empty($filter['bulan'])) {
            $this->db->where('MONTH(pengeluaran.tanggal)', $filter['bulan']);
        }
        if (!empty($filter['tahun'])) {
            $this->db->where('YEAR(pengeluaran.tanggal)', $filter['tahun']);
        }
        if (!empty($filter['kategori_id'])) {
            $this->db->where('pengeluaran.kategori_id', $filter['kategori_id']);
        }

        $this->db->order_by('pengeluaran.tanggal', 'DESC');
        return $this->db->get()->result();
    }

    public function get_by_id($id)
    {
        return $this->db->get_where('pengeluaran', ['id' => $id])->row();
    }

    public function create($data)
    {
        return $this->db->insert('pengeluaran', $data);
    }

    public function update($id, $data)
    {
        $this->db->where('id', $id);
        return $this->db->update('pengeluaran', $data);
    }

    public function delete($id)
    {
        return $this->db->delete('pengeluaran', ['id' => $id]);
    }

    public function get_total($filter = [])
    {
        $data = $this->get_all($filter);
        $total = 0;
        foreach ($data as $d) {
            $total += $d->nominal;
        }
        return $total;
    }

    // Rekap per kategori untuk 1 bulan tertentu, dipakai di Laporan Keuangan
    public function get_rekap_per_kategori($bulan, $tahun)
    {
        $this->db->select('kategori_pengeluaran.nama_kategori, SUM(pengeluaran.nominal) as total');
        $this->db->from('pengeluaran');
        $this->db->join('kategori_pengeluaran', 'kategori_pengeluaran.id = pengeluaran.kategori_id');
        $this->db->where('MONTH(pengeluaran.tanggal)', $bulan);
        $this->db->where('YEAR(pengeluaran.tanggal)', $tahun);
        $this->db->group_by('kategori_pengeluaran.id');
        $this->db->order_by('total', 'DESC');
        return $this->db->get()->result();
    }
}