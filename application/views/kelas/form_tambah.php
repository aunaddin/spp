<div class="card">
    <div class="card-header"><h3 class="card-title">Tambah Kelas</h3></div>
    <div class="card-body">
        <?php $this->load->view('templates/alert'); ?>
        <?= form_open('kelola_kelas/tambah') ?>
            <div class="form-group">
                <label>Nama Kelas</label>
                <input type="text" name="nama_kelas" class="form-control" placeholder="Contoh: 7, 8A, 10 IPA 1" required>
            </div>
            <div class="form-group">
                <label>Jenjang</label>
                <select name="jenjang" class="form-control" required>
                    <option value="">-- Pilih --</option>
                    <option value="MTs">MTs</option>
                    <option value="MA">MA</option>
                </select>
            </div>
            <a href="<?= site_url('kelola_kelas') ?>" class="btn btn-secondary">Batal</a>
            <button type="submit" class="btn btn-primary">Simpan</button>
        <?= form_close() ?>
    </div>
</div>