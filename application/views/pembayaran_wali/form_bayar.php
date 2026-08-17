<div class="card">
    <div class="card-header">
        <h3 class="card-title">Upload Bukti Transfer</h3>
    </div>
    <div class="card-body">

        <?php $this->load->view('templates/alert'); ?>

        <table class="table table-borderless w-auto mb-3">
            <tr><td width="180"><b>Nama Santri</b></td><td>: <?= $tagihan->nama_santri ?></td></tr>
            <tr><td><b>Jenis Pembayaran</b></td><td>: <?= $tagihan->nama_pembayaran ?></td></tr>
            <tr><td><b>Periode</b></td><td>: <?= $tagihan->bulan ?> <?= $tagihan->tahun ?></td></tr>
            <tr><td><b>Nominal</b></td><td>: <b>Rp <?= number_format($tagihan->nominal, 0, ',', '.') ?></b></td></tr>
        </table>

        <div class="alert alert-warning">
            Transfer sesuai nominal di atas ke rekening BSI 7123456789 a.n. Yayasan Nurul Ali, lalu upload bukti transfer di bawah ini.
        </div>

        <?= form_open_multipart('pembayaran-wali/bayar/' . $tagihan->id) ?>
            <div class="form-group">
                <label>Tanggal Transfer</label>
                <input type="date" name="tanggal_bayar" class="form-control" value="<?= date('Y-m-d') ?>" required>
            </div>
            <div class="form-group">
                <label>Upload Bukti Transfer (JPG/PNG, maks 2MB)</label>
                <input type="file" name="bukti_transfer" class="form-control-file" accept="image/*" required>
            </div>

            <a href="<?= site_url('pembayaran-wali') ?>" class="btn btn-secondary">Batal</a>
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-paper-plane"></i> Kirim Bukti Transfer
            </button>
        <?= form_close() ?>
    </div>
</div>