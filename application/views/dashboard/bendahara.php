<div class="row">
    <div class="col-lg-3 col-6">
        <div class="small-box bg-info">
            <div class="inner">
                <h3><?= $total_santri ?></h3>
                <p>Total Santri Aktif</p>
            </div>
            <div class="icon"><i class="fas fa-user-graduate"></i></div>
        </div>
    </div>
    <div class="col-lg-3 col-6">
        <div class="small-box bg-danger">
            <div class="inner">
                <h3><?= $total_belum_lunas ?></h3>
                <p>Tagihan Belum Lunas</p>
            </div>
            <div class="icon"><i class="fas fa-file-invoice"></i></div>
        </div>
    </div>
    <div class="col-lg-3 col-6">
        <div class="small-box bg-success">
            <div class="inner">
                <h3>Rp <?= number_format($total_pemasukan, 0, ',', '.') ?></h3>
                <p>Pemasukan Bulan Ini</p>
            </div>
            <div class="icon"><i class="fas fa-money-bill-wave"></i></div>
        </div>
    </div>
    <div class="col-lg-3 col-6">
        <div class="small-box bg-warning">
            <div class="inner">
                <h3><?= $total_transaksi ?></h3>
                <p>Transaksi Hari Ini</p>
            </div>
            <div class="icon"><i class="fas fa-cash-register"></i></div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-7">
        <div class="card">
            <div class="card-header"><h3 class="card-title">Grafik Pemasukan 6 Bulan Terakhir</h3></div>
            <div class="card-body">
                <canvas id="chartPemasukan" style="min-height:250px"></canvas>
            </div>
        </div>
    </div>
    <div class="col-md-5">
        <div class="card">
            <div class="card-header"><h3 class="card-title">Tagihan Terlambat</h3></div>
            <div class="card-body p-0">
                <table class="table table-sm mb-0">
                    <tbody>
                        <?php if (empty($tagihan_terlambat)): ?>
                        <tr><td class="text-center text-muted p-3">Tidak ada tagihan terlambat 🎉</td></tr>
                        <?php endif; ?>
                        <?php foreach ($tagihan_terlambat as $t): ?>
                        <tr>
                            <td>
                                <b><?= $t->nama_santri ?></b> (<?= $t->nis ?>)<br>
                                <small class="text-muted"><?= $t->nama_pembayaran ?> - <?= $t->bulan ?> <?= $t->tahun ?></small>
                            </td>
                            <td class="text-right">
                                <span class="badge badge-danger">
                                    Telat <?= floor((strtotime(date('Y-m-d')) - strtotime($t->jatuh_tempo)) / 86400) ?> hari
                                </span>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
const labels = <?= json_encode(array_map(function($g) {
    $bulan_map = ['01'=>'Jan','02'=>'Feb','03'=>'Mar','04'=>'Apr','05'=>'Mei','06'=>'Jun','07'=>'Jul','08'=>'Agu','09'=>'Sep','10'=>'Okt','11'=>'Nov','12'=>'Des'];
    $parts = explode('-', $g->bulan);
    return $bulan_map[$parts[1]] . ' ' . $parts[0];
}, $grafik_pemasukan)) ?>;

const data = <?= json_encode(array_map(function($g) { return (float) $g->total; }, $grafik_pemasukan)) ?>;

new Chart(document.getElementById('chartPemasukan'), {
    type: 'bar',
    data: {
        labels: labels,
        datasets: [{
            label: 'Pemasukan (Rp)',
            data: data,
            backgroundColor: '#17a2b8'
        }]
    },
    options: {
        scales: { y: { beginAtZero: true } },
        plugins: { legend: { display: false } }
    }
});
</script>