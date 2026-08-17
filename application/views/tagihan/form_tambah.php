<div class="card">
    <div class="card-header">
        <h3 class="card-title">Tambah Tagihan Manual</h3>
    </div>
    <div class="card-body">
        <?php $this->load->view('templates/alert'); ?>
        <?= form_open('tagihan/tambah') ?>
            <div class="form-group">
                <label>Santri</label>
                <input type="text" id="cariSantri" class="form-control mb-2" placeholder="Ketik nama atau NIS untuk mencari...">
                <select name="santri_id" id="selectSantri" class="form-control" size="6" required>
                    <?php foreach ($santri_options as $s): ?>
                        <option value="<?= $s->id ?>"><?= $s->nama ?> - <?= $s->nis ?> (<?= $s->jenjang ?> <?= $s->nama_kelas ?>)</option>
                    <?php endforeach; ?>
                </select>
            </div>
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

            <a href="<?= site_url('tagihan') ?>" class="btn btn-secondary">Batal</a>
            <button type="submit" class="btn btn-primary">Simpan</button>
        <?= form_close() ?>
    </div>
</div>

<script>
document.getElementById('cariSantri').addEventListener('keyup', function() {
    var keyword = this.value.toLowerCase();
    var options = document.querySelectorAll('#selectSantri option');
    options.forEach(function(opt) {
        opt.style.display = opt.textContent.toLowerCase().includes(keyword) ? '' : 'none';
    });
});
</script>