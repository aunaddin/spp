<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pengeluaran extends MY_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->cek_akses(['admin', 'bendahara']);
        $this->load->model('Pengeluaran_model');
        $this->load->model('Kategori_pengeluaran_model');
        $this->load->library('form_validation');
    }

    public function index()
    {
        $filter = [
            'bulan'       => $this->input->get('bulan'),
            'tahun'       => $this->input->get('tahun'),
            'kategori_id' => $this->input->get('kategori_id'),
        ];

        $data['pengeluaran']     = $this->Pengeluaran_model->get_all($filter);
        $data['total']           = $this->Pengeluaran_model->get_total($filter);
        $data['kategori_options'] = $this->Kategori_pengeluaran_model->get_all();
        $data['filter']          = $filter;

        $this->load->view('templates/header');
        $this->load->view('pengeluaran/index', $data);
        $this->load->view('templates/footer');
    }

    public function tambah()
    {
        if ($this->input->method() !== 'post') {
            $data['kategori_options'] = $this->Kategori_pengeluaran_model->get_all_aktif();
            $this->load->view('templates/header');
            $this->load->view('pengeluaran/form_tambah', $data);
            $this->load->view('templates/footer');
            return;
        }

        $this->form_validation->set_rules('kategori_id', 'Kategori', 'required|numeric');
        $this->form_validation->set_rules('tanggal', 'Tanggal', 'required');
        $this->form_validation->set_rules('nominal', 'Nominal', 'required|numeric|greater_than[0]');

        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('error', validation_errors());
            $data['kategori_options'] = $this->Kategori_pengeluaran_model->get_all_aktif();
            $this->load->view('templates/header');
            $this->load->view('pengeluaran/form_tambah', $data);
            $this->load->view('templates/footer');
            return;
        }

        $data = [
            'kategori_id' => $this->input->post('kategori_id', TRUE),
            'tanggal'     => $this->input->post('tanggal', TRUE),
            'nominal'     => $this->input->post('nominal', TRUE),
            'keterangan'  => $this->input->post('keterangan', TRUE),
            'petugas_id'  => $this->user_id,
        ];

        $this->Pengeluaran_model->create($data);
        $this->session->set_flashdata('success', 'Data pengeluaran berhasil ditambahkan');
        redirect('pengeluaran');
    }

    public function edit($id)
    {
        $pengeluaran = $this->Pengeluaran_model->get_by_id($id);
        if (!$pengeluaran) {
            show_404();
        }

        if ($this->input->method() !== 'post') {
            $data['pengeluaran']      = $pengeluaran;
            $data['kategori_options'] = $this->Kategori_pengeluaran_model->get_all_aktif();
            $this->load->view('templates/header');
            $this->load->view('pengeluaran/form_edit', $data);
            $this->load->view('templates/footer');
            return;
        }

        $this->form_validation->set_rules('kategori_id', 'Kategori', 'required|numeric');
        $this->form_validation->set_rules('tanggal', 'Tanggal', 'required');
        $this->form_validation->set_rules('nominal', 'Nominal', 'required|numeric|greater_than[0]');

        if ($this->form_validation->run() == FALSE) {
            $data['pengeluaran']      = $pengeluaran;
            $data['kategori_options'] = $this->Kategori_pengeluaran_model->get_all_aktif();
            $this->session->set_flashdata('error', validation_errors());
            $this->load->view('templates/header');
            $this->load->view('pengeluaran/form_edit', $data);
            $this->load->view('templates/footer');
            return;
        }

        $data = [
            'kategori_id' => $this->input->post('kategori_id', TRUE),
            'tanggal'     => $this->input->post('tanggal', TRUE),
            'nominal'     => $this->input->post('nominal', TRUE),
            'keterangan'  => $this->input->post('keterangan', TRUE),
        ];

        $this->Pengeluaran_model->update($id, $data);
        $this->session->set_flashdata('success', 'Data pengeluaran berhasil diperbarui');
        redirect('pengeluaran');
    }

    public function hapus($id)
    {
        $this->Pengeluaran_model->delete($id);
        $this->session->set_flashdata('success', 'Data pengeluaran berhasil dihapus');
        redirect('pengeluaran');
    }
}