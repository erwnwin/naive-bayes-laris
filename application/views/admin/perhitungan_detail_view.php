         <!-- Content Wrapper. Contains page content -->
         <div class="content-wrapper">
             <!-- Content Header (Page header) -->
             <section class="content-header">
                 <div class="container-fluid">
                     <div class="row mb-2">
                         <div class="col-sm-6">
                             <h1>Detail Proses Naive Bayes - <?= $nama_brand ?></h1>
                         </div>
                     </div>
                 </div><!-- /.container-fluid -->
             </section>

             <!-- Main content -->
             <section class="content">
                 <div class="container-fluid">

                     <div class="row">
                         <div class="col-lg-1"></div>
                         <!-- ./col -->

                         <div class="col-lg-10 col-12">


                             <?php if (isset($message)) : ?>
                                 <div class="alert custom-alert-danger alert-dismissible">
                                     <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                     <h5><i class="icon far fa-question-circle"></i>Mohon Diperhatikan!</h5>
                                     <?= $message ?>!
                                 </div>
                             <?php else : ?>
                                 <div class="card card-default">
                                     <div class="card-header">
                                         <h3 class="card-title">Form Prediksi Perhitungan Naive Bayes</span></h3>
                                     </div>
                                     <div class="card-body p-0">
                                         <table class="table ">
                                             <thead>
                                                 <tr>
                                                     <th>Kode Produk</th>
                                                     <th>Nama Brand</th>
                                                     <th>Harga Brand</th>
                                                     <th>Qty</th>
                                                     <th>Total Harga</th>
                                                     <th>Tanggal</th>
                                                 </tr>
                                             </thead>
                                             <tbody>
                                                 <?php foreach ($transactions as $transaction) : ?>
                                                     <tr>
                                                         <td><?= $transaction['kode_produk'] ?></td>
                                                         <td><?= $transaction['nama_brand'] ?></td>
                                                         <td><?= $transaction['harga_brand'] ?></td>
                                                         <td><?= $transaction['qty'] ?></td>
                                                         <td><?= $transaction['total_harga'] ?></td>
                                                         <td><?= $transaction['tanggal'] ?></td>
                                                     </tr>
                                                 <?php endforeach; ?>
                                             </tbody>
                                         </table>
                                     </div>
                                 </div>

                                 <div class="alert custom-alert-danger alert-dismissible">
                                     <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                     <!-- <h5><i class="icon far fa-question-circle"></i>Mohon Diperhatikan!</h5> -->
                                     <h2>Probabilitas Prior</h2>
                                     <p>Prior Laris: <?= $prior['prior_laris'] ?></p>
                                     <p>Prior Tidak Laris: <?= $prior['prior_tidak_laris'] ?></p>

                                     <h2>Probabilitas Likelihood (Laris)</h2>
                                     <ul>
                                         <?php foreach ($likelihood_laris as $feature => $value) : ?>
                                             <li><?= $feature ?>: <?= $value ?></li>
                                         <?php endforeach; ?>
                                     </ul>

                                     <h2>Probabilitas Likelihood (Tidak Laris)</h2>
                                     <ul>
                                         <?php foreach ($likelihood_tidak_laris as $feature => $value) : ?>
                                             <li><?= $feature ?>: <?= $value ?></li>
                                         <?php endforeach; ?>
                                     </ul>
                                 </div>
                             <?php endif; ?>


                             <div class="card collapsed-card card-aprioriku">
                                 <div class="card-header text-white">
                                     <h3 class="card-title">Tahap 1 ~ Menghitung Jumlah Qty Setiap Produk</h3>

                                     <div class="card-tools">
                                         <button type="button" class="btn btn-tool text-white" data-card-widget="collapse" title="Collapse">
                                             <i class="fas fa-plus"></i>
                                         </button>
                                     </div>
                                 </div>
                                 <div class="card-body">
                                 </div>
                             </div>

                             <div class="card collapsed-card card-aprioriku">
                                 <div class="card-header text-white">
                                     <h3 class="card-title">Tahap 1 ~ Menghitung Jumlah Qty Setiap Produk</h3>

                                     <div class="card-tools">
                                         <button type="button" class="btn btn-tool text-white" data-card-widget="collapse" title="Collapse">
                                             <i class="fas fa-plus"></i>
                                         </button>
                                     </div>
                                 </div>
                                 <div class="card-body">
                                 </div>
                             </div>

                             <div class="card collapsed-card card-aprioriku">
                                 <div class="card-header text-white">
                                     <h3 class="card-title">Tahap 1 ~ Menghitung Jumlah Qty Setiap Produk</h3>

                                     <div class="card-tools">
                                         <button type="button" class="btn btn-tool text-white" data-card-widget="collapse" title="Collapse">
                                             <i class="fas fa-plus"></i>
                                         </button>
                                     </div>
                                 </div>
                                 <div class="card-body">
                                 </div>
                             </div>

                             <div class="card collapsed-card card-aprioriku">
                                 <div class="card-header text-white">
                                     <h3 class="card-title">Tahap 1 ~ Menghitung Jumlah Qty Setiap Produk</h3>

                                     <div class="card-tools">
                                         <button type="button" class="btn btn-tool text-white" data-card-widget="collapse" title="Collapse">
                                             <i class="fas fa-plus"></i>
                                         </button>
                                     </div>
                                 </div>
                                 <div class="card-body">
                                 </div>
                             </div>

                             <div class="card collapsed-card card-aprioriku">
                                 <div class="card-header text-white">
                                     <h3 class="card-title">Tahap 1 ~ Menghitung Jumlah Qty Setiap Produk</h3>

                                     <div class="card-tools">
                                         <button type="button" class="btn btn-tool text-white" data-card-widget="collapse" title="Collapse">
                                             <i class="fas fa-plus"></i>
                                         </button>
                                     </div>
                                 </div>
                                 <div class="card-body">
                                 </div>
                             </div>

                         </div>


                         <div class="col-lg-1">
                         </div>
                     </div>


                     <!-- <h1>Detail Proses Naive Bayes - <?= $nama_brand ?></h1> -->



                 </div>

             </section>

             <div>
                 <br>
             </div>

         </div>