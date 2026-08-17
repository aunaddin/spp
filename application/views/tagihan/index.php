<div class="card">
    <div class="card-header">
        <h3 class="card-title">Kelola Data Tagihan</h3>
        <div class="card-tools">
            <a href="<?= site_url('tagihan/generate') ?>" class="btn btn-success btn-sm">
                <i class="fas fa-magic"></i> Generate Massal
            </a>
            <a href="<?= site_url('tagihan/tambah') ?>" class="btn btn-primary btn-sm">
                <i class="fas fa-plus"></i> Tambah Manual
            </a>
        </div>
    </div>
    <div class="card-body">
        <?php $this->load->view('templates/alert'); ?>
        <?= form_open('tagihan', ['method' => 'get', 'class' => 'form-inline mb-3']) ?>
            <select name="bulan" class="form-control mr-2">
                <option value="">-- Semua Bulan --</option>
                <?php foreach (['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'] as $b): ?>
                    <option value="<?= $b ?>" <?= $filter_bulan == $b ? 'selected' : '' ?>><?= $b ?></option>
                <?php endforeach; ?>
            </select>
            <input type="number" name="tahun" class="form-control mr-2" placeholder="Tahun" value="<?= $filter_tahun ?>" style="width:120px">
            <button type="submit" class="btn btn-secondary">Filter</button>
            <a href="<?= site_url('tagihan') ?>" class="btn btn-link">Reset</a>
        <?= form_close() ?>

        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>No</th>
                    <th>NIS</th>
                    <th>Nama Santri</th>
                    <th>Kelas</th>  <!-- TAMBAHAN -->
                    <th>Jenis Pembayaran</th>
                    <th>Periode</th>
                    <th>Nominal</th>
                    <th>Jatuh Tempo</th>
                    <th>Status</th>
                    <th width="140">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php $no = 1; foreach ($tagihan as $t): ?>
                <tr>
                    <td><?= $no++ ?></td>
                    <td><?= $t->nis ?></td>
                    <td><?= $t->nama_santri ?></td>
                    <td><?= $t->jenjang ?> - <?= $t->nama_kelas ?></td>  <!-- TAMBAHAN -->
                    <td><?= $t->nama_pembayaran ?></td>
                    <td><?= $t->bulan ?> <?= $t->tahun ?></td>
                    <td>Rp <?= number_format($t->nominal, 0, ',', '.') ?></td>
                    <td><?= date('d-m-Y', strtotime($t->jatuh_tempo)) ?></td>
                    <td>
                        <?php if ($t->status == 'lunas'): ?>
                            <span class="badge badge-success">Lunas</span>
                        <?php else: ?>
                            <span class="badge badge-danger">Belum Lunas</span>
                        <?php endif; ?>
                    </td>
                    <td>
                        <a href="<?= site_url('tagihan/edit/' . $t->id) ?>" class="btn btn-warning btn-sm">
                            <i class="fas fa-edit"></i>
                        </a>
                        <a href="<?= site_url('tagihan/hapus/' . $t->id) ?>"
                        class="btn btn-danger btn-sm" onclick="return confirm('Hapus tagihan ini?')">
                            <i class="fas fa-trash"></i>
                        </a>
                    </td>
                </tr>
                <?php endforeach; ?>
                <?php if (empty($tagihan)): ?>
                <tr><td colspan="10" class="text-center text-muted">Belum ada data tagihan</td></tr>  <!-- colspan diubah dari 9 jadi 10 -->
                <?php endif; ?>
            </tbody>
        </table>
        <?php render_pagination($current_page, $total_pages); ?>
        <p class="text-muted text-center small">Menampilkan <?= count($tagihan) ?> dari <?= $total_rows ?> total data</p>
    </div>
</div>