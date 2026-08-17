<!DOCTYPE html>
<html>
<head>
    <title>Laporan Pembayaran SPP</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">
    <style>
        @media print { .no-print { display: none; } }
        body { padding: 20px; }
    </style>
</head>
<body>
    <div class="text-center mb-4">
        <h4>LAPORAN PEMBAYARAN SPP</h4>
        <p class="mb-0">
            Periode:
            <?= $filter['bulan'] ?: 'Semua Bulan' ?> <?= $filter['tahun'] ?: '' ?>
            <?php if ($filter['tanggal_dari'] || $filter['tanggal_sampai']): ?>
                (<?= $filter['tanggal_dari'] ?: '...' ?> s/d <?= $filter['tanggal_sampai'] ?: '...' ?>)
            <?php endif; ?>
        </p>
    </div>

    <table class="table table-bordered table-sm">
        <thead>
            <tr>
                <th>No</th>
                <th>No. Bukti</th>
                <th>Nama Santri</th>
                <th>Jenis Pembayaran</th>
                <th>Periode</th>
                <th>Tgl Bayar</th>
                <th>Nominal</th>
                <th>Metode</th>
            </tr>
        </thead>
        <tbody>
            <?php $no = 1; foreach ($laporan as $l): ?>
            <tr>
                <td><?= $no++ ?></td>
                <td><?= $l->no_bukti ?></td>
                <td><?= $l->nama_santri ?> (<?= $l->nis ?>)</td>
                <td><?= $l->nama_pembayaran ?></td>
                <td><?= $l->bulan ?> <?= $l->tahun ?></td>
                <td><?= date('d-m-Y', strtotime($l->tanggal_bayar)) ?></td>
                <td>Rp <?= number_format($l->nominal_dibayar, 0, ',', '.') ?></td>
                <td><?= ucfirst($l->metode_bayar) ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
        <tfoot>
            <tr>
                <th colspan="6" class="text-right">Total Pemasukan</th>
                <th colspan="2">Rp <?= number_format($total, 0, ',', '.') ?></th>
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