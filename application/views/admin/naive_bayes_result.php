<table>
    <tr>
        <th rowspan="2">No.</th>
        <th rowspan="2">Kode Stok</th>
        <th rowspan="2">Nama Barang</th>
        <th colspan="3">Likelihood</th>
        <th colspan="3">Probabilitas</th>
        <th rowspan="2">Keterangan</th>
    </tr>
    <tr>
        <th>Sangat Laris</th>
        <th>Kurang Laris</th>
        <th>Tidak Laris</th>
        <th>Sangat Laris</th>
        <th>Kurang Laris</th>
        <th>Tidak Laris</th>
    </tr>
    <?php if (!empty($prediksi)): ?>
        <?php $no = 1;
        foreach ($prediksi as $result): ?>
            <tr>
                <td><?= $no++; ?></td>
                <td><?= $result['kode_produk']; ?></td>
                <td><?= $result['nama_brand']; ?></td>
                <td><?= number_format($result['likelihood']['Sangat Laris'], 5); ?></td>
                <td><?= number_format($result['likelihood']['Kurang Laris'], 5); ?></td>
                <td><?= number_format($result['likelihood']['Tidak Laris'], 5); ?></td>
                <td><?= number_format($result['probabilitas']['Sangat Laris'], 2); ?></td>
                <td><?= number_format($result['probabilitas']['Kurang Laris'], 2); ?></td>
                <td><?= number_format($result['probabilitas']['Tidak Laris'], 2); ?></td>
                <td><?= $result['status_popularitas']; ?></td>
            </tr>
        <?php endforeach; ?>
    <?php else: ?>
        <tr>
            <td colspan="10">Tidak ada data prediksi tersedia.</td>
        </tr>
    <?php endif; ?>
</table>