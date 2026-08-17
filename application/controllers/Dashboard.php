<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends MY_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Dashboard_model');
    }

    public function index()
    {
        if ($this->role == 'admin' || $this->role == 'bendahara') {
            $data['total_santri']       = $this->Dashboard_model->total_santri_aktif();
            $data['total_belum_lunas']  = $this->Dashboard_model->total_tagihan_belum_lunas();
            $data['total_pemasukan']    = $this->Dashboard_model->total_pemasukan_bulan_ini();
            $data['total_transaksi']    = $this->Dashboard_model->total_transaksi_hari_ini();
            $data['grafik_pemasukan']   = $this->Dashboard_model->pemasukan_6_bulan();
            $data['tagihan_terlambat']  = $this->Dashboard_model->tagihan_terlambat();

            $this->load->view('templates/header');
            $this->load->view('dashboard/admin_bendahara', $data);
            $this->load->view('templates/footer');
        } else {
            // wali_santri
            $data['total_anak']         = $this->Dashboard_model->total_anak($this->user_id);
            $data['total_belum_lunas']  = $this->Dashboard_model->total_tagihan_anak_belum_lunas($this->user_id);
            $data['tagihan_anak']       = $this->Dashboard_model->tagihan_anak_belum_lunas($this->user_id);

            $this->load->view('templates/header');
            $this->load->view('dashboard/wali', $data);
            $this->load->view('templates/footer');
        }
    }
}