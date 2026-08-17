<div class="card">
    <div class="card-header"><h3 class="card-title">Tambah Pengeluaran</h3></div>
    <div class="card-body">
        <?php $this->load->view('templates/alert'); ?>
        <?= form_open('pengeluaran/tambah') ?>
            <div class="form-group">
                <label>Kategori</label>
                <select name="kategori_id" class="form-control" required>
                    <option value="">-- Pilih Kategori --</option>
                    <?php foreach ($kategori_options as $k): ?>
                        <option value="<?= $k->id ?>"><?= $k->nama_kategori ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <label>Tanggal</label>
                <input type="date" name="tanggal" class="form-control" value="<?= date('Y-m-d') ?>" required>
            </div>
            <div class="form-group">
                <label>Nominal (Rp)</label>
                <input type="number" name="nominal" class="form-control" min="0" required>
            </div>
            <div class="form-group">
                <label>Keterangan</label>
                <textarea name="keterangan" class="form-control" rows="2" placeholder="Contoh: Gaji guru bulan Agustus, belanja dapur minggu ke-3"></textarea>
            </div>
            <a href="<?= site_url('pengeluaran') ?>" class="btn btn-secondary">Batal</a>
            <button type="submit" class="btn btn-primary">Simpan</button>
        <?= form_close() ?>
    </div>
</div>