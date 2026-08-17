<div class="card">
    <div class="card-header"><h3 class="card-title">Edit Pengeluaran</h3></div>
    <div class="card-body">
        <?php $this->load->view('templates/alert'); ?>
        <?= form_open('pengeluaran/edit/' . $pengeluaran->id) ?>
            <div class="form-group">
                <label>Kategori</label>
                <select name="kategori_id" class="form-control" required>
                    <?php foreach ($kategori_options as $k): ?>
                        <option value="<?= $k->id ?>" <?= $pengeluaran->kategori_id == $k->id ? 'selected' : '' ?>>
                            <?= $k->nama_kategori ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <label>Tanggal</label>
                <input type="date" name="tanggal" class="form-control" value="<?= $pengeluaran->tanggal ?>" required>
            </div>
            <div class="form-group">
                <label>Nominal (Rp)</label>
                <input type="number" name="nominal" class="form-control" min="0"
                       value="<?= $pengeluaran->nominal ?>" required>
            </div>
            <div class="form-group">
                <label>Keterangan</label>
                <textarea name="keterangan" class="form-control" rows="2"><?= $pengeluaran->keterangan ?></textarea>
            </div>
            <a href="<?= site_url('pengeluaran') ?>" class="btn btn-secondary">Batal</a>
            <button type="submit" class="btn btn-primary">Update</button>
        <?= form_close() ?>
    </div>
</div>