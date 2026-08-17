<div class="card">
    <div class="card-header">
        <h3 class="card-title">Edit Pengguna</h3>
    </div>
    <div class="card-body">

        <?php $this->load->view('templates/alert'); ?>

        <?= form_open('kelola_pengguna/edit/' . $user->id) ?>
            <div class="form-group">
                <label>Username</label>
                <input type="text" class="form-control" value="<?= $user->username ?>" disabled>
                <small class="text-muted">Username tidak bisa diubah</small>
            </div>
            <div class="form-group">
                <label>Nama Lengkap</label>
                <input type="text" name="nama" class="form-control" value="<?= set_value('nama', $user->nama) ?>" required>
            </div>
            <div class="form-group">
                <label>Password Baru</label>
                <input type="password" name="password" class="form-control" placeholder="Kosongkan jika tidak diganti">
            </div>
            <div class="form-group">
                <label>Role</label>
                <select name="role" class="form-control" required>
                    <option value="admin" <?= $user->role == 'admin' ? 'selected' : '' ?>>Admin</option>
                    <option value="bendahara" <?= $user->role == 'bendahara' ? 'selected' : '' ?>>Bendahara</option>
                    <option value="wali_santri" <?= $user->role == 'wali_santri' ? 'selected' : '' ?>>Wali Santri</option>
                </select>
            </div>
            <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" class="form-control" value="<?= set_value('email', $user->email) ?>">
            </div>
            <div class="form-group">
                <label>No. HP</label>
                <input type="text" name="no_hp" class="form-control" value="<?= set_value('no_hp', $user->no_hp) ?>">
            </div>

            <a href="<?= site_url('kelola_pengguna') ?>" class="btn btn-secondary">Batal</a>
            <button type="submit" class="btn btn-primary">Update</button>
        <?= form_close() ?>
    </div>
</div>