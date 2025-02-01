         <!-- Content Wrapper. Contains page content -->
         <div class="content-wrapper">
             <!-- Content Header (Page header) -->
             <section class="content-header">
                 <div class="container-fluid">
                     <div class="row mb-2">
                         <div class="col-sm-6">
                             <h1>Dashboard</h1>
                         </div>
                     </div>
                 </div><!-- /.container-fluid -->
             </section>

             <!-- Main content -->
             <section class="content">
                 <div class="container-fluid">

                     <div class="callout callout-custom">
                         <h5>Welcome! <?= $this->session->userdata('nama_pengguna') ?></h5>
                         <hr>
                         <p>Anda login sebagai
                             <?php if (
                                    $this->session->userdata('role') == 'Staf Admin'
                                ) { ?>
                                 <?= $this->session->userdata('role') ?>
                             <?php } else { ?>
                                 <?= $this->session->userdata('role') ?>
                             <?php } ?>
                         </p>
                     </div>



                     <div class="row">
                         <div class="col-sm-6">
                             <div class="card show-card card-aprioriku">
                                 <div class="card-header text-white">
                                     <h3 class="card-title">Perbandingan Laris VS Tidak Laris</h3>
                                 </div>
                                 <div class="card-body">
                                     <canvas id="larisChart" width="600" height="400"></canvas>

                                 </div>
                             </div>
                         </div>

                         <div class="col-sm-6">

                             <div class="small-box bg-info">
                                 <div class="inner">
                                     <h3><?= $total_prediksi_laris; ?> Brand</h3>
                                     <p>Jumlah Prediksi Barang Laris </p>
                                 </div>
                                 <div class="icon">

                                     <i class="fas fa-check-circle"></i>

                                 </div>
                                 <a href="<?= base_url('perhitungan') ?>" class="small-box-footer">Lihat Selengkapnya <i class="fas fa-arrow-circle-right"></i></a>
                             </div>
                             <!-- ./col -->
                             <div class="small-box bg-success">
                                 <div class="inner">
                                     <h3><?= $total_prediksi_tidak_laris; ?> Brand</h3>
                                     <p>Jumlah Prediksi Barang Tidak Laris </p>

                                 </div>
                                 <div class="icon">
                                     <i class="fas fa-times-circle"></i>

                                 </div>
                                 <a href="<?= base_url('perhitungan') ?>" class="small-box-footer">Lihat Selengkapnya <i class="fas fa-arrow-circle-right"></i></a>
                             </div>


                             <div class="small-box bg-primary">
                                 <div class="inner">
                                     <h3><?= $total_data; ?> Brand</h3>
                                     <p>Jumlah Data Set / Data Uji </p>

                                 </div>
                                 <div class="icon">
                                     <i class="fas fa-list"></i>

                                 </div>
                                 <a href="<?= base_url('data-set') ?>" class="small-box-footer">Lihat Selengkapnya <i class="fas fa-arrow-circle-right"></i></a>
                             </div>
                         </div>



                     </div>

                 </div>
             </section>
             <div>
                 <br>
             </div>
         </div>