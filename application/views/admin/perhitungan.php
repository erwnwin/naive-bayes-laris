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

                     <div class="alert custom-alert-success alert-dismissible">
                         <h5><i class="icon far fa-question-circle"></i>Mohon Diperhatikan!</h5>
                         Berikut adalah TAHAPAN / ALUR <b>NAIVE BAYES</b><br>
                         <hr>
                         <strong>#Note :</strong> <span class="text-danger">Perhitungan Otomatis dilakukan by Sistem</span>
                     </div>


                     <div class="row">
                         <div class="col-sm-6">
                             <div class="card collapsed-card card-aprioriku">
                                 <div class="card-header text-white">
                                     <h3 class="card-title">Probabilitas Prior P(Laris)</h3>

                                     <div class="card-tools">
                                         <button type="button" class="btn btn-tool text-white" data-card-widget="collapse" title="Collapse">
                                             <i class="fas fa-plus"></i>
                                         </button>
                                     </div>
                                 </div>
                                 <div class="card-body">
                                     <p><strong>Rumus:</strong>
                                         $$ P(\text{Laris}) = \frac{\text{Jumlah Laris}}{\text{Total Data}} $$
                                     </p>
                                     <div class="alert custom-alert-danger alert-dismissible">
                                         <strong>Nilai P(Laris):</strong> <?php echo number_format($stats['prob_Laris'], 8); ?>
                                     </div>
                                 </div>
                             </div>
                         </div>
                         <div class="col-sm-6">
                             <div class="card collapsed-card card-aprioriku">
                                 <div class="card-header text-white">
                                     <h3 class="card-title">Probabilitas Prior P(Tidak Laris)</h3>

                                     <div class="card-tools">
                                         <button type="button" class="btn btn-tool text-white" data-card-widget="collapse" title="Collapse">
                                             <i class="fas fa-plus"></i>
                                         </button>
                                     </div>
                                 </div>
                                 <div class="card-body">
                                     <p><strong>Rumus:</strong>
                                         $$ P(\text{Tidak Laris}) = \frac{\text{Jumlah Tidak Laris}}{\text{Total Data}} $$
                                     </p>
                                     <div class="alert custom-alert-danger alert-dismissible">
                                         <strong>Nilai P(Tidak Laris):</strong> <?php echo number_format($stats['prob_Tidak_Laris'], 8); ?>
                                     </div>
                                 </div>
                             </div>
                         </div>

                         <div class="col-sm-6">
                             <div class="card collapsed-card card-aprioriku">
                                 <div class="card-header text-white">
                                     <h3 class="card-title">Statistik Laris</h3>

                                     <div class="card-tools">
                                         <button type="button" class="btn btn-tool text-white" data-card-widget="collapse" title="Collapse">
                                             <i class="fas fa-plus"></i>
                                         </button>
                                     </div>
                                 </div>
                                 <div class="card-body">
                                     <p><strong>Rumus Mean:</strong>
                                         $$ \text{Mean} = \frac{\Sigma X}{n} $$
                                     </p>
                                     <p><strong>Rumus Standar Deviasi:</strong>
                                         $$ \text{SD} = \sqrt{\frac{\Sigma(X - \text{Mean})^2}{n}} $$
                                     </p>
                                     <div class="alert custom-alert-danger alert-dismissible">
                                         <ul>
                                             <li>
                                                 <strong>Mean Gross (Laris):</strong> <?php echo number_format($stats['mean_gross_laris'], 2); ?>
                                             </li>
                                             <li>
                                                 <strong>Standar Deviasi Gross (Laris):</strong> <?php echo number_format($stats['stddev_gross_laris'], 2); ?>
                                             </li>
                                             <li>
                                                 <strong>Mean Qty (Laris):</strong> <?php echo number_format($stats['mean_qty_laris'], 2); ?>
                                             </li>
                                             <li>
                                                 <strong>Standar Deviasi Qty (Laris):</strong> <?php echo number_format($stats['stddev_qty_laris'], 2); ?>
                                             </li>
                                         </ul>
                                     </div>
                                 </div>
                             </div>
                         </div>





                         <div class="col-sm-6">
                             <div class="card collapsed-card card-aprioriku">
                                 <div class="card-header text-white">
                                     <h3 class="card-title">Statistik Tidak Laris</h3>

                                     <div class="card-tools">
                                         <button type="button" class="btn btn-tool text-white" data-card-widget="collapse" title="Collapse">
                                             <i class="fas fa-plus"></i>
                                         </button>
                                     </div>
                                 </div>
                                 <div class="card-body">
                                     <p><strong>Rumus Mean:</strong>
                                         $$ \text{Mean} = \frac{\Sigma X}{n} $$
                                     </p>
                                     <p><strong>Rumus Standar Deviasi:</strong>
                                         $$ \text{SD} = \sqrt{\frac{\Sigma(X - \text{Mean})^2}{n}} $$
                                     </p>
                                     <div class="alert custom-alert-danger alert-dismissible">
                                         <ul>
                                             <li>
                                                 <strong>Mean Gross (Tidak Laris):</strong> <?php echo number_format($stats['mean_gross_tidak_laris'], 2); ?>
                                             </li>
                                             <li>
                                                 <strong>Standar Deviasi Gross (Tidak Laris):</strong> <?php echo number_format($stats['stddev_gross_tidak_laris'], 2); ?>
                                             </li>
                                             <li>
                                                 <strong>Mean Qty (Tidak Laris):</strong> <?php echo number_format($stats['mean_qty_tidak_laris'], 2); ?>
                                             </li>
                                             <li>
                                                 <strong>Standar Deviasi Qty (Tidak Laris):</strong> <?php echo number_format($stats['stddev_qty_tidak_laris'], 2); ?>
                                             </li>
                                         </ul>
                                     </div>
                                 </div>
                             </div>
                         </div>



                         <div class="col-sm-12">
                             <div class="card collapsed-card card-dangerku">
                                 <div class="card-header text-white">
                                     <h3 class="card-title">Evaluasi Model</h3>

                                     <div class="card-tools">
                                         <button type="button" class="btn btn-tool text-white" data-card-widget="collapse" title="Collapse">
                                             <i class="fas fa-plus"></i>
                                         </button>
                                     </div>
                                 </div>
                                 <div class="card-body">
                                     <table class="table table-bordered">
                                         <thead>
                                             <tr>
                                                 <th>Metode</th>
                                                 <th>Rumus</th>
                                                 <th>Nilai</th>
                                             </tr>
                                         </thead>
                                         <tbody>
                                             <tr>
                                                 <td>True Positive (TP)</td>
                                                 <td>Jumlah data yang benar-benar Laris dan diprediksi Laris</td>
                                                 <td><?= $evaluation['TP']; ?></td>
                                             </tr>
                                             <tr>
                                                 <td>False Positive (FP)</td>
                                                 <td>Jumlah data yang Tidak Laris tetapi diprediksi Laris</td>
                                                 <td><?= $evaluation['FP']; ?></td>
                                             </tr>
                                             <tr>
                                                 <td>True Negative (TN)</td>
                                                 <td>Jumlah data yang benar-benar Tidak Laris dan diprediksi Tidak Laris</td>
                                                 <td><?= $evaluation['TN']; ?></td>
                                             </tr>
                                             <tr>
                                                 <td>False Negative (FN)</td>
                                                 <td>Jumlah data yang Laris tetapi diprediksi Tidak Laris</td>
                                                 <td><?= $evaluation['FN']; ?></td>
                                             </tr>
                                             <tr>
                                                 <td><strong>Accuracy</strong></td>
                                                 <td>\[
                                                     Accuracy = \frac{TP + TN}{TP + FP + TN + FN}
                                                     \]</td>
                                                 <td><?= number_format($evaluation['accuracy'] * 100, 2); ?>%</td>
                                             </tr>
                                             <tr>
                                                 <td><strong>Precision</strong></td>
                                                 <td>\[
                                                     Precision = \frac{TP}{TP + FP}
                                                     \]</td>
                                                 <td><?= number_format($evaluation['precision'] * 100, 2); ?>%</td>
                                             </tr>
                                             <tr>
                                                 <td><strong>Recall</strong></td>
                                                 <td>\[
                                                     Recall = \frac{TP}{TP + FN}
                                                     \]</td>
                                                 <td><?= number_format($evaluation['recall'] * 100, 2); ?>%</td>
                                             </tr>
                                             <tr>
                                                 <td><strong>F1 Score</strong></td>
                                                 <td>\[
                                                     F1 Score = 2 \times \frac{Precision \times Recall}{Precision + Recall}
                                                     \]</td>
                                                 <td><?= number_format($evaluation['f1_score'] * 100, 2); ?>%</td>
                                             </tr>
                                         </tbody>
                                     </table>
                                 </div>
                             </div>
                         </div>
                     </div>

                     <div class="row">
                         <div class="col-lg-12 col-12">
                             <div class="card card-successku">
                                 <div class="card-header">
                                     <h3 class="card-title">Hasil Prediksi menggunakan Perhitungan Naive Bayes</span></h3>
                                     <div class="card-tools">
                                         <a href="<?= base_url('perhitungan/export') ?>" class="btn btn-sm btn-primaryku text-white pull-right" target="_blank">Export PDF</a>
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