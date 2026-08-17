<div class="card">
    <div class="card-header"><h3 class="card-title">Edit Kategori Pengeluaran</h3></div>
    <div class="card-body">
        <?php $this->load->view('templates/alert'); ?>
        <?= form_open('kategori_pengeluaran/edit/' . $kategori->id) ?>
            <div class="form-group">
                <label>Nama Kategori</label>
                <input type="text" name="nama_kategori" class="form-control"
                       value="<?= set_value('nama_kategori', $kategori->nama_kategori) ?>" required>
            </div>
            <div class="form-group">
                <label>Keterangan</label>
                <textarea name="keterangan" class="form-control" rows="2"><?= set_value('keterangan', $kategori->keterangan) ?></textarea>
            </div>
            <a href="<?= site_url('kategori_pengeluaran') ?>" class="btn btn-secondary">Batal</a>
            <button type="submit" class="btn btn-primary">Update</button>
        <?= form_close() ?>
    </div>
</div>