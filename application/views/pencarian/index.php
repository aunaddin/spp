<div class="card">
    <div class="card-header">
        <h3 class="card-title">Pencarian Data Pembayaran</h3>
    </div>
    <div class="card-body">

        <?= form_open('pencarian', ['method' => 'get', 'class' => 'form-row mb-3']) ?>
            <div class="col-md-3 mb-2">
                <input type="text" name="keyword" class="form-control" placeholder="Nama atau NIS santri"
                       value="<?= $filter['keyword'] ?>">
            </div>
            <div class="col-md-2 mb-2">
                <select name="jenis_pembayaran_id" class="form-control">
                    <option value="">-- Jenis Pembayaran --</option>
                    <?php foreach ($jenis_options as $j): ?>
                        <option value="<?= $j->id ?>" <?= $filter['jenis_pembayaran_id'] == $j->id ? 'selected' : '' ?>>
                            <?= $j->nama_pembayaran ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-md-2 mb-2">
                <select name="bulan" class="form-control">
                    <option value="">-- Bulan --</option>
                    <?php foreach (['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'] as $b): ?>
                        <option value="<?= $b ?>" <?= $filter['bulan'] == $b ? 'selected' : '' ?>><?= $b ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-md-1 mb-2">
                <input type="number" name="tahun" class="form-control" placeholder="Tahun" value="<?= $filter['tahun'] ?>">
            </div>
            <div class="col-md-2 mb-2">
                <select name="status" class="form-control">
                    <option value="">-- Status --</option>
                    <option value="lunas" <?= $filter['status'] == 'lunas' ? 'selected' : '' ?>>Lunas</option>
                    <option value="belum_lunas" <?= $filter['status'] == 'belum_lunas' ? 'selected' : '' ?>>Belum Lunas</option>
                </select>
            </div>
            <div class="col-md-2 mb-2">
                <button type="submit" class="btn btn-primary btn-block"><i class="fas fa-search"></i> Cari</button>
            </div>
        <?= form_close() ?>

        <a href="<?= site_url('pencarian') ?>" class="btn btn-link btn-sm mb-2">Reset Filter</a>

        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>No</th>
                    <th>NIS</th>
                    <th>Nama Santri</th>
                    <th>Jenis Pembayaran</th>
                    <th>Periode</th>
                    <th>Nominal</th>
                    <th>Status</th>
                    <th>No. Bukti</th>
                    <th>Tgl Bayar</th>
                </tr>
            </thead>
            <tbody>
                <?php $no = 1; foreach ($hasil as $h): ?>
                <tr>
                    <td><?= $no++ ?></td>
                    <td><?= $h->nis ?></td>
                    <td><?= $h->nama_santri ?></td>
                    <td><?= $h->nama_pembayaran ?></td>
                    <td><?= $h->bulan ?> <?= $h->tahun ?></td>
                    <td>Rp <?= number_format($h->nominal, 0, ',', '.') ?></td>
                    <td>
                        <?php if ($h->status == 'lunas'): ?>
                            <span class="badge badge-success">Lunas</span>
                        <?php else: ?>
                            <span class="badge badge-danger">Belum Lunas</span>
                        <?php endif; ?>
                    </td>
                    <td><?= $h->no_bukti ?: '-' ?></td>
                    <td><?= $h->tanggal_bayar ? date('d-m-Y', strtotime($h->tanggal_bayar)) : '-' ?></td>
                </tr>
                <?php endforeach; ?>
                <?php if (empty($hasil)): ?>
                <tr><td colspan="9" class="text-center text-muted">Tidak ada data yang cocok dengan pencarian</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
        <?php render_pagination($current_page, $total_pages); ?>
        <p class="text-muted text-center small">Menampilkan <?= count($hasil) ?> dari <?= $total_rows ?> total data</p>
    </div>
</div>