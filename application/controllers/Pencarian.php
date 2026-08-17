<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pencarian extends MY_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Tagihan_model');
        $this->load->model('Jenis_pembayaran_model');
    }

    public function index()
    {
        $filter = [
            'keyword'             => $this->input->get('keyword'),
            'jenis_pembayaran_id' => $this->input->get('jenis_pembayaran_id'),
            'bulan'               => $this->input->get('bulan'),
            'tahun'               => $this->input->get('tahun'),
            'status'              => $this->input->get('status'),
        ];

        // Wali santri hanya boleh cari data anaknya sendiri, dipaksa lewat filter wali_id
        if ($this->role == 'wali_santri') {
            $filter['wali_id'] = $this->user_id;
        }

        $data['hasil']         = $this->Tagihan_model->search($filter);
        $data['jenis_options'] = $this->Jenis_pembayaran_model->get_all();
        $data['filter']        = $filter;
        $data['role']          = $this->role;

        $this->load->view('templates/header');
        $this->load->view('pencarian/index', $data);
        $this->load->view('templates/footer');
    }
}