<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pembayaran_wali extends MY_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->cek_akses(['wali_santri']); // hanya wali santri
        $this->load->model('Pembayaran_model');
        $this->load->model('Dashboard_model');
        $this->load->library('form_validation');
    }

    // Daftar tagihan anak yang belum lunas, dengan tombol "Bayar via Transfer"
    public function index()
    {
        $data['tagihan_anak'] = $this->Dashboard_model->tagihan_anak_belum_lunas($this->user_id);

        $this->load->view('templates/header');
        $this->load->view('pembayaran_wali/index', $data);
        $this->load->view('templates/footer');
    }

    public function bayar($tagihan_id)
    {
        $this->load->model('Pembayaran_model');
        $this->load->model('Santri_model');

        // Pastikan tagihan ini benar milik anak dari wali yang login (keamanan)
        $tagihan = $this->Pembayaran_model->get_tagihan_by_id($tagihan_id);
        if (!$tagihan) {
            show_404();
        }

        $santri = $this->Santri_model->get_by_id($tagihan->santri_id);
        if (!$santri || $santri->wali_id != $this->user_id) {
            show_error('Anda tidak memiliki akses ke tagihan ini', 403, 'Akses Ditolak');
        }

        if ($tagihan->status == 'lunas') {
            $this->session->set_flashdata('error', 'Tagihan ini sudah lunas');
            redirect('pembayaran-wali');
            return;
        }

        if ($this->Pembayaran_model->is_ada_pengajuan_menunggu($tagihan_id)) {
            $this->session->set_flashdata('error', 'Anda sudah mengajukan pembayaran untuk tagihan ini, sedang menunggu konfirmasi admin');
            redirect('pembayaran-wali');
            return;
        }

        if ($this->input->method() !== 'post') {
            $data['tagihan'] = $tagihan;
            $this->load->view('templates/header');
            $this->load->view('pembayaran_wali/form_bayar', $data);
            $this->load->view('templates/footer');
            return;
        }

        // Validasi file upload
        $config['upload_path']   = './uploads/bukti_transfer/';
        $config['allowed_types'] = 'jpg|jpeg|png';
        $config['max_size']      = 2048; // 2MB
        $config['file_name']     = 'bukti_' . $tagihan_id . '_' . time();

        $this->load->library('upload', $config);

        if (!$this->upload->do_upload('bukti_transfer')) {
            $data['tagihan'] = $tagihan;
            $this->session->set_flashdata('error', $this->upload->display_errors('', ''));
            $this->load->view('templates/header');
            $this->load->view('pembayaran_wali/form_bayar', $data);
            $this->load->view('templates/footer');
            return;
        }

        $upload_data = $this->upload->data();

        $data_pembayaran = [
            'tagihan_id'      => $tagihan->id,
            'no_bukti'        => $this->Pembayaran_model->generate_no_bukti(),
            'tanggal_bayar'   => $this->input->post('tanggal_bayar', TRUE),
            'nominal_dibayar' => $tagihan->nominal,
            'metode_bayar'    => 'transfer',
            'bukti_transfer'  => $upload_data['file_name'],
            'status'          => 'menunggu',
            'diajukan_oleh'   => $this->user_id,
            'petugas_id'      => NULL,
        ];

        $this->Pembayaran_model->submit_transfer($data_pembayaran);

        $this->session->set_flashdata('success', 'Bukti transfer berhasil dikirim, menunggu konfirmasi dari bendahara');
        redirect('pembayaran-wali');
    }
}