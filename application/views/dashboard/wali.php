<div class="dashboard-header d-flex align-items-center">

    <img src="<?= base_url('assets/img/logo.png') ?>"
         class="dashboard-logo mr-3"
         alt="Logo">

    <div>
        <h3 class="mb-1">Dashboard Wali Santri</h3>
        <p class="mb-0">
            Selamat datang di Sistem Pembayaran Pondok Pesantren Nurul Ali
        </p>
    </div>

</div>

<div class="row">

    <div class="col-lg-6 col-md-6 mb-4">

        <div class="card stat-card bg-success">

            <div class="card-body">

                <i class="fas fa-child"></i>

                <small>Anak Terdaftar</small>

                <h2><?= number_format($total_anak) ?></h2>

            </div>

        </div>

    </div>

    <div class="col-lg-6 col-md-6 mb-4">

        <div class="card stat-card bg-danger">

            <div class="card-body">

                <i class="fas fa-file-invoice"></i>

                <small>Tagihan Belum Lunas</small>

                <h2><?= number_format($total_belum_lunas) ?></h2>

            </div>

        </div>

    </div>

</div>

<div class="card card-modern">

    <div class="card-header">

        <i class="fas fa-money-check-alt text-success mr-2"></i>

        Tagihan yang Perlu Dibayar

    </div>

    <div class="card-body">

        <div class="table-responsive">

            <table class="table table-hover table-bordered">

                <thead class="bg-success text-white">

                    <tr>

                        <th>Nama Anak</th>

                        <th>Jenis Pembayaran</th>

                        <th>Periode</th>

                        <th>Nominal</th>

                        <th>Jatuh Tempo</th>

                    </tr>

                </thead>

                <tbody>

                <?php if (empty($tagihan_anak)): ?>

                    <tr>

                        <td colspan="5" class="text-center p-5">

                            <i class="fas fa-check-circle text-success fa-3x mb-3"></i>

                            <br>

                            <strong>Semua tagihan sudah lunas 🎉</strong>

                        </td>

                    </tr>

                <?php endif; ?>

                <?php foreach ($tagihan_anak as $t): ?>

                    <tr>

                        <td>

                            <strong><?= $t->nama_santri ?></strong>

                        </td>

                        <td>

                            <?= $t->nama_pembayaran ?>

                        </td>

                        <td>

                            <?= $t->bulan ?> <?= $t->tahun ?>

                        </td>

                        <td class="font-weight-bold text-success">

                            Rp <?= number_format($t->nominal,0,',','.') ?>

                        </td>

                        <td>

                            <?= date('d-m-Y',strtotime($t->jatuh_tempo)) ?>

                            <?php if(strtotime($t->jatuh_tempo) < strtotime(date('Y-m-d'))): ?>

                                <span class="badge badge-danger ml-2">

                                    Terlambat

                                </span>

                            <?php else: ?>

                                <span class="badge badge-success ml-2">

                                    Belum Jatuh Tempo

                                </span>

                            <?php endif; ?>

                        </td>

                    </tr>

                <?php endforeach; ?>

                </tbody>

            </table>

        </div>

        <div class="text-right mt-3">

            <a href="<?= site_url('riwayat') ?>" class="btn btn-success">

                <i class="fas fa-history mr-1"></i>

                Lihat Riwayat Pembayaran

            </a>

        </div>

    </div>

</div>