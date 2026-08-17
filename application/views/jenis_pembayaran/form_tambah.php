<div class="card">
    <div class="card-header">
        <h3 class="card-title">Tambah Jenis Pembayaran</h3>
    </div>
    <div class="card-body">

    <?php $this->load->view('templates/alert'); ?>

        <?= form_open('jenis_pembayaran/tambah') ?>
            <div class="form-group">
                <label>Nama Pembayaran</label>
                <input type="text" name="nama_pembayaran" class="form-control"
                       placeholder="Contoh: SPP Bulanan, Uang Gedung"
                       value="<?= set_value('nama_pembayaran') ?>" required>
            </div>
            <div class="form-group">
                <label>Nominal (Rp)</label>
                <input type="number" name="nominal" class="form-control" min="0"
                       value="<?= set_value('nominal') ?>" required>
            </div>
            <div class="form-group">
                <label>Keterangan</label>
                <textarea name="keterangan" class="form-control" rows="2"><?= set_value('keterangan') ?></textarea>
            </div>

            <a href="<?= site_url('jenis_pembayaran') ?>" class="btn btn-secondary">Batal</a>
            <button type="submit" class="btn btn-primary">Simpan</button>
        <?= form_close() ?>
    </div>
</div>