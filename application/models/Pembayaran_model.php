<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pembayaran_model extends CI_Model {

    public function __construct()
    {
        parent::__construct();
    }

    public function get_tagihan_belum_lunas($keyword = null, $limit = null, $offset = 0)
    {
        $this->db->select('tagihan.*, santri.nama as nama_santri, santri.nis, kelas.nama_kelas, kelas.jenjang, jenis_pembayaran.nama_pembayaran');
        $this->db->from('tagihan');
        $this->db->join('santri', 'santri.id = tagihan.santri_id');
        $this->db->join('kelas', 'kelas.id = santri.kelas_id', 'left');
        $this->db->join('jenis_pembayaran', 'jenis_pembayaran.id = tagihan.jenis_pembayaran_id');
        $this->db->where('tagihan.status', 'belum_lunas');

        if (!empty($keyword)) {
            $this->db->group_start();
            $this->db->like('santri.nama', $keyword);
            $this->db->or_like('santri.nis', $keyword);
            $this->db->or_like('jenis_pembayaran.nama_pembayaran', $keyword);
            $this->db->group_end();
        }

        $this->db->order_by('tagihan.jatuh_tempo', 'ASC');
        if ($limit !== null) {
            $this->db->limit($limit, $offset);
        }
        return $this->db->get()->result();
    }

    public function count_tagihan_belum_lunas($keyword = null)
    {
        $this->db->from('tagihan');
        $this->db->join('santri', 'santri.id = tagihan.santri_id');
        $this->db->join('jenis_pembayaran', 'jenis_pembayaran.id = tagihan.jenis_pembayaran_id');
        $this->db->where('tagihan.status', 'belum_lunas');

        if (!empty($keyword)) {
            $this->db->group_start();
            $this->db->like('santri.nama', $keyword);
            $this->db->or_like('santri.nis', $keyword);
            $this->db->or_like('jenis_pembayaran.nama_pembayaran', $keyword);
            $this->db->group_end();
        }
        return $this->db->count_all_results();
    }

    public function get_tagihan_by_id($id)
    {
        $this->db->select('tagihan.*, santri.nama as nama_santri, santri.nis, kelas.nama_kelas, kelas.jenjang, jenis_pembayaran.nama_pembayaran');
        $this->db->from('tagihan');
        $this->db->join('santri', 'santri.id = tagihan.santri_id');
        $this->db->join('kelas', 'kelas.id = santri.kelas_id', 'left');
        $this->db->join('jenis_pembayaran', 'jenis_pembayaran.id = tagihan.jenis_pembayaran_id');
        $this->db->where('tagihan.id', $id);
        return $this->db->get()->row();
    }

    public function generate_no_bukti()
    {
        $prefix = 'KWT-' . date('Ymd') . '-';
        $this->db->like('no_bukti', $prefix, 'after');
        $this->db->order_by('id', 'DESC');
        $last = $this->db->get('pembayaran')->row();

        if (!$last) {
            $urutan = 1;
        } else {
            $urutan = (int) substr($last->no_bukti, -4) + 1;
        }

        return $prefix . str_pad($urutan, 4, '0', STR_PAD_LEFT);
    }

    public function proses_pembayaran($data_pembayaran)
    {
        $this->db->trans_start();

        $this->db->insert('pembayaran', $data_pembayaran);
        $pembayaran_id = $this->db->insert_id();

        $this->db->where('id', $data_pembayaran['tagihan_id']);
        $this->db->update('tagihan', ['status' => 'lunas']);

        $this->db->trans_complete();

        if ($this->db->trans_status() === FALSE) {
            return false;
        }

        return $pembayaran_id;
    }

    public function get_by_id($id)
    {
        $this->db->select('pembayaran.*, tagihan.bulan, tagihan.tahun, tagihan.santri_id, tagihan.jenis_pembayaran_id,
                            santri.nama as nama_santri, santri.nis, kelas.nama_kelas, kelas.jenjang,
                            jenis_pembayaran.nama_pembayaran, users.nama as nama_petugas');
        $this->db->from('pembayaran');
        $this->db->join('tagihan', 'tagihan.id = pembayaran.tagihan_id');
        $this->db->join('santri', 'santri.id = tagihan.santri_id');
        $this->db->join('kelas', 'kelas.id = santri.kelas_id', 'left');
        $this->db->join('jenis_pembayaran', 'jenis_pembayaran.id = tagihan.jenis_pembayaran_id');
        $this->db->join('users', 'users.id = pembayaran.petugas_id', 'left'); // DIPERBAIKI: tambah 'left'
        $this->db->where('pembayaran.id', $id);
        return $this->db->get()->row();
    }

    public function get_riwayat_all($keyword = null, $limit = null, $offset = 0)
    {
        $this->db->select('pembayaran.*, tagihan.bulan, tagihan.tahun,
                            santri.nama as nama_santri, santri.nis, kelas.nama_kelas, kelas.jenjang,
                            jenis_pembayaran.nama_pembayaran, users.nama as nama_petugas');
        $this->db->from('pembayaran');
        $this->db->join('tagihan', 'tagihan.id = pembayaran.tagihan_id');
        $this->db->join('santri', 'santri.id = tagihan.santri_id');
        $this->db->join('kelas', 'kelas.id = santri.kelas_id', 'left');
        $this->db->join('jenis_pembayaran', 'jenis_pembayaran.id = tagihan.jenis_pembayaran_id');
        $this->db->join('users', 'users.id = pembayaran.petugas_id', 'left');

        if (!empty($keyword)) {
            $this->db->group_start();
            $this->db->like('santri.nama', $keyword);
            $this->db->or_like('pembayaran.no_bukti', $keyword);
            $this->db->or_like('jenis_pembayaran.nama_pembayaran', $keyword);
            $this->db->group_end();
        }

        $this->db->order_by('pembayaran.tanggal_bayar', 'DESC');
        if ($limit !== null) {
            $this->db->limit($limit, $offset);
        }
        return $this->db->get()->result();
    }

    public function count_riwayat_all($keyword = null)
    {
        $this->db->from('pembayaran');
        $this->db->join('tagihan', 'tagihan.id = pembayaran.tagihan_id');
        $this->db->join('santri', 'santri.id = tagihan.santri_id');
        $this->db->join('jenis_pembayaran', 'jenis_pembayaran.id = tagihan.jenis_pembayaran_id');

        if (!empty($keyword)) {
            $this->db->group_start();
            $this->db->like('santri.nama', $keyword);
            $this->db->or_like('pembayaran.no_bukti', $keyword);
            $this->db->or_like('jenis_pembayaran.nama_pembayaran', $keyword);
            $this->db->group_end();
        }
        return $this->db->count_all_results();
    }

    public function get_riwayat_by_wali($wali_id, $keyword = null, $limit = null, $offset = 0)
    {
        $this->db->select('pembayaran.*, tagihan.bulan, tagihan.tahun,
                            santri.nama as nama_santri, santri.nis, kelas.nama_kelas, kelas.jenjang,
                            jenis_pembayaran.nama_pembayaran, users.nama as nama_petugas');
        $this->db->from('pembayaran');
        $this->db->join('tagihan', 'tagihan.id = pembayaran.tagihan_id');
        $this->db->join('santri', 'santri.id = tagihan.santri_id');
        $this->db->join('kelas', 'kelas.id = santri.kelas_id', 'left');
        $this->db->join('jenis_pembayaran', 'jenis_pembayaran.id = tagihan.jenis_pembayaran_id');
        $this->db->join('users', 'users.id = pembayaran.petugas_id', 'left');
        $this->db->where('santri.wali_id', $wali_id);

        if (!empty($keyword)) {
            $this->db->group_start();
            $this->db->like('santri.nama', $keyword);
            $this->db->or_like('pembayaran.no_bukti', $keyword);
            $this->db->or_like('jenis_pembayaran.nama_pembayaran', $keyword);
            $this->db->group_end();
        }

        $this->db->order_by('pembayaran.tanggal_bayar', 'DESC');
        if ($limit !== null) {
            $this->db->limit($limit, $offset);
        }
        return $this->db->get()->result();
    }

    public function count_riwayat_by_wali($wali_id, $keyword = null)
    {
        $this->db->from('pembayaran');
        $this->db->join('tagihan', 'tagihan.id = pembayaran.tagihan_id');
        $this->db->join('santri', 'santri.id = tagihan.santri_id');
        $this->db->join('jenis_pembayaran', 'jenis_pembayaran.id = tagihan.jenis_pembayaran_id');
        $this->db->where('santri.wali_id', $wali_id);

        if (!empty($keyword)) {
            $this->db->group_start();
            $this->db->like('santri.nama', $keyword);
            $this->db->or_like('pembayaran.no_bukti', $keyword);
            $this->db->or_like('jenis_pembayaran.nama_pembayaran', $keyword);
            $this->db->group_end();
        }
        return $this->db->count_all_results();
    }

    public function get_laporan($filter = [], $limit = null, $offset = 0)
    {
        $this->db->select('pembayaran.*, tagihan.bulan, tagihan.tahun,
                            santri.nama as nama_santri, santri.nis, kelas.nama_kelas, kelas.jenjang,
                            jenis_pembayaran.nama_pembayaran, users.nama as nama_petugas');
        $this->db->from('pembayaran');
        $this->db->join('tagihan', 'tagihan.id = pembayaran.tagihan_id');
        $this->db->join('santri', 'santri.id = tagihan.santri_id');
        $this->db->join('kelas', 'kelas.id = santri.kelas_id', 'left');
        $this->db->join('jenis_pembayaran', 'jenis_pembayaran.id = tagihan.jenis_pembayaran_id');
        $this->db->join('users', 'users.id = pembayaran.petugas_id', 'left');
        $this->db->where('pembayaran.status', 'disetujui'); // PERBAIKAN BUG: hanya yang sudah disetujui dihitung sebagai pemasukan

        if (!empty($filter['bulan'])) {
            $this->db->where('tagihan.bulan', $filter['bulan']);
        }
        if (!empty($filter['tahun'])) {
            $this->db->where('tagihan.tahun', $filter['tahun']);
        }
        if (!empty($filter['jenis_pembayaran_id'])) {
            $this->db->where('tagihan.jenis_pembayaran_id', $filter['jenis_pembayaran_id']);
        }
        if (!empty($filter['tanggal_dari'])) {
            $this->db->where('pembayaran.tanggal_bayar >=', $filter['tanggal_dari']);
        }
        if (!empty($filter['tanggal_sampai'])) {
            $this->db->where('pembayaran.tanggal_bayar <=', $filter['tanggal_sampai']);
        }

        $this->db->order_by('pembayaran.tanggal_bayar', 'ASC');
        if ($limit !== null) {
            $this->db->limit($limit, $offset);
        }
        return $this->db->get()->result();
    }

    // Method BARU: hitung total baris dengan filter sama persis, untuk pagination
    public function count_laporan($filter = [])
    {
        $this->db->from('pembayaran');
        $this->db->join('tagihan', 'tagihan.id = pembayaran.tagihan_id');
        $this->db->join('santri', 'santri.id = tagihan.santri_id');
        $this->db->join('jenis_pembayaran', 'jenis_pembayaran.id = tagihan.jenis_pembayaran_id');
        $this->db->where('pembayaran.status', 'disetujui'); // sama, hanya yang disetujui

        if (!empty($filter['bulan'])) {
            $this->db->where('tagihan.bulan', $filter['bulan']);
        }
        if (!empty($filter['tahun'])) {
            $this->db->where('tagihan.tahun', $filter['tahun']);
        }
        if (!empty($filter['jenis_pembayaran_id'])) {
            $this->db->where('tagihan.jenis_pembayaran_id', $filter['jenis_pembayaran_id']);
        }
        if (!empty($filter['tanggal_dari'])) {
            $this->db->where('pembayaran.tanggal_bayar >=', $filter['tanggal_dari']);
        }
        if (!empty($filter['tanggal_sampai'])) {
            $this->db->where('pembayaran.tanggal_bayar <=', $filter['tanggal_sampai']);
        }
        return $this->db->count_all_results();
    }

    public function get_total_laporan($filter = [])
    {
        $data = $this->get_laporan($filter);
        $total = 0;
        foreach ($data as $d) {
            $total += $d->nominal_dibayar;
        }
        return $total;
    }

    public function get_total_masuk($bulan, $tahun)
    {
        $this->db->select_sum('pembayaran.nominal_dibayar');
        $this->db->from('pembayaran');
        $this->db->join('tagihan', 'tagihan.id = pembayaran.tagihan_id');
        $this->db->where('pembayaran.status', 'disetujui'); // TAMBAHAN — ini yang hilang
        $this->db->where('MONTH(pembayaran.tanggal_bayar)', $bulan);
        $this->db->where('YEAR(pembayaran.tanggal_bayar)', $tahun);
        $result = $this->db->get()->row();
        return $result->nominal_dibayar ?: 0;
    }
    // Submit dari wali santri, status masih "menunggu", tagihan TIDAK berubah dulu
    public function submit_transfer($data)
    {
        return $this->db->insert('pembayaran', $data);
    }

    // Daftar pengajuan yang perlu dikonfirmasi admin/bendahara
    public function get_menunggu_konfirmasi($keyword = null)
    {
        $this->db->select('pembayaran.*, tagihan.bulan, tagihan.tahun,
                            santri.nama as nama_santri, santri.nis, kelas.nama_kelas, kelas.jenjang,
                            jenis_pembayaran.nama_pembayaran, users.nama as nama_wali');
        $this->db->from('pembayaran');
        $this->db->join('tagihan', 'tagihan.id = pembayaran.tagihan_id');
        $this->db->join('santri', 'santri.id = tagihan.santri_id');
        $this->db->join('kelas', 'kelas.id = santri.kelas_id', 'left');
        $this->db->join('jenis_pembayaran', 'jenis_pembayaran.id = tagihan.jenis_pembayaran_id');
        $this->db->join('users', 'users.id = pembayaran.diajukan_oleh');
        $this->db->where('pembayaran.status', 'menunggu');

        if (!empty($keyword)) {
            $this->db->group_start();
            $this->db->like('santri.nama', $keyword);
            $this->db->or_like('santri.nis', $keyword);
            $this->db->or_like('users.nama', $keyword); // nama wali yang mengajukan
            $this->db->group_end();
        }

        $this->db->order_by('pembayaran.created_at', 'ASC');
        return $this->db->get()->result();
    }

    // Setujui: tandai pembayaran disetujui + baru di sini tagihan diupdate jadi lunas
    public function setujui($pembayaran_id, $petugas_id)
    {
        $this->db->trans_start();

        $pembayaran = $this->db->get_where('pembayaran', ['id' => $pembayaran_id])->row();

        $this->db->where('id', $pembayaran_id);
        $this->db->update('pembayaran', [
            'status'     => 'disetujui',
            'petugas_id' => $petugas_id,
        ]);

        $this->db->where('id', $pembayaran->tagihan_id);
        $this->db->update('tagihan', ['status' => 'lunas']);

        $this->db->trans_complete();
        return $this->db->trans_status();
    }

    // Tolak: kasih alasan, tagihan tetap belum lunas, wali bisa submit ulang
    public function tolak($pembayaran_id, $petugas_id, $alasan)
    {
        $this->db->where('id', $pembayaran_id);
        return $this->db->update('pembayaran', [
            'status'        => 'ditolak',
            'petugas_id'    => $petugas_id,
            'catatan_admin' => $alasan,
        ]);
    }

    public function get_pengajuan_by_id($id)
    {
        $this->db->select('pembayaran.*, tagihan.bulan, tagihan.tahun, tagihan.santri_id, tagihan.nominal as nominal_tagihan,
                            santri.nama as nama_santri, santri.nis, kelas.nama_kelas, kelas.jenjang,
                            jenis_pembayaran.nama_pembayaran');
        $this->db->from('pembayaran');
        $this->db->join('tagihan', 'tagihan.id = pembayaran.tagihan_id');
        $this->db->join('santri', 'santri.id = tagihan.santri_id');
        $this->db->join('kelas', 'kelas.id = santri.kelas_id', 'left');
        $this->db->join('jenis_pembayaran', 'jenis_pembayaran.id = tagihan.jenis_pembayaran_id');
        $this->db->where('pembayaran.id', $id);
        return $this->db->get()->row();
    }

    // Cek apakah tagihan ini masih punya pengajuan yang menunggu (supaya wali tidak submit dobel)
    public function is_ada_pengajuan_menunggu($tagihan_id)
    {
        return $this->db->get_where('pembayaran', [
            'tagihan_id' => $tagihan_id,
            'status'     => 'menunggu',
        ])->num_rows() > 0;
    }

    // Update di application/models/Tagihan_model.php
    public function is_used_in_pembayaran($id)
    {
        return $this->db->get_where('pembayaran', [
            'tagihan_id' => $id,
            'status'     => 'disetujui', 
        ])->num_rows() > 0;
    }
}