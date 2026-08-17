<div class="card">
    <div class="card-header">
        <h3 class="card-title">Laporan Keuangan Bulanan (Uang Masuk & Keluar)</h3>
    </div>
    <div class="card-body">

        <?php $this->load->view('templates/alert'); ?>

        <?= form_open('laporan_keuangan', ['method' => 'get', 'class' => 'form-row mb-3']) ?>
            <div class="col-md-3 mb-2">
                <select name="bulan" class="form-control">
                    <?php for ($i = 1; $i <= 12; $i++): ?>
                        <option value="<?= $i ?>" <?= $bulan == $i ? 'selected' : '' ?>>
                            <?= date('F', mktime(0,0,0,$i,1)) ?>
                        </option>
                    <?php endfor; ?>
                </select>
            </div>
            <div class="col-md-2 mb-2">
                <input type="number" name="tahun" class="form-control" value="<?= $tahun ?>">
            </div>
            <div class="col-md-2 mb-2">
                <button type="submit" class="btn btn-primary btn-block">Tampilkan</button>
            </div>
            <div class="col-md-3 mb-2">
                <a href="<?= site_url('laporan_keuangan/cetak') ?>?bulan=<?= $bulan ?>&tahun=<?= $tahun ?>"
                   target="_blank" class="btn btn-success btn-block">
                    <i class="fas fa-print"></i> Cetak Laporan
                </a>
            </div>
        <?= form_close() ?>

        <div class="row">
            <div class="col-md-4">
                <div class="small-box bg-success">
                    <div class="inner">
                        <h4>Rp <?= number_format($total_masuk, 0, ',', '.') ?></h4>
                        <p>Total Uang Masuk (SPP)</p>
                    </div>
                    <div class="icon"><i class="fas fa-arrow-down"></i></div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="small-box bg-danger">
                    <div class="inner">
                        <h4>Rp <?= number_format($total_keluar, 0, ',', '.') ?></h4>
                        <p>Total Uang Keluar</p>
                    </div>
                    <div class="icon"><i class="fas fa-arrow-up"></i></div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="small-box <?= $saldo >= 0 ? 'bg-info' : 'bg-warning' ?>">
                    <div class="inner">
                        <h4>Rp <?= number_format($saldo, 0, ',', '.') ?></h4>
                        <p>Saldo (Masuk - Keluar)</p>
                    </div>
                    <div class="icon"><i class="fas fa-wallet"></i></div>
                </div>
            </div>
        </div>

        <h5 class="mt-3">Rincian Pengeluaran per Kategori</h5>
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>Kategori</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($rekap_pengeluaran as $r): ?>
                <tr>
                    <td><?= $r->nama_kategori ?></td>
                    <td>Rp <?= number_format($r->total, 0, ',', '.') ?></td>
                </tr>
                <?php endforeach; ?>
                <?php if (empty($rekap_pengeluaran)): ?>
                <tr><td colspan="2" class="text-center text-muted">Tidak ada pengeluaran pada periode ini</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>