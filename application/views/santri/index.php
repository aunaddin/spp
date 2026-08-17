<div class="card">
    <div class="card-header">
        <h3 class="card-title">Kelola Data Santri</h3>
        <div class="card-tools">
            <a href="<?= site_url('kelola_santri/tambah') ?>" class="btn btn-primary btn-sm">
                <i class="fas fa-plus"></i> Tambah Santri
            </a>
        </div>
    </div>
    <div class="card-body">
        <?php $this->load->view('templates/alert'); ?>
        <?= form_open('kelola_santri', ['method' => 'get', 'class' => 'form-inline mb-3']) ?>
            <input type="text" name="keyword" class="form-control mr-2" style="width:300px"
                placeholder="Cari nama, atau NIS ..." value="<?= $keyword ?>">
            <button type="submit" class="btn btn-secondary">Cari</button>
            <?php if ($keyword): ?>
                <a href="<?= site_url('kelola_santri') ?>" class="btn btn-link">Reset</a>
            <?php endif; ?>
        <?= form_close() ?>

        <table class="table table-bordered table-striped" id="tabelSantri">
            <thead>
                <tr>
                    <th>No</th>
                    <th>NIS</th>
                    <th>Nama</th>
                    <th>Kelas</th>
                    <th>L/P</th>
                    <th>Wali</th>
                    <th>Status</th>
                    <th width="160">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php $no = 1; foreach ($santri as $s): ?>
                <tr>
                    <td><?= $no++ ?></td>
                    <td><?= $s->nis ?></td>
                    <td><?= $s->nama ?></td>
                    <td><?= $s->nama_kelas.' - '.$s->jenjang ?></td>
                    <td><?= $s->jenis_kelamin ?></td>
                    <td><?= $s->nama_wali ?: '<span class="text-muted">Belum diisi</span>' ?></td>
                    <td>
                        <?php if ($s->status == 'aktif'): ?>
                            <span class="badge badge-success">Aktif</span>
                        <?php else: ?>
                            <span class="badge badge-secondary">Nonaktif</span>
                        <?php endif; ?>
                    </td>
                    <td>
                        <a href="<?= site_url('kelola_santri/edit/' . $s->id) ?>" class="btn btn-warning btn-sm">
                            <i class="fas fa-edit"></i>
                        </a>

                        <?php if ($s->status == 'aktif'): ?>
                            <a href="<?= site_url('kelola_santri/nonaktifkan/' . $s->id) ?>"
                               class="btn btn-secondary btn-sm" onclick="return confirm('Nonaktifkan santri ini?')">
                                <i class="fas fa-ban"></i>
                            </a>
                        <?php else: ?>
                            <a href="<?= site_url('kelola_santri/aktifkan/' . $s->id) ?>" class="btn btn-success btn-sm">
                                <i class="fas fa-check"></i>
                            </a>
                        <?php endif; ?>

                        <a href="<?= site_url('kelola_santri/hapus/' . $s->id) ?>"
                           class="btn btn-danger btn-sm" onclick="return confirm('Hapus data santri ini secara permanen?')">
                            <i class="fas fa-trash"></i>
                        </a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <?php render_pagination($current_page, $total_pages); ?>
    <p class="text-muted text-center small">Menampilkan <?= count($santri) ?> dari <?= $total_rows ?> total data</p>
    </div>
</div>