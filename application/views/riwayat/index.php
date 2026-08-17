<div class="card">
    <div class="card-header">
        <h3 class="card-title">Riwayat Pembayaran</h3>
    </div>
    <div class="card-body">

        <div class="form-group">
            <input type="text" id="searchTable" class="form-control" placeholder="Cari nama santri, no bukti, atau jenis pembayaran...">
        </div>

        <table class="table table-bordered table-striped" id="tabelRiwayat">
            <thead>
                <tr>
                    <th>No</th>
                    <th>No. Bukti</th>
                    <th>Nama Santri</th>
                    <th>Jenis Pembayaran</th>
                    <th>Periode</th>
                    <th>Tanggal Bayar</th>
                    <th>Nominal</th>
                    <th>Metode</th>
                    <th>Status</th>  <!-- TAMBAHAN -->
                    <?php if ($role != 'wali_santri'): ?>
                    <th>Petugas</th>
                    <?php endif; ?>
                    <th width="80">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php $no = 1; foreach ($riwayat as $r): ?>
                <tr>
                    <td><?= $no++ ?></td>
                    <td><?= $r->no_bukti ?></td>
                    <td><?= $r->nama_santri ?> (<?= $r->nis ?>)</td>
                    <td><?= $r->nama_pembayaran ?></td>
                    <td><?= $r->bulan ?> <?= $r->tahun ?></td>
                    <td><?= date('d-m-Y', strtotime($r->tanggal_bayar)) ?></td>
                    <td>Rp <?= number_format($r->nominal_dibayar, 0, ',', '.') ?></td>
                    <td><span class="badge badge-info"><?= ucfirst($r->metode_bayar) ?></span></td>
                    <td>  <!-- TAMBAHAN -->
                        <?php if ($r->status == 'disetujui'): ?>
                            <span class="badge badge-success">Disetujui</span>
                        <?php elseif ($r->status == 'menunggu'): ?>
                            <span class="badge badge-warning">Diproses</span>
                        <?php else: ?>
                            <span class="badge badge-danger" title="<?= $r->catatan_admin ?>">Ditolak</span>
                            <p></p>
                            <button type="button" class="btn btn-outline-danger btn-sm btn-lihat-alasan"
                                    data-alasan="<?= htmlspecialchars($r->catatan_admin) ?>"
                                    data-nobukti="<?= $r->no_bukti ?>"
                                    data-toggle="modal" data-target="#modalAlasan">
                                <i class="fas fa-info-circle"></i> Lihat Alasan
                            </button>
                        <?php endif; ?>
                    </td>
                    <?php if ($role != 'wali_santri'): ?>
                    <td><?= $r->nama_petugas ?></td>
                    <?php endif; ?>
                    <td>
                        <?php if ($r->status == 'disetujui'): ?>
                            <a href="<?= site_url('transaksi/bukti/' . $r->id) ?>" target="_blank" class="btn btn-info btn-sm">
                                <i class="fas fa-print"></i>
                            </a>
                        <?php else: ?>
                            <span class="text-muted" title="Bukti hanya tersedia untuk pembayaran yang sudah disetujui">-</span>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php endforeach; ?>
                <?php if (empty($riwayat)): ?>
                <tr><td colspan="10" class="text-center text-muted">Belum ada riwayat pembayaran</td></tr>  <!-- colspan naik dari 9 ke 10 -->
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Modal Lihat Alasan Penolakan -->
<div class="modal fade" id="modalAlasan">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Alasan Penolakan</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <p class="text-muted mb-1">No. Bukti: <span id="alasanNoBukti"></span></p>
                <div class="alert alert-danger" id="alasanTeks"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

<script>
document.querySelectorAll('.btn-lihat-alasan').forEach(function(btn) {
    btn.addEventListener('click', function() {
        document.getElementById('alasanNoBukti').textContent = this.dataset.nobukti;
        document.getElementById('alasanTeks').textContent = this.dataset.alasan;
    });
});
</script>
<script>
document.getElementById('searchTable').addEventListener('keyup', function() {
    var keyword = this.value.toLowerCase();
    var rows = document.querySelectorAll('#tabelRiwayat tbody tr');
    rows.forEach(function(row) {
        row.style.display = row.textContent.toLowerCase().includes(keyword) ? '' : 'none';
    });
});
</script>