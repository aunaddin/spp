<div class="card">
    <div class="card-header">
        <h3 class="card-title">Kelola Data Pengeluaran</h3>
        <div class="card-tools">
            <a href="<?= site_url('pengeluaran/tambah') ?>" class="btn btn-primary btn-sm">
                <i class="fas fa-plus"></i> Tambah Pengeluaran
            </a>
        </div>
    </div>
    <div class="card-body">

        <?php $this->load->view('templates/alert'); ?>

        <?= form_open('pengeluaran', ['method' => 'get', 'class' => 'form-row mb-3']) ?>
            <div class="col-md-3 mb-2">
                <select name="kategori_id" class="form-control">
                    <option value="">-- Semua Kategori --</option>
                    <?php foreach ($kategori_options as $k): ?>
                        <option value="<?= $k->id ?>" <?= $filter['kategori_id'] == $k->id ? 'selected' : '' ?>>
                            <?= $k->nama_kategori ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-md-3 mb-2">
                <select name="bulan" class="form-control">
                    <option value="">-- Semua Bulan --</option>
                    <?php for ($i = 1; $i <= 12; $i++): ?>
                        <option value="<?= $i ?>" <?= $filter['bulan'] == $i ? 'selected' : '' ?>>
                            <?= date('F', mktime(0,0,0,$i,1)) ?>
                        </option>
                    <?php endfor; ?>
                </select>
            </div>
            <div class="col-md-2 mb-2">
                <input type="number" name="tahun" class="form-control" placeholder="Tahun" value="<?= $filter['tahun'] ?>">
            </div>
            <div class="col-md-2 mb-2">
                <button type="submit" class="btn btn-secondary btn-block">Filter</button>
            </div>
            <div class="col-md-2 mb-2">
                <a href="<?= site_url('pengeluaran') ?>" class="btn btn-link btn-block">Reset</a>
            </div>
        <?= form_close() ?>

        <div class="alert alert-danger">
            <b>Total Pengeluaran: Rp <?= number_format($total, 0, ',', '.') ?></b>
        </div>

        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Tanggal</th>
                    <th>Kategori</th>
                    <th>Keterangan</th>
                    <th>Nominal</th>
                    <th>Petugas</th>
                    <th width="120">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php $no = 1; foreach ($pengeluaran as $p): ?>
                <tr>
                    <td><?= $no++ ?></td>
                    <td><?= date('d-m-Y', strtotime($p->tanggal)) ?></td>
                    <td><?= $p->nama_kategori ?></td>
                    <td><?= $p->keterangan ?: '-' ?></td>
                    <td>Rp <?= number_format($p->nominal, 0, ',', '.') ?></td>
                    <td><?= $p->nama_petugas ?></td>
                    <td>
                        <a href="<?= site_url('pengeluaran/edit/' . $p->id) ?>" class="btn btn-warning btn-sm">
                            <i class="fas fa-edit"></i>
                        </a>
                        <a href="<?= site_url('pengeluaran/hapus/' . $p->id) ?>"
                           class="btn btn-danger btn-sm" onclick="return confirm('Hapus data pengeluaran ini?')">
                            <i class="fas fa-trash"></i>
                        </a>
                    </td>
                </tr>
                <?php endforeach; ?>
                <?php if (empty($pengeluaran)): ?>
                <tr><td colspan="7" class="text-center text-muted">Belum ada data pengeluaran</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
        <?php render_pagination($current_page, $total_pages); ?>
        <p class="text-muted text-center small">Menampilkan <?= count($pengeluaran) ?> dari <?= $total_rows ?> total data</p>
    </div>
</div>