<!DOCTYPE html>
<html>
<head>
    <title>Bukti Pembayaran - <?= $pembayaran->no_bukti ?></title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">
    <style>
        @media print {
            .no-print { display: none; }
        }
        body { padding: 30px; }
        .bukti-box { max-width: 500px; margin: 0 auto; border: 1px solid #ccc; padding: 25px; }
    </style>
</head>
<body>
    <div class="bukti-box">
        <div class="text-center mb-3">
            <h4>BUKTI PEMBAYARAN SPP</h4>
            <p class="mb-0">No. Bukti: <b><?= $pembayaran->no_bukti ?></b></p>
        </div>
        <hr>
        <table class="table table-borderless table-sm">
            <tr><td width="150">Nama Santri</td><td>: <?= $pembayaran->nama_santri ?></td></tr>
            <tr><td>NIS</td><td>: <?= $pembayaran->nis ?></td></tr>
            <tr><td>Kelas</td><td>: <?= $pembayaran->jenjang ?> <?= $pembayaran->nama_kelas ?></td></tr>
            <tr><td>Jenis Pembayaran</td><td>: <?= $pembayaran->nama_pembayaran ?></td></tr>
            <tr><td>Periode</td><td>: <?= $pembayaran->bulan ?> <?= $pembayaran->tahun ?></td></tr>
            <tr><td>Tanggal Bayar</td><td>: <?= date('d-m-Y', strtotime($pembayaran->tanggal_bayar)) ?></td></tr>
            <tr><td>Metode Bayar</td><td>: <?= ucfirst($pembayaran->metode_bayar) ?></td></tr>
            <tr><td>Petugas</td><td>: <?= $pembayaran->nama_petugas ?></td></tr>
        </table>
        <hr>
        <h5 class="text-right">Total: Rp <?= number_format($pembayaran->nominal_dibayar, 0, ',', '.') ?></h5>

        <div class="text-center mt-4 no-print">
            <button onclick="window.print()" class="btn btn-primary"><i class="fas fa-print"></i> Cetak</button>
            <a href="<?= site_url('transaksi') ?>" class="btn btn-secondary">Kembali</a>
        </div>
    </div>
</body>
</html>