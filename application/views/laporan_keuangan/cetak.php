<!DOCTYPE html>
<html>
<head>
    <title>Laporan Keuangan - <?= date('F Y', mktime(0,0,0,$bulan,1,$tahun)) ?></title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">
    <style>
        @media print { .no-print { display: none; } }
        body { padding: 20px; }
    </style>
</head>
<body>
    <div class="text-center mb-4">
        <h4>LAPORAN KEUANGAN</h4>
        <p>Periode: <?= date('F Y', mktime(0,0,0,$bulan,1,$tahun)) ?></p>
    </div>

    <table class="table table-bordered">
        <tr>
            <td width="250">Total Uang Masuk (SPP)</td>
            <td>Rp <?= number_format($total_masuk, 0, ',', '.') ?></td>
        </tr>
        <tr>
            <td>Total Uang Keluar</td>
            <td>Rp <?= number_format($total_keluar, 0, ',', '.') ?></td>
        </tr>
        <tr class="<?= $saldo >= 0 ? 'table-success' : 'table-danger' ?>">
            <td><b>Saldo</b></td>
            <td><b>Rp <?= number_format($saldo, 0, ',', '.') ?></b></td>
        </tr>
    </table>

    <h5 class="mt-4">Rincian Pengeluaran</h5>
    <table class="table table-bordered table-sm">
        <thead>
            <tr>
                <th>No</th>
                <th>Tanggal</th>
                <th>Kategori</th>
                <th>Keterangan</th>
                <th>Nominal</th>
            </tr>
        </thead>
        <tbody>
            <?php $no = 1; foreach ($detail_pengeluaran as $d): ?>
            <tr>
                <td><?= $no++ ?></td>
                <td><?= date('d-m-Y', strtotime($d->tanggal)) ?></td>
                <td><?= $d->nama_kategori ?></td>
                <td><?= $d->keterangan ?: '-' ?></td>
                <td>Rp <?= number_format($d->nominal, 0, ',', '.') ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
        <tfoot>
            <tr>
                <th colspan="4" class="text-right">Total Pengeluaran</th>
                <th>Rp <?= number_format($total_keluar, 0, ',', '.') ?></th>
            </tr>
        </tfoot>
    </table>

    <div class="row mt-5">
        <div class="col-6"></div>
        <div class="col-6 text-center">
            <p>Magelang, <?= date('d-m-Y') ?></p>
            <p class="mt-5">Bendahara</p>
            <p class="mt-5">( _________________________ )</p>
        </div>
    </div>

    <div class="text-center mt-4 no-print">
        <button onclick="window.print()" class="btn btn-primary"><i class="fas fa-print"></i> Cetak</button>
    </div>
</body>
</html>