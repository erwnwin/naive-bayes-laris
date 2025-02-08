<!DOCTYPE html>
<html>

<head>
    <title>Laporan Prediksi Paling Laris</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table,
        th,
        td {
            border: 1px solid black;
            padding: 8px;
            text-align: left;
        }

        .text-center {
            text-align: center;
        }

        .footer {
            margin-top: 30px;
            text-align: right;
        }
    </style>
</head>

<body>
    <h2 class="text-center">Laporan Prediksi Barang Paling Laris</h2>

    <!-- Tabel Semua Barang yang Diprediksi Laris -->
    <h3 class="text-center">Daftar Barang Laris Berdasarkan Prediksi Naive Bayes</h3>
    <table>
        <thead>
            <tr>
                <th>Ranking</th>
                <th>Nama Barang</th>
                <th>Gross</th>
                <th>Qty</th>
                <th>Probabilitas Laris</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($laris_predictions)): ?>
                <?php $rank = 1; ?>
                <?php foreach ($laris_predictions as $item): ?>
                    <tr>
                        <td><?= $rank++ ?></td>
                        <td><?= $item['nama'] ?></td>
                        <td><?= "Rp " . number_format($item['gross'], 0, ',', '.') ?></td> <!-- Format Rp -->
                        <td><?= $item['qty'] ?></td>
                        <td><?= number_format($item['prob_laris_given_x'], 5) ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="5" class="text-center">Tidak ada data prediksi laris.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

    <div class="footer">
        <p>Tanggal: <?= date('d-m-Y') ?></p>
    </div>
</body>

</html>