<div class="card">
    <div class="card-header">
        <h3 class="card-title">Generate Tagihan Massal</h3>
    </div>
    <div class="card-body">

        <?php $this->load->view('templates/alert'); ?>
        <div class="alert alert-info">
            Ini akan membuat tagihan untuk <b>semua santri berstatus aktif</b> sekaligus. Santri yang sudah punya tagihan pada jenis pembayaran & periode yang sama akan otomatis dilewati (tidak dobel).
        </div>

        <?= form_open('tagihan/generate') ?>
            <div class="form-group">
                <label>Jenis Pembayaran</label>
                <select name="jenis_pembayaran_id" class="form-control" required>
                    <option value="">-- Pilih --</option>
                    <?php foreach ($jenis_options as $j): ?>
                        <option value="<?= $j->id ?>">
                            <?= $j->nama_pembayaran ?> (Rp <?= number_format($j->nominal, 0, ',', '.') ?>)
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <label>Bulan</label>
                <select name="bulan" class="form-control" required>
                    <option value="">-- Pilih Bulan --</option>
                    <?php foreach (['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'] as $b): ?>
                        <option value="<?= $b ?>"><?= $b ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <label>Tahun</label>
                <input type="number" name="tahun" class="form-control" value="<?= date('Y') ?>" required>
            </div>
            <div class="form-group">
                <label>Jatuh Tempo</label>
                <input type="date" name="jatuh_tempo" class="form-control" required>
            </div>
            <div class="form-group">
                <label>Tagihkan ke Kelas</label>
                <div class="mb-2">
                    <button type="button" class="btn btn-sm btn-outline-info" onclick="pilihJenjang('MTs')">Pilih Semua MTs</button>
                    <button type="button" class="btn btn-sm btn-outline-primary" onclick="pilihJenjang('MA')">Pilih Semua MA</button>
                    <button type="button" class="btn btn-sm btn-outline-secondary" onclick="document.querySelectorAll('.chk-kelas').forEach(c => c.checked = false)">Kosongkan</button>
                </div>
                <div class="border rounded p-2" style="max-height: 200px; overflow-y: auto;">
                    <?php $jenjang_sebelumnya = null; foreach ($kelas_options as $k): ?>
                        <?php if ($jenjang_sebelumnya !== $k->jenjang): ?>
                            <?php if ($jenjang_sebelumnya !== null) echo '<hr class="my-1">'; ?>
                            <b class="text-muted"><?= $k->jenjang ?></b><br>
                            <?php $jenjang_sebelumnya = $k->jenjang; ?>
                        <?php endif; ?>
                        <div class="form-check form-check-inline">
                            <input type="checkbox" name="kelas_id[]" value="<?= $k->id ?>" class="form-check-input chk-kelas" data-jenjang="<?= $k->jenjang ?>" id="kelas<?= $k->id ?>">
                            <label class="form-check-label" for="kelas<?= $k->id ?>"><?= $k->nama_kelas ?></label>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <a href="<?= site_url('tagihan') ?>" class="btn btn-secondary">Batal</a>
            <button type="submit" class="btn btn-success">
                <i class="fas fa-magic"></i> Generate Sekarang
            </button>
        <?= form_close() ?>
    </div>
</div>


<script>
function pilihJenjang(jenjang) {
    document.querySelectorAll('.chk-kelas').forEach(function(c) {
        c.checked = (c.dataset.jenjang === jenjang);
    });
}
</script>