<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Riwayat extends MY_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Pembayaran_model');
    }

    public function index()
    {
        if ($this->role == 'wali_santri') {
            $data['riwayat'] = $this->Pembayaran_model->get_riwayat_by_wali($this->user_id);
        } else {
            $data['riwayat'] = $this->Pembayaran_model->get_riwayat_all();
        }

        $data['role'] = $this->role; // PERUBAHAN: kirim role sebagai variabel biasa ke view

        $this->load->view('templates/header');
        $this->load->view('riwayat/index', $data);
        $this->load->view('templates/footer');
    }
}