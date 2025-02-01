         <!-- Content Wrapper. Contains page content -->
         <div class="content-wrapper">
             <!-- Content Header (Page header) -->
             <section class="content-header">
                 <div class="container-fluid">
                     <div class="row mb-2">
                         <div class="col-sm-6">
                             <h1>Prediksi Minat</h1>
                         </div>
                     </div>
                 </div><!-- /.container-fluid -->
             </section>

             <!-- Main content -->
             <section class="content">
                 <div class="container-fluid">

                     <div class="container mt-5">
                         <h2 class="text-center">Prediksi Popularitas Barang</h2>
                         <form method="post" action="<?= base_url('perhitungan/prediksi'); ?>">
                             <div class="mb-3">
                                 <label for="start_date" class="form-label">Tanggal Mulai</label>
                                 <input type="date" class="form-control" id="start_date" name="start_date" required>
                             </div>
                             <div class="mb-3">
                                 <label for="end_date" class="form-label">Tanggal Akhir</label>
                                 <input type="date" class="form-control" id="end_date" name="end_date" required>
                             </div>
                             <button type="submit" class="btn btn-primary">Tampilkan Prediksi</button>
                         </form>

                         <?php if (!empty($predictions)): ?>
                             <div class="mt-5">
                                 <h4>Hasil Prediksi Popularitas</h4>
                                 <table class="table table-bordered">
                                     <thead class="table-dark">
                                         <tr>
                                             <th>Nama Brand</th>
                                             <th>Prior (Laris)</th>
                                             <th>Prior (Tidak Laris)</th>
                                             <th>Likelihood (Laris)</th>
                                             <th>Likelihood (Tidak Laris)</th>
                                             <th>Prediksi Popularitas</th>
                                         </tr>
                                     </thead>
                                     <tbody>
                                         <?php foreach ($predictions as $prediction): ?>
                                             <tr>
                                                 <td><?= $prediction['nama_brand']; ?></td>
                                                 <td><?= number_format($prediction['prior']['Laris'], 4); ?></td>
                                                 <td><?= number_format($prediction['prior']['Tidak Laris'], 4); ?></td>
                                                 <td><?= number_format($prediction['likelihood']['Laris'], 4); ?></td>
                                                 <td><?= number_format($prediction['likelihood']['Tidak Laris'], 4); ?></td>
                                                 <td>
                                                     <span class="badge <?= $prediction['prior']['Laris'] > $prediction['prior']['Tidak Laris'] ? 'bg-success' : 'bg-danger'; ?>">
                                                         <?= $prediction['prior']['Laris'] > $prediction['prior']['Tidak Laris'] ? 'Laris' : 'Tidak Laris'; ?>
                                                     </span>
                                                 </td>
                                             </tr>
                                         <?php endforeach; ?>
                                     </tbody>
                                 </table>
                             </div>
                         <?php endif; ?>
                     </div>
                 </div>

             </section>
             <div>
                 <br>
             </div>
         </div>