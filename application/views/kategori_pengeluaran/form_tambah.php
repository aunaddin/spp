<div class="card">
    <div class="card-header"><h3 class="card-title">Tambah Kategori Pengeluaran</h3></div>
    <div class="card-body">
        <?php $this->load->view('templates/alert'); ?>
        <?= form_open('kategori_pengeluaran/tambah') ?>
            <div class="form-group">
                <label>Nama Kategori</label>
                <input type="text" name="nama_kategori" class="form-control"
                       placeholder="Contoh: Uang Belanja Pondok, Gaji Guru MTs"
                       value="<?= set_value('nama_kategori') ?>" required>
            </div>
            <div class="form-group">
                <label>Keterangan</label>
                <textarea name="keterangan" class="form-control" rows="2"><?= set_value('keterangan') ?></textarea>
            </div>
            <a href="<?= site_url('kategori_pengeluaran') ?>" class="btn btn-secondary">Batal</a>
            <button type="submit" class="btn btn-primary">Simpan</button>
        <?= form_close() ?>
    </div>
</div>