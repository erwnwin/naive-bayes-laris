         <!-- Content Wrapper. Contains page content -->
         <div class="content-wrapper">
             <!-- Content Header (Page header) -->
             <section class="content-header">
                 <div class="container-fluid">
                     <div class="row mb-2">
                         <div class="col-sm-6">
                             <h1>Tahapan Prediksi / Perhitungan</h1>
                         </div>
                     </div>
                 </div><!-- /.container-fluid -->
             </section>

             <!-- Main content -->
             <section class="content">
                 <div class="container-fluid">




                     <div class="row">
                         <div class="col-lg-12 col-12">
                             <div class="card card-successku">
                                 <div class="card-header">
                                     <h3 class="card-title">Hasil Prediksi menggunakan Perhitungan Naive Bayes</span></h3>
                                     <div class="card-tools">
                                         <a href="<?= base_url('riwayat-hasil/export') ?>" class="btn btn-sm btn-primaryku text-white pull-right" target="_blank">Export PDF</a>
                                     </div>
                                 </div>
                                 <div class="card-body p-0">
                                     <div class="table-responsive">
                                         <!-- <form id="form-prediksi"> -->
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
                                                         <td>
                                                             <!-- Tambahkan badge sesuai dengan prediksi -->
                                                             <?php if ($prediction['prediksi'] == 'Laris'): ?>
                                                                 <span class="badge bg-success">Laris</span>
                                                             <?php else: ?>
                                                                 <span class="badge bg-danger">Tidak Laris</span>
                                                             <?php endif; ?>
                                                         </td>
                                                     </tr>
                                                 <?php endforeach; ?>
                                             </tbody>
                                         </table>
                                     </div>
                                 </div>
                             </div>




                             <!-- Hasil Prediksi -->
                             <!-- <div id="result-container" style="display:none;"> -->
                             <div id="result-container" style="display:none;">
                                 <div class="card">
                                     <div class="card-header">
                                         <h3 class="card-title">Hasil Prediksi Naive Bayes</h3>
                                     </div>
                                     <div class="card-body">
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
                                                         <td>
                                                             <!-- Tambahkan badge sesuai dengan prediksi -->
                                                             <?php if ($prediction['prediksi'] == 'Laris'): ?>
                                                                 <span class="badge bg-success">Laris</span>
                                                             <?php else: ?>
                                                                 <span class="badge bg-danger">Tidak Laris</span>
                                                             <?php endif; ?>
                                                         </td>
                                                     </tr>
                                                 <?php endforeach; ?>
                                             </tbody>
                                         </table>

                                     </div>
                                 </div>
                                 <!-- /.card -->
                             </div>


                         </div>


                     </div>

                 </div>

             </section>
             <div>
                 <br>
             </div>
         </div>