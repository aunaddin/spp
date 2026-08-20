<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Transaksi extends MY_Controller {

    public function __construct()
    {
        parent::__construct();
        // DIHAPUS: $this->cek_akses(['admin', 'bendahara']); — jangan taruh di sini
        $this->load->model('Pembayaran_model');
        $this->load->library('form_validation');
    }

    public function index()
    {
        $this->cek_akses(['admin', 'bendahara']);

        $keyword  = $this->input->get('keyword');
        $per_page = 10;
        $page     = max(1, (int) $this->input->get('page'));
        $offset   = ($page - 1) * $per_page;

        $data['tagihan_belum_lunas'] = $this->Pembayaran_model->get_tagihan_belum_lunas($keyword, $per_page, $offset);
        $data['total_rows']          = $this->Pembayaran_model->count_tagihan_belum_lunas($keyword);
        $data['current_page']        = $page;
        $data['total_pages']         = ceil($data['total_rows'] / $per_page);
        $data['keyword']             = $keyword;

        $this->load->view('templates/header');
        $this->load->view('transaksi/index', $data);
        $this->load->view('templates/footer');
    }
    public function bayar($tagihan_id)
    {
        $this->cek_akses(['admin', 'bendahara']); // DITAMBAHKAN di method ini

        $tagihan = $this->Pembayaran_model->get_tagihan_by_id($tagihan_id);

        if (!$tagihan) {
            show_404();
        }

        if ($tagihan->status == 'lunas') {
            $this->session->set_flashdata('error', 'Tagihan ini sudah lunas');
            redirect('transaksi');
            return;
        }

        if ($this->input->method() !== 'post') {
            $data['tagihan'] = $tagihan;
            $this->load->view('templates/header');
            $this->load->view('transaksi/form_bayar', $data);
            $this->load->view('templates/footer');
            return;
        }

        $this->form_validation->set_rules('tanggal_bayar', 'Tanggal Bayar', 'required');
        $this->form_validation->set_rules('metode_bayar', 'Metode Bayar', 'required|in_list[tunai,transfer]');

        if ($this->form_validation->run() == FALSE) {
            $data['tagihan'] = $tagihan;
            $this->session->set_flashdata('error', validation_errors());
            $this->load->view('templates/header');
            $this->load->view('transaksi/form_bayar', $data);
            $this->load->view('templates/footer');
            return;
        }

        $data_pembayaran = [
            'tagihan_id'      => $tagihan->id,
            'no_bukti'        => $this->Pembayaran_model->generate_no_bukti(),
            'tanggal_bayar'   => $this->input->post('tanggal_bayar', TRUE),
            'nominal_dibayar' => $tagihan->nominal,
            'metode_bayar'    => $this->input->post('metode_bayar', TRUE),
            'petugas_id'      => $this->user_id,
        ];

        $pembayaran_id = $this->Pembayaran_model->proses_pembayaran($data_pembayaran);

        if (!$pembayaran_id) {
            $this->session->set_flashdata('error', 'Gagal memproses pembayaran, silakan coba lagi');
            redirect('transaksi');
            return;
        }

        $this->session->set_flashdata('success', 'Pembayaran berhasil disimpan');
        redirect('transaksi/bukti/' . $pembayaran_id);
    }

    // Halaman cetak bukti — SENGAJA TIDAK dipasangi cek_akses(['admin','bendahara'])
    // supaya wali_santri juga bisa akses, dengan pengecekan kepemilikan manual di bawah
    public function bukti($pembayaran_id)
    {
        $pembayaran = $this->Pembayaran_model->get_by_id($pembayaran_id);

        if (!$pembayaran) {
            show_404();
        }

        // TAMBAHAN: hanya pembayaran berstatus disetujui yang boleh dicetak buktinya
        if ($pembayaran->status != 'disetujui') {
            show_error('Bukti pembayaran ini belum bisa dicetak karena belum disetujui bendahara', 403, 'Belum Tersedia');
        }

        // Kalau yang akses wali santri, pastikan pembayaran ini benar milik anaknya
        if ($this->role == 'wali_santri') {
            $this->load->model('Santri_model');
            $santri = $this->Santri_model->get_by_id($pembayaran->santri_id);

            if (!$santri || $santri->wali_id != $this->user_id) {
                show_error('Anda tidak memiliki akses ke bukti pembayaran ini', 403, 'Akses Ditolak');
            }
        }

        $data['pembayaran'] = $pembayaran;
        $this->load->view('transaksi/bukti', $data);
    }

    public function konfirmasi()
    {
        $this->cek_akses(['admin', 'bendahara']);
        $this->load->model('Pembayaran_model');

        $keyword = $this->input->get('keyword');
        $data['menunggu'] = $this->Pembayaran_model->get_menunggu_konfirmasi($keyword);
        $data['keyword']  = $keyword;

        $this->load->view('templates/header');
        $this->load->view('transaksi/konfirmasi', $data);
        $this->load->view('templates/footer');
    }
    public function detail_konfirmasi($id)
    {
        $this->cek_akses(['admin', 'bendahara']); // DITAMBAHKAN di method ini
        $this->load->model('Pembayaran_model');
        $pengajuan = $this->Pembayaran_model->get_pengajuan_by_id($id);

        if (!$pengajuan || $pengajuan->status != 'menunggu') {
            show_404();
        }

        $data['pengajuan'] = $pengajuan;
        $this->load->view('templates/header');
        $this->load->view('transaksi/detail_konfirmasi', $data);
        $this->load->view('templates/footer');
    }

    public function setujui($id)
    {
        $this->cek_akses(['admin', 'bendahara']); // DITAMBAHKAN di method ini
        $this->load->model('Pembayaran_model');
        $pengajuan = $this->Pembayaran_model->get_pengajuan_by_id($id);

        if (!$pengajuan || $pengajuan->status != 'menunggu') {
            show_404();
        }

        $berhasil = $this->Pembayaran_model->setujui($id, $this->user_id);

        if ($berhasil) {
            $this->session->set_flashdata('success', 'Pembayaran berhasil disetujui, tagihan otomatis menjadi lunas');
        } else {
            $this->session->set_flashdata('error', 'Gagal menyetujui pembayaran, silakan coba lagi');
        }
        redirect('transaksi/konfirmasi');
    }

    public function tolak($id)
    {
        $this->cek_akses(['admin', 'bendahara']); // DITAMBAHKAN di method ini
        $this->load->model('Pembayaran_model');
        $pengajuan = $this->Pembayaran_model->get_pengajuan_by_id($id);

        if (!$pengajuan || $pengajuan->status != 'menunggu') {
            show_404();
        }

        $this->form_validation->set_rules('alasan', 'Alasan Penolakan', 'required|trim');

        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('error', 'Alasan penolakan wajib diisi');
            redirect('transaksi/detail-konfirmasi/' . $id);
            return;
        }

        $this->Pembayaran_model->tolak($id, $this->user_id, $this->input->post('alasan', TRUE));
        $this->session->set_flashdata('success', 'Pengajuan pembayaran ditolak');
        redirect('transaksi/konfirmasi');
    }
}