<div class="card">
    <div class="card-header">
        <h3 class="card-title">Edit Jenis Pembayaran</h3>
    </div>
    <div class="card-body">

    <?php $this->load->view('templates/alert'); ?>

        <?= form_open('jenis_pembayaran/edit/' . $jenis->id) ?>
            <div class="form-group">
                <label>Nama Pembayaran</label>
                <input type="text" name="nama_pembayaran" class="form-control"
                       value="<?= set_value('nama_pembayaran', $jenis->nama_pembayaran) ?>" required>
            </div>
            <div class="form-group">
                <label>Nominal (Rp)</label>
                <input type="number" name="nominal" class="form-control" min="0"
                       value="<?= set_value('nominal', $jenis->nominal) ?>" required>
            </div>
            <div class="form-group">
                <label>Keterangan</label>
                <textarea name="keterangan" class="form-control" rows="2"><?= set_value('keterangan', $jenis->keterangan) ?></textarea>
            </div>

            <a href="<?= site_url('jenis_pembayaran') ?>" class="btn btn-secondary">Batal</a>
            <button type="submit" class="btn btn-primary">Update</button>
        <?= form_close() ?>
    </div>
</div>