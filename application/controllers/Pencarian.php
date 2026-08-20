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

        if ($this->role == 'wali_santri') {
            $filter['wali_id'] = $this->user_id;
        }

        $per_page = 10;
        $page     = max(1, (int) $this->input->get('page'));
        $offset   = ($page - 1) * $per_page;

        $data['hasil']         = $this->Tagihan_model->search($filter, $per_page, $offset);
        $data['total_rows']    = $this->Tagihan_model->count_search($filter);
        $data['current_page']  = $page;
        $data['total_pages']   = ceil($data['total_rows'] / $per_page);
        $data['jenis_options'] = $this->Jenis_pembayaran_model->get_all_aktif();
        $data['filter']        = $filter;
        $data['role']          = $this->role;

        $this->load->view('templates/header');
        $this->load->view('pencarian/index', $data);
        $this->load->view('templates/footer');
    }
}