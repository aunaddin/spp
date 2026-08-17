<div class="card">
    <div class="card-header">
        <h3 class="card-title">Detail Konfirmasi Pembayaran</h3>
    </div>
    <div class="card-body">

        <?php $this->load->view('templates/alert'); ?>

        <div class="row">
            <div class="col-md-6">
                <table class="table table-borderless">
                    <tr><td width="180"><b>Nama Santri</b></td><td>: <?= $pengajuan->nama_santri ?></td></tr>
                    <tr><td><b>NIS</b></td><td>: <?= $pengajuan->nis ?></td></tr>
                    <tr><td><b>Kelas</b></td><td>: <?= $pengajuan->jenjang ?> <?= $pengajuan->nama_kelas ?></td></tr>
                    <tr><td><b>Jenis Pembayaran</b></td><td>: <?= $pengajuan->nama_pembayaran ?></td></tr>
                    <tr><td><b>Periode</b></td><td>: <?= $pengajuan->bulan ?> <?= $pengajuan->tahun ?></td></tr>
                    <tr><td><b>Nominal Tagihan</b></td><td>: Rp <?= number_format($pengajuan->nominal_tagihan, 0, ',', '.') ?></td></tr>
                    <tr><td><b>Nominal Ditransfer</b></td><td>: <b>Rp <?= number_format($pengajuan->nominal_dibayar, 0, ',', '.') ?></b></td></tr>
                    <tr><td><b>Tanggal Transfer</b></td><td>: <?= date('d-m-Y', strtotime($pengajuan->tanggal_bayar)) ?></td></tr>
                </table>

                <?php if ($pengajuan->nominal_dibayar != $pengajuan->nominal_tagihan): ?>
                <div class="alert alert-warning">
                    <i class="fas fa-exclamation-triangle"></i> Nominal transfer tidak sama dengan nominal tagihan, cek kembali sebelum menyetujui.
                </div>
                <?php endif; ?>
            </div>
            <div class="col-md-6 text-center">
                <label class="d-block"><b>Bukti Transfer</b></label>
                <a href="<?= base_url('uploads/bukti_transfer/' . $pengajuan->bukti_transfer) ?>" target="_blank">
                    <img src="<?= base_url('uploads/bukti_transfer/' . $pengajuan->bukti_transfer) ?>"
                         class="img-fluid img-thumbnail" style="max-height: 400px;">
                </a>
                <small class="text-muted d-block mt-1">Klik gambar untuk memperbesar</small>
            </div>
        </div>

        <hr>

        <div class="row">
            <div class="col-md-6">
                <a href="<?= site_url('transaksi/setujui/' . $pengajuan->id) ?>"
                   class="btn btn-success btn-block"
                   onclick="return confirm('Setujui pembayaran ini? Tagihan akan otomatis menjadi lunas.')">
                    <i class="fas fa-check"></i> Setujui Pembayaran
                </a>
            </div>
            <div class="col-md-6">
                <button type="button" class="btn btn-danger btn-block" data-toggle="modal" data-target="#modalTolak">
                    <i class="fas fa-times"></i> Tolak Pembayaran
                </button>
            </div>
        </div>

        <a href="<?= site_url('transaksi/konfirmasi') ?>" class="btn btn-link mt-3">Kembali ke Daftar</a>
    </div>
</div>

<!-- Modal Alasan Tolak -->
<div class="modal fade" id="modalTolak">
    <div class="modal-dialog">
        <div class="modal-content">
            <?= form_open('transaksi/tolak/' . $pengajuan->id) ?>
            <div class="modal-header">
                <h5 class="modal-title">Tolak Pembayaran</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label>Alasan Penolakan</label>
                    <textarea name="alasan" class="form-control" rows="3" placeholder="Contoh: Bukti transfer tidak jelas, nominal tidak sesuai, dll" required></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-danger">Tolak Pembayaran</button>
            </div>
            <?= form_close() ?>
        </div>
    </div>
</div>