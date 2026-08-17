<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Sistem Pembayaran SPP</title>
    <!-- AdminLTE -->
    <link rel="stylesheet"
          href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Custom Login CSS -->
    <link rel="stylesheet"
          href="<?= base_url('assets/css/login.css') ?>">
</head>

<body class="hold-transition login-page">
<div class="login-box">

    <!-- LOGO & JUDUL -->
    <div class="text-center mb-3">
        <img src="<?= base_url('assets/img/logo.png') ?>"
             class="logo-login"
             alt="Logo Pondok Pesantren Nurul Ali">
        <div class="login-title">
            Sistem Pembayaran Pondok Pesantren Nurul Ali
        </div>
        <div class="login-subtitle">
            Silakan login untuk melanjutkan
        </div>
    </div>

    <!-- PESAN ERROR -->
    <?php if ($this->session->flashdata('error')): ?>
        <div class="alert alert-danger">
            <?= $this->session->flashdata('error') ?>
        </div>
    <?php endif; ?>

    <!-- VALIDATION ERROR -->
    <?php echo validation_errors(
        '<div class="alert alert-danger">',
        '</div>'
    ); ?>

    <!-- FORM LOGIN -->
    <?= form_open('auth/login') ?>
        <!-- USERNAME -->
        <div class="input-group mb-3">
            <input type="text"
                   name="username"
                   class="form-control"
                   placeholder="Username"
                   value="<?= set_value('username') ?>">
            <div class="input-group-append">
                <div class="input-group-text">
                    <span class="fas fa-user"></span>
                </div>
            </div>
        </div>
        <!-- PASSWORD -->
        <div class="input-group mb-3">
            <input type="password"
                   name="password"
                   class="form-control"
                   placeholder="Password">
            <div class="input-group-append">
                <div class="input-group-text">
                    <span class="fas fa-lock"></span>
                </div>
            </div>
        </div>
        <p class="mb-3 text-right">
            <a href="<?= site_url('forgot-password') ?>" style="color: #fff;">
                Lupa Password?
            </a>
        </p>
        <!-- TOMBOL LOGIN -->
        <div class="row">
            <div class="col-12">
                <button type="submit"
                        class="btn btn-login btn-block">
                    <i class="fas fa-sign-in-alt mr-2"></i>
                    Login
                </button>
            </div>
        </div>
    <?= form_close() ?>
</div>

<!-- jQuery -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<!-- Bootstrap -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>