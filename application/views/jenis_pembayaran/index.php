<div class="card">
    <div class="card-header">
        <h3 class="card-title">Kelola Jenis Pembayaran</h3>
        <div class="card-tools">
            <a href="<?= site_url('jenis_pembayaran/tambah') ?>" class="btn btn-primary btn-sm">
                <i class="fas fa-plus"></i> Tambah Jenis Pembayaran
            </a>
        </div>
    </div>
    <div class="card-body">

        <?php $this->load->view('templates/alert'); ?>

        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Pembayaran</th>
                    <th>Nominal</th>
                    <th>Keterangan</th>
                    <th>Status</th>
                    <th width="160">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php $no = 1; foreach ($jenis as $j): ?>
                <tr>
                    <td><?= $no++ ?></td>
                    <td><?= $j->nama_pembayaran ?></td>
                    <td>Rp <?= number_format($j->nominal, 0, ',', '.') ?></td>
                    <td><?= $j->keterangan ?: '-' ?></td>
                    <td>
                        <?php if ($j->status == 'aktif'): ?>
                            <span class="badge badge-success">Aktif</span>
                        <?php else: ?>
                            <span class="badge badge-secondary">Nonaktif</span>
                        <?php endif; ?>
                    </td>
                    <td>
                        <a href="<?= site_url('jenis_pembayaran/edit/' . $j->id) ?>" class="btn btn-warning btn-sm">
                            <i class="fas fa-edit"></i>
                        </a>

                        <?php if ($j->status == 'aktif'): ?>
                            <a href="<?= site_url('jenis_pembayaran/nonaktifkan/' . $j->id) ?>"
                               class="btn btn-secondary btn-sm" onclick="return confirm('Nonaktifkan jenis pembayaran ini?')">
                                <i class="fas fa-ban"></i>
                            </a>
                        <?php else: ?>
                            <a href="<?= site_url('jenis_pembayaran/aktifkan/' . $j->id) ?>" class="btn btn-success btn-sm">
                                <i class="fas fa-check"></i>
                            </a>
                        <?php endif; ?>

                        <a href="<?= site_url('jenis_pembayaran/hapus/' . $j->id) ?>"
                           class="btn btn-danger btn-sm" onclick="return confirm('Hapus jenis pembayaran ini secara permanen?')">
                            <i class="fas fa-trash"></i>
                        </a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <?php render_pagination($current_page, $total_pages); ?>
        <p class="text-muted text-center small">Menampilkan <?= count($jenis) ?> dari <?= $total_rows ?> total data</p>
    </div>
</div>