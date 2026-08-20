<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Laporan extends MY_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->cek_akses(['admin', 'bendahara']);
        $this->load->model('Pembayaran_model');
        $this->load->model('Jenis_pembayaran_model');
    }

    public function index()
    {
        $filter = [
            'bulan'               => $this->input->get('bulan'),
            'tahun'               => $this->input->get('tahun'),
            'jenis_pembayaran_id' => $this->input->get('jenis_pembayaran_id'),
            'tanggal_dari'        => $this->input->get('tanggal_dari'),
            'tanggal_sampai'      => $this->input->get('tanggal_sampai'),
        ];

        $per_page = 10;
        $page     = max(1, (int) $this->input->get('page'));
        $offset   = ($page - 1) * $per_page;

        $data['laporan']       = $this->Pembayaran_model->get_laporan($filter, $per_page, $offset);
        $data['total']         = $this->Pembayaran_model->get_total_laporan($filter);
        $data['total_rows']    = $this->Pembayaran_model->count_laporan($filter);
        $data['current_page']  = $page;
        $data['total_pages']   = ceil($data['total_rows'] / $per_page);
        $data['jenis_options'] = $this->Jenis_pembayaran_model->get_all_aktif();
        $data['filter']        = $filter;

        $this->load->view('templates/header');
        $this->load->view('laporan/index', $data);
        $this->load->view('templates/footer');
    }

    // Halaman cetak — TIDAK diberi pagination, karena cetak harus menampilkan SEMUA data sesuai filter
    public function cetak()
    {
        $filter = [
            'bulan'               => $this->input->get('bulan'),
            'tahun'               => $this->input->get('tahun'),
            'jenis_pembayaran_id' => $this->input->get('jenis_pembayaran_id'),
            'tanggal_dari'        => $this->input->get('tanggal_dari'),
            'tanggal_sampai'      => $this->input->get('tanggal_sampai'),
        ];

        $data['laporan'] = $this->Pembayaran_model->get_laporan($filter); // tanpa limit, ambil semua
        $data['total']   = $this->Pembayaran_model->get_total_laporan($filter);
        $data['filter']  = $filter;

        $this->load->view('laporan/cetak', $data);
    }
}