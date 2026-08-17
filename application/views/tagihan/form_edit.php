<div class="card">
    <div class="card-header">
        <h3 class="card-title">Edit Tagihan</h3>
    </div>
    <div class="card-body">

    <?php $this->load->view('templates/alert'); ?>
        <?= form_open('tagihan/edit/' . $tagihan->id) ?>
            <div class="form-group">
                <label>Nominal (Rp)</label>
                <input type="number" name="nominal" class="form-control" min="0"
                       value="<?= set_value('nominal', $tagihan->nominal) ?>" required>
            </div>
            <div class="form-group">
                <label>Jatuh Tempo</label>
                <input type="date" name="jatuh_tempo" class="form-control"
                       value="<?= set_value('jatuh_tempo', $tagihan->jatuh_tempo) ?>" required>
            </div>
            <small class="text-muted d-block mb-3">
                Santri, jenis pembayaran, dan periode tidak bisa diubah di sini — hapus tagihan ini lalu buat ulang kalau perlu ganti.
            </small>

            <a href="<?= site_url('tagihan') ?>" class="btn btn-secondary">Batal</a>
            <button type="submit" class="btn btn-primary">Update</button>
        <?= form_close() ?>
    </div>
</div>