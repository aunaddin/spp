<div class="card">
    <div class="card-header">
        <h3 class="card-title">Proses Pembayaran</h3>
    </div>
    <div class="card-body">
        <?php $this->load->view('templates/alert'); ?>
        <table class="table table-borderless w-auto mb-4">
            <tr><td width="180"><b>Nama Santri</b></td><td>: <?= $tagihan->nama_santri ?></td></tr>
            <tr><td><b>NIS</b></td><td>: <?= $tagihan->nis ?></td></tr>
            <tr><td><b>Kelas</b></td><td>: <?= $tagihan->jenjang ?> <?= $tagihan->nama_kelas ?></td></tr>
            <tr><td><b>Jenis Pembayaran</b></td><td>: <?= $tagihan->nama_pembayaran ?></td></tr>
            <tr><td><b>Periode</b></td><td>: <?= $tagihan->bulan ?> <?= $tagihan->tahun ?></td></tr>
            <tr><td><b>Nominal Tagihan</b></td><td>: <b>Rp <?= number_format($tagihan->nominal, 0, ',', '.') ?></b></td></tr>
        </table>

        <?= form_open('transaksi/bayar/' . $tagihan->id) ?>
            <div class="form-group">
                <label>Tanggal Bayar</label>
                <input type="date" name="tanggal_bayar" class="form-control" value="<?= date('Y-m-d') ?>" required>
            </div>
            <div class="form-group">
                <label>Metode Bayar</label>
                <select name="metode_bayar" class="form-control" required>
                    <option value="tunai">Tunai</option>
                    <option value="transfer">Transfer</option>
                </select>
            </div>

            <a href="<?= site_url('transaksi') ?>" class="btn btn-secondary">Batal</a>
            <button type="submit" class="btn btn-primary" onclick="return confirm('Konfirmasi pembayaran ini?')">
                <i class="fas fa-check"></i> Konfirmasi Pembayaran
            </button>
        <?= form_close() ?>
    </div>
</div>