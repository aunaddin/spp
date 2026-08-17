<div class="card">
    <div class="card-header">
        <h3 class="card-title">Kelola Profil Akun</h3>
    </div>
    <div class="card-body">



        <?= form_open('profil') ?>
            <div class="form-group">
                <label>Username</label>
                <input type="text" class="form-control" value="<?= $user->username ?>" disabled>
                <small class="text-muted">Username tidak bisa diubah</small>
            </div>
            <div class="form-group">
                <label>Role</label>
                <input type="text" class="form-control" value="<?= ucfirst($user->role) ?>" disabled>
            </div>
            <div class="form-group">
                <label>Nama Lengkap</label>
                <input type="text" name="nama" class="form-control"
                       value="<?= set_value('nama', $user->nama) ?>" required>
            </div>
            <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" class="form-control"
                       value="<?= set_value('email', $user->email) ?>">
            </div>
            <div class="form-group">
                <label>No. HP</label>
                <input type="text" name="no_hp" class="form-control"
                       value="<?= set_value('no_hp', $user->no_hp) ?>">
            </div>

            <hr>
            <h5>Ganti Password <small class="text-muted">(kosongkan jika tidak ingin diganti)</small></h5>

            <div class="form-group">
                <label>Password Lama</label>
                <input type="password" name="password_lama" class="form-control">
            </div>
            <div class="form-group">
                <label>Password Baru</label>
                <input type="password" name="password_baru" class="form-control">
            </div>
            <div class="form-group">
                <label>Konfirmasi Password Baru</label>
                <input type="password" name="konfirmasi_password" class="form-control">
            </div>

            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
        <?= form_close() ?>
    </div>
</div>