<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Prediksi Barang Laris atau Tidak Laris</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/4.5.2/css/bootstrap.min.css">
</head>

<body>

    <div class="container mt-4">
        <h1 class="mb-4">Prediksi Barang Laris atau Tidak Laris</h1>

        <!-- Statistik Perhitungan Probabilitas Prior -->
        <div class="row">
            <!-- Card for P(Laris) -->
            <div class="col-md-6 mb-3">
                <div class="card">
                    <div class="card-header bg-success text-white">
                        <h5>Probabilitas Prior P(Laris)</h5>
                    </div>
                    <div class="card-body">
                        <p><strong>Rumus:</strong> P(Laris) = Total Laris / Total Data</p>
                        <p><strong>Nilai P(Laris):</strong> <?php echo number_format($stats['prob_Laris'], 8); ?></p>
                    </div>
                </div>
            </div>

            <!-- Card for P(Tidak Laris) -->
            <div class="col-md-6 mb-3">
                <div class="card">
                    <div class="card-header bg-danger text-white">
                        <h5>Probabilitas Prior P(Tidak Laris)</h5>
                    </div>
                    <div class="card-body">
                        <p><strong>Rumus:</strong> P(Tidak Laris) = Total Tidak Laris / Total Data</p>
                        <p><strong>Nilai P(Tidak Laris):</strong> <?php echo number_format($stats['prob_Tidak_Laris'], 8); ?></p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Statistik Perhitungan Mean dan Standard Deviation -->
        <div class="row mt-5">
            <!-- Card for Mean and Std Dev for Laris -->
            <div class="col-md-6 mb-3">
                <div class="card">
                    <div class="card-header bg-info text-white">
                        <h5>Statistik Laris</h5>
                    </div>
                    <div class="card-body">
                        <p><strong>Rumus Mean:</strong> Mean = (ΣX) / n</p>
                        <p><strong>Rumus Standar Deviasi:</strong> SD = √(Σ(X - Mean)² / n)</p>
                        <p><strong>Mean Gross (Laris):</strong> <?php echo number_format($stats['mean_gross_laris'], 2); ?></p>
                        <p><strong>Standar Deviasi Gross (Laris):</strong> <?php echo number_format($stats['stddev_gross_laris'], 2); ?></p>
                        <p><strong>Mean Qty (Laris):</strong> <?php echo number_format($stats['mean_qty_laris'], 2); ?></p>
                        <p><strong>Standar Deviasi Qty (Laris):</strong> <?php echo number_format($stats['stddev_qty_laris'], 2); ?></p>
                    </div>
                </div>
            </div>

            <!-- Card for Mean and Std Dev for Tidak Laris -->
            <div class="col-md-6 mb-3">
                <div class="card">
                    <div class="card-header bg-danger text-white">
                        <h5>Statistik Tidak Laris</h5>
                    </div>
                    <div class="card-body">
                        <p><strong>Rumus Mean:</strong> Mean = (ΣX) / n</p>
                        <p><strong>Rumus Standar Deviasi:</strong> SD = √(Σ(X - Mean)² / n)</p>
                        <p><strong>Mean Gross (Tidak Laris):</strong> <?php echo number_format($stats['mean_gross_tidak_laris'], 2); ?></p>
                        <p><strong>Standar Deviasi Gross (Tidak Laris):</strong> <?php echo number_format($stats['stddev_gross_tidak_laris'], 2); ?></p>
                        <p><strong>Mean Qty (Tidak Laris):</strong> <?php echo number_format($stats['mean_qty_tidak_laris'], 2); ?></p>
                        <p><strong>Standar Deviasi Qty (Tidak Laris):</strong> <?php echo number_format($stats['stddev_qty_tidak_laris'], 2); ?></p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tabel Prediksi Barang -->
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Nama Barang</th>
                    <th>Gross</th>
                    <th>Qty</th>
                    <th>P(Laris | X)</th>
                    <th>P(Tidak Laris | X)</th>
                    <th>Prediksi</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($predictions as $prediction): ?>
                    <tr>
                        <td><?php echo $prediction['nama']; ?></td>
                        <td><?php echo $prediction['gross']; ?></td>
                        <td><?php echo $prediction['qty']; ?></td>
                        <td><?php echo number_format($prediction['prob_laris_given_x'], 8); ?></td>
                        <td><?php echo number_format($prediction['prob_tidak_laris_given_x'], 8); ?></td>
                        <td><?php echo $prediction['prediksi']; ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

    </div>

</body>

</html>