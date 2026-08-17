<div class="card">
    <div class="card-header">
        <h3 class="card-title">Tambah Pengguna</h3>
    </div>
    <div class="card-body">

        <?php $this->load->view('templates/alert'); ?>

        <?= form_open('kelola_pengguna/tambah') ?>
            <div class="form-group">
                <label>Username</label>
                <input type="text" name="username" class="form-control" value="<?= set_value('username') ?>" required>
            </div>
            <div class="form-group">
                <label>Nama Lengkap</label>
                <input type="text" name="nama" class="form-control" value="<?= set_value('nama') ?>" required>
            </div>
            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" class="form-control" required>
            </div>
            <div class="form-group">
                <label>Role</label>
                <select name="role" class="form-control" required>
                    <option value="">-- Pilih Role --</option>
                    <option value="admin" <?= set_select('role', 'admin') ?>>Admin</option>
                    <option value="bendahara" <?= set_select('role', 'bendahara') ?>>Bendahara</option>
                    <option value="wali_santri" <?= set_select('role', 'wali_santri') ?>>Wali Santri</option>
                </select>
            </div>
            <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" class="form-control" value="<?= set_value('email') ?>">
            </div>
            <div class="form-group">
                <label>No. HP</label>
                <input type="text" name="no_hp" class="form-control" value="<?= set_value('no_hp') ?>">
            </div>

            <a href="<?= site_url('kelola_pengguna') ?>" class="btn btn-secondary">Batal</a>
            <button type="submit" class="btn btn-primary">Simpan</button>
        <?= form_close() ?>
    </div>
</div>