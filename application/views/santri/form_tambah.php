<div class="card">
    <div class="card-header">
        <h3 class="card-title">Tambah Santri</h3>
    </div>
    <div class="card-body">

        <?php $this->load->view('templates/alert'); ?>

        <?= form_open('kelola_santri/tambah') ?>
            <div class="form-group">
                <label>NIS</label>
                <input type="text" name="nis" class="form-control" value="<?= set_value('nis') ?>" required>
            </div>
            <div class="form-group">
                <label>Nama Lengkap</label>
                <input type="text" name="nama" class="form-control" value="<?= set_value('nama') ?>" required>
            </div>
            <div class="form-group">
                <label>Kelas</label>
                <select name="kelas_id" class="form-control" required>
                <option value="">-- Pilih Kelas --</option>
                <?php foreach ($kelas_options as $k): ?>
                    <option value="<?= $k->id ?>" <?= (isset($santri) && $santri->kelas_id == $k->id) ? 'selected' : '' ?>>
                        <?= $k->jenjang ?> - <?= $k->nama_kelas ?>
                    </option>
                <?php endforeach; ?>
            </select>
            </div>
            <div class="form-group">
                <label>Jenis Kelamin</label>
                <select name="jenis_kelamin" class="form-control" required>
                    <option value="">-- Pilih --</option>
                    <option value="L">Laki-laki</option>
                    <option value="P">Perempuan</option>
                </select>
            </div>
            <div class="form-group">
                <label>Alamat</label>
                <textarea name="alamat" class="form-control" rows="2"><?= set_value('alamat') ?></textarea>
            </div>
            <div class="form-group">
                <label>Wali Santri</label>
                <input type="text" id="cariWali" class="form-control mb-2" placeholder="Ketik nama wali untuk mencari...">
                <select name="wali_id" id="selectWali" class="form-control" size="6">
                    <option value="">-- Belum ada akun wali --</option>
                    <?php foreach ($wali_options as $w): ?>
                        <option value="<?= $w->id ?>"><?= $w->nama ?> (<?= $w->username ?>)</option>
                    <?php endforeach; ?>
                </select>
            </div>

            <a href="<?= site_url('kelola_santri') ?>" class="btn btn-secondary">Batal</a>
            <button type="submit" class="btn btn-primary">Simpan</button>
        <?= form_close() ?>
    </div>
</div>

<script>
document.getElementById('cariWali').addEventListener('keyup', function() {
    var keyword = this.value.toLowerCase();
    var options = document.querySelectorAll('#selectWali option');
    options.forEach(function(opt) {
        if (opt.value === '') return; // biarkan opsi "-- Belum ada --" selalu tampil
        opt.style.display = opt.textContent.toLowerCase().includes(keyword) ? '' : 'none';
    });
});
</script>