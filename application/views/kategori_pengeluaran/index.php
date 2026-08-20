<div class="card">
    <div class="card-header">
        <h3 class="card-title">Kelola Kategori Pengeluaran</h3>
        <div class="card-tools">
            <a href="<?= site_url('kategori_pengeluaran/tambah') ?>" class="btn btn-primary btn-sm">
                <i class="fas fa-plus"></i> Tambah Kategori
            </a>
        </div>
    </div>
    <div class="card-body">

        <?php $this->load->view('templates/alert'); ?>

        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Kategori</th>
                    <th>Keterangan</th>
                    <th>Status</th>
                    <th width="160">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php $no = 1; foreach ($kategori as $k): ?>
                <tr>
                    <td><?= $no++ ?></td>
                    <td><?= $k->nama_kategori ?></td>
                    <td><?= $k->keterangan ?: '-' ?></td>
                    <td>
                        <?php if ($k->status == 'aktif'): ?>
                            <span class="badge badge-success">Aktif</span>
                        <?php else: ?>
                            <span class="badge badge-secondary">Nonaktif</span>
                        <?php endif; ?>
                    </td>
                    <td>
                        <a href="<?= site_url('kategori_pengeluaran/edit/' . $k->id) ?>" class="btn btn-warning btn-sm">
                            <i class="fas fa-edit"></i>
                        </a>
                        <?php if ($k->status == 'aktif'): ?>
                            <a href="<?= site_url('kategori_pengeluaran/nonaktifkan/' . $k->id) ?>"
                               class="btn btn-secondary btn-sm" onclick="return confirm('Nonaktifkan kategori ini?')">
                                <i class="fas fa-ban"></i>
                            </a>
                        <?php else: ?>
                            <a href="<?= site_url('kategori_pengeluaran/aktifkan/' . $k->id) ?>" class="btn btn-success btn-sm">
                                <i class="fas fa-check"></i>
                            </a>
                        <?php endif; ?>
                        <a href="<?= site_url('kategori_pengeluaran/hapus/' . $k->id) ?>"
                           class="btn btn-danger btn-sm" onclick="return confirm('Hapus kategori ini secara permanen?')">
                            <i class="fas fa-trash"></i>
                        </a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        </table>
        <?php render_pagination($current_page, $total_pages); ?>
        <p class="text-muted text-center small">Menampilkan <?= count($kategori) ?> dari <?= $total_rows ?> total data</p>
    </div>
</div>