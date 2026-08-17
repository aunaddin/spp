<div class="card">
    <div class="card-header">
        <h3 class="card-title">Transaksi Pembayaran</h3>
    </div>
    <div class="card-body">

        <?php $this->load->view('templates/alert'); ?>
        <?= form_open('transaksi', ['method' => 'get', 'class' => 'form-inline mb-3']) ?>
            <input type="text" name="keyword" class="form-control mr-2" style="width:300px"
                placeholder="Cari nama santri, NIS, atau jenis pembayaran..." value="<?= $keyword ?>">
            <button type="submit" class="btn btn-secondary">Cari</button>
            <?php if ($keyword): ?>
                <a href="<?= site_url('transaksi') ?>" class="btn btn-link">Reset</a>
            <?php endif; ?>
        <?= form_close() ?>

        <table class="table table-bordered table-striped" id="tabelTagihan">
            <thead>
                <tr>
                    <th>No</th>
                    <th>NIS</th>
                    <th>Nama Santri</th>
                    <th>Jenis Pembayaran</th>
                    <th>Periode</th>
                    <th>Nominal</th>
                    <th>Jatuh Tempo</th>
                    <th width="120">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php $no = 1; foreach ($tagihan_belum_lunas as $t): ?>
                <tr>
                    <td><?= $no++ ?></td>
                    <td><?= $t->nis ?></td>
                    <td><?= $t->nama_santri ?></td>
                    <td><?= $t->nama_pembayaran ?></td>
                    <td><?= $t->bulan ?> <?= $t->tahun ?></td>
                    <td>Rp <?= number_format($t->nominal, 0, ',', '.') ?></td>
                    <td>
                        <?= date('d-m-Y', strtotime($t->jatuh_tempo)) ?>
                        <?php if (strtotime($t->jatuh_tempo) < strtotime(date('Y-m-d'))): ?>
                            <span class="badge badge-danger">Terlambat</span>
                        <?php endif; ?>
                    </td>
                    <td>
                        <a href="<?= site_url('transaksi/bayar/' . $t->id) ?>" class="btn btn-primary btn-sm">
                            <i class="fas fa-cash-register"></i> Bayar
                        </a>
                    </td>
                </tr>
                <?php endforeach; ?>
                <?php if (empty($tagihan_belum_lunas)): ?>
                <tr><td colspan="8" class="text-center text-muted">Tidak ada tagihan yang belum lunas 🎉</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
        <?php render_pagination($current_page, $total_pages); ?>
        <p class="text-muted text-center small">Menampilkan <?= count($tagihan_belum_lunas) ?> dari <?= $total_rows ?> total data</p>
    </div>
</div>