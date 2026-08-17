<div class="card">
    <div class="card-header"><h3 class="card-title">Edit Kelas</h3></div>
    <div class="card-body">
        <?php $this->load->view('templates/alert'); ?>
        <?= form_open('kelola_kelas/edit/' . $kelas->id) ?>
            <div class="form-group">
                <label>Nama Kelas</label>
                <input type="text" name="nama_kelas" class="form-control" value="<?= $kelas->nama_kelas ?>" required>
            </div>
            <div class="form-group">
                <label>Jenjang</label>
                <select name="jenjang" class="form-control" required>
                    <option value="MTs" <?= $kelas->jenjang == 'MTs' ? 'selected' : '' ?>>MTs</option>
                    <option value="MA" <?= $kelas->jenjang == 'MA' ? 'selected' : '' ?>>MA</option>
                </select>
            </div>
            <a href="<?= site_url('kelola_kelas') ?>" class="btn btn-secondary">Batal</a>
            <button type="submit" class="btn btn-primary">Update</button>
        <?= form_close() ?>
    </div>
</div>