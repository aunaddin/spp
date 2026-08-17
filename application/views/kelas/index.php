<div class="card">
    <div class="card-header">
        <h3 class="card-title">Kelola Kelas</h3>
        <div class="card-tools">
            <a href="<?= site_url('kelola_kelas/tambah') ?>" class="btn btn-primary btn-sm"><i class="fas fa-plus"></i> Tambah Kelas</a>
        </div>
    </div>
    <div class="card-body">
        <?php $this->load->view('templates/alert'); ?>
        <table class="table table-bordered table-striped">
            <thead><tr><th>No</th><th>Nama Kelas</th><th>Jenjang</th><th width="140">Aksi</th></tr></thead>
            <tbody>
                <?php $no = 1; foreach ($kelas as $k): ?>
                <tr>
                    <td><?= $no++ ?></td>
                    <td><?= $k->nama_kelas ?></td>
                    <td><span class="badge badge-<?= $k->jenjang == 'MTs' ? 'info' : 'primary' ?>"><?= $k->jenjang ?></span></td>
                    <td>
                        <a href="<?= site_url('kelola_kelas/edit/' . $k->id) ?>" class="btn btn-warning btn-sm"><i class="fas fa-edit"></i></a>
                        <a href="<?= site_url('kelola_kelas/hapus/' . $k->id) ?>" class="btn btn-danger btn-sm" onclick="return confirm('Hapus kelas ini?')"><i class="fas fa-trash"></i></a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <?php render_pagination($current_page, $total_pages); ?>
        <p class="text-muted text-center small">Menampilkan <?= count($kelas) ?> dari <?= $total_rows ?> total data</p>
    </div>
</div>