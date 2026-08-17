<!DOCTYPE html>
<html>
<head>
    <title>Reset Password - Sistem Pembayaran SPP</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="<?= base_url('assets/css/login.css') ?>">
</head>
<body class="hold-transition login-page">
<div class="login-box">
    <div class="text-center mb-3">
        <img src="<?= base_url('assets/img/logo.png') ?>" class="logo-login">

        <div class="login-title">
            Sistem Pembayaran Pondok Pesantren Nurul Ali
        </div>

        <div class="login-subtitle">
            Masukkan password baru Anda
        </div>
    </div>

    <?php if ($this->session->flashdata('error')): ?>
        <div class="alert alert-danger"><?= $this->session->flashdata('error') ?></div>
    <?php endif; ?>

    <?php echo validation_errors('<div class="alert alert-danger">', '</div>'); ?>

    <?= form_open('reset-password/' . $token) ?>
        <div class="input-group mb-3">
            <input type="password" name="password" class="form-control" placeholder="Password Baru" required>
            <div class="input-group-append">
                <div class="input-group-text"><span class="fas fa-lock"></span></div>
            </div>
        </div>
        <div class="input-group mb-3">
            <input type="password" name="konfirmasi_password" class="form-control" placeholder="Konfirmasi Password Baru" required>
            <div class="input-group-append">
                <div class="input-group-text"><span class="fas fa-lock"></span></div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <button type="submit" class="btn btn-login btn-block">
                    <i class="fas fa-check mr-2"></i>
                    Reset Password
                </button>
            </div>
        </div>
    <?= form_close() ?>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>