<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tagihan_model extends CI_Model {

    public function __construct()
    {
        parent::__construct();
    }

    public function get_all($filter_bulan = null, $filter_tahun = null, $limit = null, $offset = 0)
    {
        $this->db->select('tagihan.*, santri.nama as nama_santri, santri.nis, kelas.nama_kelas, kelas.jenjang, jenis_pembayaran.nama_pembayaran');
        $this->db->from('tagihan');
        $this->db->join('santri', 'santri.id = tagihan.santri_id');
        $this->db->join('kelas', 'kelas.id = santri.kelas_id', 'left');
        $this->db->join('jenis_pembayaran', 'jenis_pembayaran.id = tagihan.jenis_pembayaran_id');

        if ($filter_bulan) $this->db->where('tagihan.bulan', $filter_bulan);
        if ($filter_tahun) $this->db->where('tagihan.tahun', $filter_tahun);

        $this->db->order_by('tagihan.tahun', 'DESC');
        $this->db->order_by('santri.nama', 'ASC');

        if ($limit !== null) {
            $this->db->limit($limit, $offset);
        }
        return $this->db->get()->result();
    }

    // Method BARU: hitung total baris sesuai filter yang sama (untuk pagination)
    public function count_all($filter_bulan = null, $filter_tahun = null)
    {
        $this->db->from('tagihan');
        $this->db->join('santri', 'santri.id = tagihan.santri_id');
        if ($filter_bulan) $this->db->where('tagihan.bulan', $filter_bulan);
        if ($filter_tahun) $this->db->where('tagihan.tahun', $filter_tahun);
        return $this->db->count_all_results();
    }
    public function get_by_id($id)
    {
        return $this->db->get_where('tagihan', ['id' => $id])->row();
    }

    public function create($data)
    {
        return $this->db->insert('tagihan', $data);
    }

    public function update($id, $data)
    {
        $this->db->where('id', $id);
        return $this->db->update('tagihan', $data);
    }

    public function delete($id)
    {
        return $this->db->delete('tagihan', ['id' => $id]);
    }

    public function is_used_in_pembayaran($id)
    {
        return $this->db->get_where('pembayaran', ['tagihan_id' => $id])->num_rows() > 0;
    }

    // Cek supaya tidak generate tagihan duplikat: santri + jenis + bulan + tahun yang sama
    public function is_tagihan_exists($santri_id, $jenis_pembayaran_id, $bulan, $tahun)
    {
        return $this->db->get_where('tagihan', [
            'santri_id'           => $santri_id,
            'jenis_pembayaran_id' => $jenis_pembayaran_id,
            'bulan'               => $bulan,
            'tahun'               => $tahun,
        ])->num_rows() > 0;
    }

    // Generate massal untuk semua santri aktif, skip yang sudah punya tagihan sama supaya tidak dobel
    public function generate_bulk($santri_ids, $jenis_pembayaran_id, $nominal, $bulan, $tahun, $jatuh_tempo)
    {
        // Isi sama seperti sebelumnya, tidak berubah — cukup terima $santri_ids yang sudah difilter dari controller
        $berhasil = 0;
        $dilewati = 0;

        foreach ($santri_ids as $santri_id) {
            if ($this->is_tagihan_exists($santri_id, $jenis_pembayaran_id, $bulan, $tahun)) {
                $dilewati++;
                continue;
            }

            $this->db->insert('tagihan', [
                'santri_id'           => $santri_id,
                'jenis_pembayaran_id' => $jenis_pembayaran_id,
                'bulan'               => $bulan,
                'tahun'               => $tahun,
                'nominal'             => $nominal,
                'jatuh_tempo'         => $jatuh_tempo,
                'status'              => 'belum_lunas',
            ]);
            $berhasil++;
        }

        return ['berhasil' => $berhasil, 'dilewati' => $dilewati];
    }
    // Pencarian lengkap dengan filter, dipakai admin & bendahara
    public function search($filter = [], $limit = null, $offset = 0)
    {
        $this->db->select('tagihan.*, santri.nama as nama_santri, santri.nis, kelas.nama_kelas, kelas.jenjang,
                            jenis_pembayaran.nama_pembayaran, pembayaran.no_bukti, pembayaran.tanggal_bayar');
        $this->db->from('tagihan');
        $this->db->join('santri', 'santri.id = tagihan.santri_id');
        $this->db->join('kelas', 'kelas.id = santri.kelas_id', 'left');
        $this->db->join('jenis_pembayaran', 'jenis_pembayaran.id = tagihan.jenis_pembayaran_id');
        $this->db->join('pembayaran', 'pembayaran.tagihan_id = tagihan.id', 'left');

        if (!empty($filter['keyword'])) {
            $this->db->group_start();
            $this->db->like('santri.nama', $filter['keyword']);
            $this->db->or_like('santri.nis', $filter['keyword']);
            $this->db->group_end();
        }
        if (!empty($filter['jenis_pembayaran_id'])) {
            $this->db->where('tagihan.jenis_pembayaran_id', $filter['jenis_pembayaran_id']);
        }
        if (!empty($filter['bulan'])) {
            $this->db->where('tagihan.bulan', $filter['bulan']);
        }
        if (!empty($filter['tahun'])) {
            $this->db->where('tagihan.tahun', $filter['tahun']);
        }
        if (!empty($filter['status'])) {
            $this->db->where('tagihan.status', $filter['status']);
        }
        if (!empty($filter['wali_id'])) {
            $this->db->where('santri.wali_id', $filter['wali_id']);
        }

        $this->db->order_by('tagihan.tahun', 'DESC');
        $this->db->order_by('santri.nama', 'ASC');

        if ($limit !== null) {
            $this->db->limit($limit, $offset);
        }
        return $this->db->get()->result();
    }

    // Method BARU: hitung total baris dengan filter yang SAMA PERSIS seperti search(), tanpa limit
    public function count_search($filter = [])
    {
        $this->db->from('tagihan');
        $this->db->join('santri', 'santri.id = tagihan.santri_id');
        $this->db->join('jenis_pembayaran', 'jenis_pembayaran.id = tagihan.jenis_pembayaran_id');
        $this->db->join('pembayaran', 'pembayaran.tagihan_id = tagihan.id', 'left');

        if (!empty($filter['keyword'])) {
            $this->db->group_start();
            $this->db->like('santri.nama', $filter['keyword']);
            $this->db->or_like('santri.nis', $filter['keyword']);
            $this->db->group_end();
        }
        if (!empty($filter['jenis_pembayaran_id'])) {
            $this->db->where('tagihan.jenis_pembayaran_id', $filter['jenis_pembayaran_id']);
        }
        if (!empty($filter['bulan'])) {
            $this->db->where('tagihan.bulan', $filter['bulan']);
        }
        if (!empty($filter['tahun'])) {
            $this->db->where('tagihan.tahun', $filter['tahun']);
        }
        if (!empty($filter['status'])) {
            $this->db->where('tagihan.status', $filter['status']);
        }
        if (!empty($filter['wali_id'])) {
            $this->db->where('santri.wali_id', $filter['wali_id']);
        }

        return $this->db->count_all_results();
    }
}