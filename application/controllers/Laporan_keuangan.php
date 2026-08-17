<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Laporan_keuangan extends MY_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->cek_akses(['admin', 'bendahara']);
        $this->load->model('Pembayaran_model');
        $this->load->model('Pengeluaran_model');
    }

    public function index()
    {
        $bulan = $this->input->get('bulan') ?: date('n');
        $tahun = $this->input->get('tahun') ?: date('Y');

        $total_masuk  = $this->Pembayaran_model->get_total_masuk($bulan, $tahun);
        $total_keluar = $this->Pengeluaran_model->get_total(['bulan' => $bulan, 'tahun' => $tahun]);

        $data['bulan']            = $bulan;
        $data['tahun']            = $tahun;
        $data['total_masuk']      = $total_masuk;
        $data['total_keluar']     = $total_keluar;
        $data['saldo']            = $total_masuk - $total_keluar;
        $data['rekap_pengeluaran'] = $this->Pengeluaran_model->get_rekap_per_kategori($bulan, $tahun);

        $this->load->view('templates/header');
        $this->load->view('laporan_keuangan/index', $data);
        $this->load->view('templates/footer');
    }

    public function cetak()
    {
        $bulan = $this->input->get('bulan') ?: date('n');
        $tahun = $this->input->get('tahun') ?: date('Y');

        $total_masuk  = $this->Pembayaran_model->get_total_masuk($bulan, $tahun);
        $total_keluar = $this->Pengeluaran_model->get_total(['bulan' => $bulan, 'tahun' => $tahun]);

        $data['bulan']             = $bulan;
        $data['tahun']             = $tahun;
        $data['total_masuk']       = $total_masuk;
        $data['total_keluar']      = $total_keluar;
        $data['saldo']             = $total_masuk - $total_keluar;
        $data['rekap_pengeluaran'] = $this->Pengeluaran_model->get_rekap_per_kategori($bulan, $tahun);
        $data['detail_pengeluaran'] = $this->Pengeluaran_model->get_all(['bulan' => $bulan, 'tahun' => $tahun]);

        $this->load->view('laporan_keuangan/cetak', $data);
    }
}