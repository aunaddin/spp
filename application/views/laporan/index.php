<div class="card">
    <div class="card-header">
        <h3 class="card-title">Laporan Pembayaran</h3>
    </div>
    <div class="card-body">

        <?= form_open('laporan', ['method' => 'get', 'class' => 'form-row mb-3']) ?>
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
            <div class="col-md-3 mb-2">
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
                <input type="date" name="tanggal_dari" class="form-control" value="<?= $filter['tanggal_dari'] ?>">
            </div>
            <div class="col-md-2 mb-2">
                <input type="date" name="tanggal_sampai" class="form-control" value="<?= $filter['tanggal_sampai'] ?>">
            </div>
            <div class="col-md-2 mb-2">
                <button type="submit" class="btn btn-primary btn-block"><i class="fas fa-filter"></i> Filter</button>
            </div>
        <?= form_close() ?>

        <div class="d-flex justify-content-between align-items-center mb-3">
            <a href="<?= site_url('laporan') ?>" class="btn btn-link btn-sm">Reset Filter</a>
            <a href="<?= site_url('laporan/cetak') ?>?<?= http_build_query($filter) ?>" target="_blank" class="btn btn-success btn-sm">
                <i class="fas fa-print"></i> Cetak Laporan
            </a>
        </div>

        <div class="alert alert-info">
            <b>Total Pemasukan: Rp <?= number_format($total, 0, ',', '.') ?></b>
            (<?= count($laporan) ?> transaksi)
        </div>

        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>No</th>
                    <th>No. Bukti</th>
                    <th>Nama Santri</th>
                    <th>Jenis Pembayaran</th>
                    <th>Periode</th>
                    <th>Tgl Bayar</th>
                    <th>Nominal</th>
                    <th>Metode</th>
                    <th>Petugas</th>
                </tr>
            </thead>
            <tbody>
                <?php $no = 1; foreach ($laporan as $l): ?>
                <tr>
                    <td><?= $no++ ?></td>
                    <td><?= $l->no_bukti ?></td>
                    <td><?= $l->nama_santri ?> (<?= $l->nis ?>)</td>
                    <td><?= $l->nama_pembayaran ?></td>
                    <td><?= $l->bulan ?> <?= $l->tahun ?></td>
                    <td><?= date('d-m-Y', strtotime($l->tanggal_bayar)) ?></td>
                    <td>Rp <?= number_format($l->nominal_dibayar, 0, ',', '.') ?></td>
                    <td><?= ucfirst($l->metode_bayar) ?></td>
                    <td><?= $l->nama_petugas ?></td>
                </tr>
                <?php endforeach; ?>
                <?php if (empty($laporan)): ?>
                <tr><td colspan="9" class="text-center text-muted">Tidak ada data pada periode ini</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
        <?php render_pagination($current_page, $total_pages); ?>
        <p class="text-muted text-center small">Menampilkan <?= count($laporan) ?> dari <?= $total_rows ?> total data (yang sudah disetujui)</p>
    </div>
</div>