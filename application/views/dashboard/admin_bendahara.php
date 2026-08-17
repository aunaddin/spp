<div class="dashboard-header">
     <img src="<?= base_url('assets/img/logo.png') ?>"
         class="dashboard-logo mr-3"
         alt="Logo">
    <h3>Dashboard Admin Bendahara</h3>
    <p>Selamat datang di Sistem Pembayaran Pondok Pesantren Nurul Ali</p>
</div>

<div class="row">

    <div class="col-lg-3 col-md-6 mb-4">
        <div class="card stat-card bg-success">
            <div class="card-body">
                <i class="fas fa-user-graduate"></i>
                <small>Total Santri Aktif</small>
                <h2><?= number_format($total_santri) ?></h2>
            </div>
        </div>
    </div>

    <div class="col-lg-3 col-md-6 mb-4">
        <div class="card stat-card bg-danger">
            <div class="card-body">
                <i class="fas fa-file-invoice"></i>
                <small>Tagihan Belum Lunas</small>
                <h2><?= number_format($total_belum_lunas) ?></h2>
            </div>
        </div>
    </div>

    <div class="col-lg-3 col-md-6 mb-4">
        <div class="card stat-card bg-info">
            <div class="card-body">
                <i class="fas fa-wallet"></i>
                <small>Pemasukan Bulan Ini</small>
                <h2 style="font-size:22px">
                    Rp <?= number_format($total_pemasukan,0,',','.') ?>
                </h2>
            </div>
        </div>
    </div>

    <div class="col-lg-3 col-md-6 mb-4">
        <div class="card stat-card bg-warning">
            <div class="card-body">
                <i class="fas fa-cash-register"></i>
                <small>Transaksi Hari Ini</small>
                <h2><?= number_format($total_transaksi) ?></h2>
            </div>
        </div>
    </div>

</div>

<div class="row">

    <div class="col-lg-7">

        <div class="card card-modern">

            <div class="card-header">
                <i class="fas fa-chart-column text-success mr-2"></i>
                Grafik Pemasukan 6 Bulan Terakhir
            </div>

            <div class="card-body">

                <canvas id="chartPemasukan" height="180"></canvas>

            </div>

        </div>

    </div>

    <div class="col-lg-5">

        <div class="card card-modern">

            <div class="card-header">

                <i class="fas fa-clock text-danger mr-2"></i>

                Tagihan Terlambat

            </div>

            <div class="card-body p-0">

                <table class="table table-hover mb-0">

                    <tbody>

                    <?php if(empty($tagihan_terlambat)): ?>

                        <tr>

                            <td class="text-center p-4 text-success">

                                <i class="fas fa-check-circle fa-2x mb-2"></i>

                                <br>

                                Tidak ada tagihan terlambat

                            </td>

                        </tr>

                    <?php endif; ?>

                    <?php foreach($tagihan_terlambat as $t): ?>

                    <tr>

                        <td>

                            <strong><?= $t->nama_santri ?></strong>

                            <br>

                            <small class="text-muted">

                                <?= $t->nis ?>

                            </small>

                            <br>

                            <small>

                                <?= $t->nama_pembayaran ?>

                                -

                                <?= $t->bulan ?>

                                <?= $t->tahun ?>

                            </small>

                        </td>

                        <td width="120" class="text-center">

                            <span class="badge badge-danger">

                                <?= floor((strtotime(date('Y-m-d'))-strtotime($t->jatuh_tempo))/86400) ?>

                                Hari

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

const labels = <?= json_encode(array_map(function($g){

$bulan_map=[

'01'=>'Jan',

'02'=>'Feb',

'03'=>'Mar',

'04'=>'Apr',

'05'=>'Mei',

'06'=>'Jun',

'07'=>'Jul',

'08'=>'Agu',

'09'=>'Sep',

'10'=>'Okt',

'11'=>'Nov',

'12'=>'Des'

];

$p=explode('-',$g->bulan);

return $bulan_map[$p[1]].' '.$p[0];

},$grafik_pemasukan));?>;

const data = <?= json_encode(array_map(function($g){

return(float)$g->total;

},$grafik_pemasukan));?>;

new Chart(document.getElementById('chartPemasukan'),{

type:'bar',

data:{

labels:labels,

datasets:[{

data:data,

backgroundColor:'#198754',

borderRadius:8,

borderSkipped:false

}]

},

options:{

responsive:true,

plugins:{

legend:{display:false}

},

scales:{

x:{

grid:{display:false}

},

y:{

beginAtZero:true,

grid:{

color:'#eeeeee'

}

}

}

}

});

</script>