<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tagihan extends MY_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->cek_akses(['admin', 'bendahara']);
        $this->load->model('Tagihan_model');
        $this->load->model('Santri_model');
        $this->load->model('Jenis_pembayaran_model');
        $this->load->library('form_validation');
    }

    public function index()
    {
        $bulan = $this->input->get('bulan');
        $tahun = $this->input->get('tahun');

        $per_page = 10;
        $page     = max(1, (int) $this->input->get('page'));
        $offset   = ($page - 1) * $per_page;

        $data['tagihan']       = $this->Tagihan_model->get_all($bulan, $tahun, $per_page, $offset);
        $data['total_rows']    = $this->Tagihan_model->count_all($bulan, $tahun);
        $data['current_page']  = $page;
        $data['total_pages']   = ceil($data['total_rows'] / $per_page);
        $data['filter_bulan']  = $bulan;
        $data['filter_tahun']  = $tahun;

        $this->load->view('templates/header');
        $this->load->view('tagihan/index', $data);
        $this->load->view('templates/footer');
    }

    // Generate massal — untuk semua santri aktif sekaligus
    public function generate()
    {
        if ($this->input->method() !== 'post') {
            $this->load->model('Kelas_model'); // TAMBAHAN
            $data['jenis_options'] = $this->Jenis_pembayaran_model->get_all_aktif();
            $data['kelas_options'] = $this->Kelas_model->get_all_aktif(); // TAMBAHAN
            $this->load->view('templates/header');
            $this->load->view('tagihan/form_generate', $data);
            $this->load->view('templates/footer');
            return;
        }

        $this->form_validation->set_rules('jenis_pembayaran_id', 'Jenis Pembayaran', 'required|numeric');
        $this->form_validation->set_rules('bulan', 'Bulan', 'required');
        $this->form_validation->set_rules('tahun', 'Tahun', 'required|numeric');
        $this->form_validation->set_rules('jatuh_tempo', 'Jatuh Tempo', 'required');
        $this->form_validation->set_rules('kelas_id[]', 'Kelas', 'required'); // TAMBAHAN: wajib pilih minimal 1 kelas

        if ($this->form_validation->run() == FALSE) {
            $this->load->model('Kelas_model');
            $this->session->set_flashdata('error', validation_errors());
            $data['jenis_options'] = $this->Jenis_pembayaran_model->get_all_aktif();
            $data['kelas_options'] = $this->Kelas_model->get_all_aktif();
            $this->load->view('templates/header');
            $this->load->view('tagihan/form_generate', $data);
            $this->load->view('templates/footer');
            return;
        }

        $jenis_id = $this->input->post('jenis_pembayaran_id', TRUE);
        $jenis    = $this->Jenis_pembayaran_model->get_by_id($jenis_id);

        // PERUBAHAN UTAMA: ambil santri HANYA dari kelas yang dipilih, bukan semua santri aktif
        $kelas_ids     = $this->input->post('kelas_id'); // array, dari checkbox
        $semua_santri  = $this->Santri_model->get_by_kelas_ids($kelas_ids);
        $santri_ids    = array_map(function($s) { return $s->id; }, $semua_santri);

        $hasil = $this->Tagihan_model->generate_bulk(
            $santri_ids,
            $jenis_id,
            $jenis->nominal,
            $this->input->post('bulan', TRUE),
            $this->input->post('tahun', TRUE),
            $this->input->post('jatuh_tempo', TRUE)
        );

        $this->session->set_flashdata('success',
            "Tagihan berhasil dibuat untuk {$hasil['berhasil']} santri. " .
            ($hasil['dilewati'] > 0 ? "{$hasil['dilewati']} santri dilewati karena sudah punya tagihan periode ini." : "")
        );
        redirect('tagihan');
    }

    // Tambah tagihan untuk 1 santri saja (kasus khusus, misal santri pindahan)
    public function tambah()
    {
        if ($this->input->method() !== 'post') {
            $data['santri_options'] = $this->Santri_model->get_all();
            $data['jenis_options']  = $this->Jenis_pembayaran_model->get_all_aktif();
            $this->load->view('templates/header');
            $this->load->view('tagihan/form_tambah', $data);
            $this->load->view('templates/footer');
            return;
        }

        $this->form_validation->set_rules('santri_id', 'Santri', 'required|numeric');
        $this->form_validation->set_rules('jenis_pembayaran_id', 'Jenis Pembayaran', 'required|numeric');
        $this->form_validation->set_rules('bulan', 'Bulan', 'required');
        $this->form_validation->set_rules('tahun', 'Tahun', 'required|numeric');
        $this->form_validation->set_rules('jatuh_tempo', 'Jatuh Tempo', 'required');

        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('error', validation_errors());
            $data['santri_options'] = $this->Santri_model->get_all();
            $data['jenis_options']  = $this->Jenis_pembayaran_model->get_all_aktif();
            $this->load->view('templates/header');
            $this->load->view('tagihan/form_tambah', $data);
            $this->load->view('templates/footer');
            return;
        }

        $santri_id = $this->input->post('santri_id', TRUE);
        $jenis_id  = $this->input->post('jenis_pembayaran_id', TRUE);
        $bulan     = $this->input->post('bulan', TRUE);
        $tahun     = $this->input->post('tahun', TRUE);

        if ($this->Tagihan_model->is_tagihan_exists($santri_id, $jenis_id, $bulan, $tahun)) {
            $this->session->set_flashdata('error', 'Santri ini sudah punya tagihan untuk jenis pembayaran & periode yang sama');
            redirect('tagihan/tambah');
            return;
        }

        $jenis = $this->Jenis_pembayaran_model->get_by_id($jenis_id);

        $data = [
            'santri_id'           => $santri_id,
            'jenis_pembayaran_id' => $jenis_id,
            'bulan'               => $bulan,
            'tahun'               => $tahun,
            'nominal'             => $jenis->nominal,
            'jatuh_tempo'         => $this->input->post('jatuh_tempo', TRUE),
            'status'              => 'belum_lunas',
        ];

        $this->Tagihan_model->create($data);
        $this->session->set_flashdata('success', 'Tagihan berhasil ditambahkan');
        redirect('tagihan');
    }

    public function edit($id)
    {
        $tagihan = $this->Tagihan_model->get_by_id($id);
        if (!$tagihan) {
            show_404();
        }

        if ($this->input->method() !== 'post') {
            $data['tagihan'] = $tagihan;
            $this->load->view('templates/header');
            $this->load->view('tagihan/form_edit', $data);
            $this->load->view('templates/footer');
            return;
        }

        $this->form_validation->set_rules('nominal', 'Nominal', 'required|numeric|greater_than[0]');
        $this->form_validation->set_rules('jatuh_tempo', 'Jatuh Tempo', 'required');

        if ($this->form_validation->run() == FALSE) {
            $data['tagihan'] = $tagihan;
            $this->session->set_flashdata('error', validation_errors());
            $this->load->view('templates/header');
            $this->load->view('tagihan/form_edit', $data);
            $this->load->view('templates/footer');
            return;
        }

        $data = [
            'nominal'     => $this->input->post('nominal', TRUE),
            'jatuh_tempo' => $this->input->post('jatuh_tempo', TRUE),
        ];

        $this->Tagihan_model->update($id, $data);
        $this->session->set_flashdata('success', 'Tagihan berhasil diperbarui');
        redirect('tagihan');
    }

    public function hapus($id)
    {
        if ($this->Tagihan_model->is_used_in_pembayaran($id)) {
            $this->session->set_flashdata('error', 'Tidak bisa dihapus, tagihan ini sudah ada transaksi pembayarannya');
            redirect('tagihan');
            return;
        }

        $this->Tagihan_model->delete($id);
        $this->session->set_flashdata('success', 'Tagihan berhasil dihapus');
        redirect('tagihan');
    }
}