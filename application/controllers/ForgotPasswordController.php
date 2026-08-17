<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ForgotPasswordController extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('User_model');
        $this->load->library('form_validation');
        $this->load->library('email');
    }

    // Halaman form input email
    public function index()
    {
        $this->load->view('auth/forgot_password');
    }

    // Proses kirim email reset
    public function kirim()
    {
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email');

        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('error', validation_errors());
            redirect('forgot-password');
            return;
        }

        $email = $this->input->post('email', TRUE);
        $user  = $this->User_model->get_by_email($email);

        // Demi keamanan, pesan sukses sama saja walau email tidak ditemukan
        // (mencegah orang lain menebak-nebak email mana yang terdaftar di sistem)
        if (!$user) {
            $this->session->set_flashdata('success', 'Jika email terdaftar, link reset password sudah dikirim. Cek inbox/spam Anda.');
            redirect('forgot-password');
            return;
        }

        $token  = bin2hex(random_bytes(32)); // token acak 64 karakter
        $expiry = date('Y-m-d H:i:s', strtotime('+1 hour')); // berlaku 1 jam

        $this->User_model->set_reset_token($user->id, $token, $expiry);

        $reset_link = site_url('reset-password/' . $token);

        $this->email->from('email_anda@gmail.com', 'Sistem SPP Sekolah');
        $this->email->to($email);
        $this->email->subject('Reset Password - Sistem SPP');
        $this->email->message("
            <p>Halo {$user->nama},</p>
            <p>Klik link berikut untuk reset password Anda (berlaku 1 jam):</p>
            <p><a href='{$reset_link}'>{$reset_link}</a></p>
            <p>Jika Anda tidak meminta reset password, abaikan email ini.</p>
        ");

        if ($this->email->send()) {
            $this->session->set_flashdata('success', 'Jika email terdaftar, link reset password sudah dikirim. Cek inbox/spam Anda.');
        } else {
            // Log error asli untuk debug, tapi tetap tampilkan pesan aman ke user
            log_message('error', 'Gagal kirim email reset password: ' . $this->email->print_debugger(['headers']));
            $this->session->set_flashdata('error', 'Gagal mengirim email, silakan coba lagi nanti');
        }

        redirect('forgot-password');
    }

    // Halaman form reset password baru
    public function reset($token)
    {
        $user = $this->User_model->get_by_reset_token($token);

        if (!$user) {
            $this->session->set_flashdata('error', 'Link reset password tidak valid atau sudah kedaluwarsa');
            redirect('forgot-password');
            return;
        }

        if ($this->input->method() !== 'post') {
            $data['token'] = $token;
            $this->load->view('auth/reset_password', $data);
            return;
        }

        $this->form_validation->set_rules('password', 'Password Baru', 'required|min_length[5]');
        $this->form_validation->set_rules('konfirmasi_password', 'Konfirmasi Password', 'matches[password]');

        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('error', validation_errors());
            $data['token'] = $token;
            $this->load->view('auth/reset_password', $data);
            return;
        }

        $password_baru = $this->input->post('password', TRUE);

        $this->User_model->update($user->id, ['password' => md5($password_baru)]);
        $this->User_model->clear_reset_token($user->id); // token hanya bisa dipakai sekali

        $this->session->set_flashdata('success', 'Password berhasil direset, silakan login dengan password baru');
        redirect('auth');
    }
}