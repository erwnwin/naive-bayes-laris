         <!-- Content Wrapper. Contains page content -->
         <div class="content-wrapper">
             <!-- Content Header (Page header) -->
             <section class="content-header">
                 <div class="container-fluid">
                     <div class="row mb-2">
                         <div class="col-sm-6">
                             <h1>Buat Prediksi / Perhitungan</h1>
                         </div>
                     </div>
                 </div><!-- /.container-fluid -->
             </section>

             <!-- Main content -->
             <section class="content">
                 <div class="container-fluid">


                     <div class="container mt-5">
                         <h1 class="text-center">Detail Proses Naive Bayes</h1>
                         <h2>Brand: <?= $brand_data['nama_brand'] ?></h2>
                         <p><strong>Rentang Tanggal:</strong> <?= $start_date ?> hingga <?= $end_date ?></p>

                         <h3>1. Prior Probabilities</h3>
                         <ul>
                             <li>Laris: <?= number_format($brand_data['prior']['Laris'], 4) ?></li>
                             <li>Tidak Laris: <?= number_format($brand_data['prior']['Tidak Laris'], 4) ?></li>
                         </ul>

                         <h3>2. Likelihood</h3>
                         <ul>
                             <li>Laris:
                                 <ul>
                                     <li>Qty: <?= number_format($brand_data['likelihood']['Laris']['qty'], 4) ?></li>
                                     <li>Harga: <?= number_format($brand_data['likelihood']['Laris']['harga'], 4) ?></li>
                                 </ul>
                             </li>
                             <li>Tidak Laris:
                                 <ul>
                                     <li>Qty: <?= number_format($brand_data['likelihood']['Tidak Laris']['qty'], 4) ?></li>
                                     <li>Harga: <?= number_format($brand_data['likelihood']['Tidak Laris']['harga'], 4) ?></li>
                                 </ul>
                             </li>
                         </ul>

                         <h3>3. Posterior Probabilities</h3>
                         <ul>
                             <li>Laris: <?= number_format($brand_data['laris_posterior'], 4) ?></li>
                             <li>Tidak Laris: <?= number_format($brand_data['tidak_laris_posterior'], 4) ?></li>
                         </ul>

                         <h3>4. Keputusan Final</h3>
                         <p>Hasil: Brand <strong><?= $brand_data['nama_brand'] ?></strong> dinyatakan <strong><?= $brand_data['keputusan_final'] ?></strong>.</p>

                         <a href="<?= base_url('prediksi') ?>" class="btn btn-secondary">Kembali</a>
                     </div>

                 </div>
             </section>
             <div>
                 <br>
             </div>
         </div>