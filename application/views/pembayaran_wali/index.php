<div class="card">
    <div class="card-header">
        <h3 class="card-title">Pembayaran via Transfer</h3>
    </div>
    <div class="card-body">

        <?php $this->load->view('templates/alert'); ?>

        <div class="alert alert-info">
            <b>Rekening Bendahara:</b> BSI 7123456789 a.n. Yayasan Nurul Ali<br>
            Setelah transfer, upload bukti transfer di sini. Pembayaran akan dikonfirmasi oleh bendahara maksimal 1x24 jam.
        </div>

        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>Nama Anak</th>
                    <th>Jenis Pembayaran</th>
                    <th>Periode</th>
                    <th>Nominal</th>
                    <th>Jatuh Tempo</th>
                    <th width="140">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($tagihan_anak)): ?>
                <tr><td colspan="6" class="text-center text-muted">Semua tagihan sudah lunas 🎉</td></tr>
                <?php endif; ?>
                <?php foreach ($tagihan_anak as $t): ?>
                <tr>
                    <td><?= $t->nama_santri ?></td>
                    <td><?= $t->nama_pembayaran ?></td>
                    <td><?= $t->bulan ?> <?= $t->tahun ?></td>
                    <td>Rp <?= number_format($t->nominal, 0, ',', '.') ?></td>
                    <td><?= date('d-m-Y', strtotime($t->jatuh_tempo)) ?></td>
                    <td>
                        <a href="<?= site_url('pembayaran-wali/bayar/' . $t->id) ?>" class="btn btn-success btn-sm">
                            <i class="fas fa-upload"></i> Bayar via Transfer
                        </a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>