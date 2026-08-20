<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard_model extends CI_Model {

    public function __construct()
    {
        parent::__construct();
    }

    // ==== Untuk Admin & Bendahara ====

    public function total_santri_aktif()
    {
        return $this->db->get_where('santri', ['status' => 'aktif'])->num_rows();
    }

    public function total_tagihan_belum_lunas()
    {
        return $this->db->get_where('tagihan', ['status' => 'belum_lunas'])->num_rows();
    }

    public function total_pemasukan_bulan_ini()
    {
        $this->db->select_sum('nominal_dibayar');
        $this->db->where('status', 'disetujui'); // PERBAIKAN BUG
        $this->db->where('MONTH(tanggal_bayar)', date('m'));
        $this->db->where('YEAR(tanggal_bayar)', date('Y'));
        $result = $this->db->get('pembayaran')->row();
        return $result->nominal_dibayar ?: 0;
    }

    public function total_transaksi_hari_ini()
    {
        // PERBAIKAN: hanya hitung transaksi yang sudah disetujui, bukan yang masih menunggu/ditolak
        return $this->db->get_where('pembayaran', [
            'tanggal_bayar' => date('Y-m-d'),
            'status'        => 'disetujui',
        ])->num_rows();
    }

    // Grafik pemasukan 6 bulan terakhir (berdasarkan tanggal_bayar aktual)
    public function pemasukan_6_bulan()
    {
        $this->db->select("DATE_FORMAT(tanggal_bayar, '%Y-%m') as bulan, SUM(nominal_dibayar) as total");
        $this->db->where('status', 'disetujui'); // PERBAIKAN BUG
        $this->db->where('tanggal_bayar >=', date('Y-m-d', strtotime('-6 months')));
        $this->db->group_by("DATE_FORMAT(tanggal_bayar, '%Y-%m')");
        $this->db->order_by('bulan', 'ASC');
        return $this->db->get('pembayaran')->result();
    }
    public function tagihan_terlambat($limit = 5)
    {
        $this->db->select('tagihan.*, santri.nama as nama_santri, santri.nis, jenis_pembayaran.nama_pembayaran');
        $this->db->from('tagihan');
        $this->db->join('santri', 'santri.id = tagihan.santri_id');
        $this->db->join('jenis_pembayaran', 'jenis_pembayaran.id = tagihan.jenis_pembayaran_id');
        $this->db->where('tagihan.status', 'belum_lunas');
        $this->db->where('tagihan.jatuh_tempo <', date('Y-m-d'));
        $this->db->order_by('tagihan.jatuh_tempo', 'ASC');
        $this->db->limit($limit);
        return $this->db->get()->result();
    }

    // ==== Untuk Wali Santri ====

    public function total_anak($wali_id)
    {
        return $this->db->get_where('santri', ['wali_id' => $wali_id, 'status' => 'aktif'])->num_rows();
    }

    public function total_tagihan_anak_belum_lunas($wali_id)
    {
        $this->db->from('tagihan');
        $this->db->join('santri', 'santri.id = tagihan.santri_id');
        $this->db->where('santri.wali_id', $wali_id);
        $this->db->where('tagihan.status', 'belum_lunas');
        return $this->db->get()->num_rows();
    }

    public function tagihan_anak_belum_lunas($wali_id)
    {
        $this->db->select('tagihan.*, santri.nama as nama_santri, jenis_pembayaran.nama_pembayaran');
        $this->db->from('tagihan');
        $this->db->join('santri', 'santri.id = tagihan.santri_id');
        $this->db->join('jenis_pembayaran', 'jenis_pembayaran.id = tagihan.jenis_pembayaran_id');
        $this->db->where('santri.wali_id', $wali_id);
        $this->db->where('tagihan.status', 'belum_lunas');
        $this->db->order_by('tagihan.jatuh_tempo', 'ASC');
        return $this->db->get()->result();
    }
}