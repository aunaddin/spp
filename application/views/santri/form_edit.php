<div class="card">
    <div class="card-header">
        <h3 class="card-title">Edit Santri</h3>
    </div>
    <div class="card-body">

        <?php $this->load->view('templates/alert'); ?>

        <?= form_open('kelola_santri/edit/' . $santri->id) ?>
            <div class="form-group">
                <label>NIS</label>
                <input type="text" class="form-control" value="<?= $santri->nis ?>" disabled>
                <small class="text-muted">NIS tidak bisa diubah</small>
            </div>
            <div class="form-group">
                <label>Nama Lengkap</label>
                <input type="text" name="nama" class="form-control" value="<?= set_value('nama', $santri->nama) ?>" required>
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
                    <option value="L" <?= $santri->jenis_kelamin == 'L' ? 'selected' : '' ?>>Laki-laki</option>
                    <option value="P" <?= $santri->jenis_kelamin == 'P' ? 'selected' : '' ?>>Perempuan</option>
                </select>
            </div>
            <div class="form-group">
                <label>Alamat</label>
                <textarea name="alamat" class="form-control" rows="2"><?= set_value('alamat', $santri->alamat) ?></textarea>
            </div>
            <div class="form-group">
                <label>Wali Santri</label>
                <input type="text" id="cariWali" class="form-control mb-2" placeholder="Ketik nama wali untuk mencari...">
                <select name="wali_id" id="selectWali" class="form-control" size="6">
                    <option value="">-- Belum ada akun wali --</option>
                    <?php foreach ($wali_options as $w): ?>
                        <option value="<?= $w->id ?>" <?= $santri->wali_id == $w->id ? 'selected' : '' ?>>
                            <?= $w->nama ?> (<?= $w->username ?>)
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <a href="<?= site_url('kelola_santri') ?>" class="btn btn-secondary">Batal</a>
            <button type="submit" class="btn btn-primary">Update</button>
        <?= form_close() ?>
    </div>
</div>

<script>
document.getElementById('cariWali').addEventListener('keyup', function() {
    var keyword = this.value.toLowerCase();
    var options = document.querySelectorAll('#selectWali option');
    options.forEach(function(opt) {
        if (opt.value === '') return;
        opt.style.display = opt.textContent.toLowerCase().includes(keyword) ? '' : 'none';
    });
});
</script>