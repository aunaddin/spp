<div class="card">
    <div class="card-header">
        <h3 class="card-title">Konfirmasi Pembayaran Transfer</h3>
        <?php if (!empty($menunggu)): ?>
        <span class="badge badge-danger"><?= count($menunggu) ?> menunggu</span>
        <?php endif; ?>
    </div>
    <div class="card-body">

        <?php $this->load->view('templates/alert'); ?>

        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Tanggal Diajukan</th>
                    <th>Nama Santri</th>
                    <th>Diajukan Oleh</th>
                    <th>Jenis Pembayaran</th>
                    <th>Nominal</th>
                    <th width="160">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php $no = 1; foreach ($menunggu as $m): ?>
                <tr>
                    <td><?= $no++ ?></td>
                    <td><?= date('d-m-Y', strtotime($m->created_at)) ?></td>
                    <td><?= $m->nama_santri ?> (<?= $m->jenjang ?> <?= $m->nama_kelas ?>)</td>
                    <td><?= $m->nama_wali ?></td>
                    <td><?= $m->nama_pembayaran ?></td>
                    <td>Rp <?= number_format($m->nominal_dibayar, 0, ',', '.') ?></td>
                    <td>
                        <a href="<?= site_url('transaksi/detail-konfirmasi/' . $m->id) ?>" class="btn btn-primary btn-sm">
                            <i class="fas fa-eye"></i> Lihat Detail
                        </a>
                    </td>
                </tr>
                <?php endforeach; ?>
                <?php if (empty($menunggu)): ?>
                <tr><td colspan="7" class="text-center text-muted">Tidak ada pengajuan yang menunggu konfirmasi</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>