<h1>Hasil Prediksi Berdasarkan Range Tanggal</h1>
<table border="1">
    <tr>
        <th>Kode Produk</th>
        <th>Nama Brand</th>
        <th>Tanggal</th>
        <th>Prediksi</th>
    </tr>
    <?php foreach ($predictions as $prediction): ?>
        <tr>
            <td><?= $prediction['kode_produk'] ?></td>
            <td><?= $prediction['nama_brand'] ?></td>
            <td><?= $prediction['tanggal'] ?></td>
            <td><?= $prediction['prediction'] ?></td>
        </tr>
    <?php endforeach; ?>
</table>
<a href="<?= site_url('naivebayes') ?>">Kembali</a>