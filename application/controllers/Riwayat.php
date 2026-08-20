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
        $keyword  = $this->input->get('keyword');
        $per_page = 10;
        $page     = max(1, (int) $this->input->get('page'));
        $offset   = ($page - 1) * $per_page;

        if ($this->role == 'wali_santri') {
            $data['riwayat']    = $this->Pembayaran_model->get_riwayat_by_wali($this->user_id, $keyword, $per_page, $offset);
            $data['total_rows'] = $this->Pembayaran_model->count_riwayat_by_wali($this->user_id, $keyword);
        } else {
            $data['riwayat']    = $this->Pembayaran_model->get_riwayat_all($keyword, $per_page, $offset);
            $data['total_rows'] = $this->Pembayaran_model->count_riwayat_all($keyword);
        }

        $data['current_page'] = $page;
        $data['total_pages']  = ceil($data['total_rows'] / $per_page);
        $data['keyword']      = $keyword;
        $data['role']         = $this->role;

        $this->load->view('templates/header');
        $this->load->view('riwayat/index', $data);
        $this->load->view('templates/footer');
    }
}