 <!-- Main Sidebar Container -->
 <aside class="main-sidebar sidebar-dark-primary elevation-4">
     <!-- Brand Logo -->
     <a href="<?= base_url('dashboard') ?>" class="brand-link">
         <!-- <img src="<?= base_url() ?>public/assets/dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8"> -->
         <center>
             <span class="brand-text font-weight-light text-center" style="text-align: center;"><strong>ISSUE SHOP</strong></span>
         </center>
     </a>

     <!-- Sidebar -->
     <div class="sidebar">
         <!-- Sidebar user (optional) -->
         <div class="user-panel mt-3 pb-3  d-flex">
             <div class="image">
                 <div class="img-circle elevation-2" style="width: 40px; height: 40px; background-color: #0988aa; text-align: center; line-height: 40px; font-weight: bold; color: white; font-size: 18px;">
                     <?php
                        $nama_pengguna = $this->session->userdata('nama_pengguna'); // Ambil nama pengguna dari session
                        echo get_initials($nama_pengguna); // Tampilkan inisial
                        ?>
                 </div>
             </div>
             <div class="info">
                 <a href="#" class="d-block mt-2">
                     <?php echo $this->session->userdata('nama_pengguna'); ?>
                 </a>
             </div>
         </div>

         <!-- Sidebar Menu -->
         <nav class="mt-2">
             <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                 <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
                 <?php if ($this->session->userdata('role') == 'Staf Admin') { ?>
                     <li class="nav-header ">Administrator</li>
                 <?php } else { ?>
                     <li class="nav-header ">Pimpinan Toko</li>
                 <?php } ?>
                 <li class="nav-item">
                     <a href="<?= base_url('dashboard') ?>" class="nav-link <?= $this->uri->segment(1) == 'dashboard' ? 'active' : '' ?>">
                         <!-- <i class="nav-icon fas fa-th-large"></i> -->


                         <svg width="17px" height="17px" viewBox="0 0 18 18" xmlns="http://www.w3.org/2000/svg">
                             <g fill="#E7E0E0" fill-rule="nonzero">
                                 <rect width="8" height="8" rx="2" />
                                 <rect width="8" height="8" x="10" rx="2" />
                                 <rect width="8" height="8" x="10" y="10" rx="2" />
                                 <rect width="8" height="8" y="10" rx="2" />
                             </g>
                         </svg>
                         <p>
                             Dashboard
                         </p>
                     </a>
                 </li>

                 <?php if ($this->session->userdata('role') == 'Staf Admin') { ?>


                     <li class="nav-item">
                         <a href="<?= base_url('data-set') ?>" class="nav-link <?= $this->uri->segment(1) == 'data-set' ? 'active' : '' ?>">
                             <i class="nav-icon fas fa-file-excel"></i>
                             <p>
                                 Data Set
                             </p>
                         </a>
                     </li>

                     <!-- <li class="nav-item">
                     <a href="<?= base_url('probabilitas') ?>" class="nav-link <?= $this->uri->segment(1) == 'probabilitas' ? 'active' : '' ?>">
                         <i class="nav-icon fas fa-file-excel"></i>
                         <p>
                             Tabel Probabilitas
                         </p>
                     </a>
                 </li> -->

                     <li class="nav-item">
                         <a href="<?= base_url('klasifikasi') ?>" class="nav-link <?= $this->uri->segment(1) == 'klasifikasi' ? 'active' : '' ?>">
                             <i class="nav-icon far fa-file-alt"></i>
                             <p>
                                 Klasifikasi
                             </p>
                         </a>
                     </li>

                     <!-- <li class="nav-item">
                         <a href="<?= base_url('prediksi-minat') ?>" class="nav-link <?= $this->uri->segment(1) == 'prediksi-minat' ? 'active' : '' ?>">

                             <i class="nav-icon fas fa-less-than-equal"></i>
                             <p>
                                 Prediksi Minat
                             </p>
                         </a>
                     </li> -->

                     <li class="nav-item">
                         <a href="<?= base_url('perhitungan') ?>" class="nav-link <?= $this->uri->segment(1) == 'perhitungan' ? 'active' : '' ?>">
                             <!-- <i class="nav-icon fas fa-less-than-equal"></i> -->
                             <i class="nav-icon fas fa-chart-line"></i>

                             <p>
                                 Proses Naive Bayes
                             </p>
                         </a>
                     </li>


                     <!-- <li class="nav-item">
                     <a href="<?= base_url('riwayat-hasil') ?>" class="nav-link <?= $this->uri->segment(1) == 'riwayat-hasil' ? 'active' : '' ?>">
                         <i class="nav-icon fas fa-history"></i>
                         <p>
                             Riwayat Hasil
                         </p>
                     </a>
                 </li> -->

                     <!-- <li class="nav-item <?= $this->uri->segment(1) == 'probabilitas' || $this->uri->segment(1) == 'perhitungan' || $this->uri->segment(1) == 'riwayat-hasil' ? 'menu-open' : '' ?>">
                     <a href="#" class="nav-link <?= $this->uri->segment(1) == 'probabilitas' || $this->uri->segment(1) == 'perhitungan' || $this->uri->segment(1) == 'riwayat-hasil' ? 'active' : '' ?>">
                         <i class="nav-icon fas fa-chart-line"></i>
                         <p>
                             Perhitungan
                             <i class="fas fa-angle-left right"></i>
                         </p>
                     </a>
                     <ul class="nav nav-treeview">
                         <li class="nav-item">
                             <a href="<?= base_url('probabilitas') ?>" class="nav-link <?= $this->uri->segment(1) == 'probabilitas' ? 'active' : '' ?>">
                                 <i class="far fa-check-circle nav-icon"></i>
                                 <p>Tabel Probabilitas</p>
                             </a>
                         </li>


                         <li class="nav-item">
                             <a href="<?= base_url('perhitungan') ?>" class="nav-link <?= $this->uri->segment(1) == 'perhitungan' ? 'active' : '' ?>">
                                 <i class="far fa-check-circle nav-icon"></i>
                                 <p>Tabel Perhitungan</p>
                             </a>
                         </li>

                         <li class="nav-item">
                             <a href="<?= base_url('riwayat-hasil') ?>" class="nav-link <?= $this->uri->segment(1) == 'riwayat-hasil' ? 'active' : '' ?>">
                                 <i class="far fa-check-circle nav-icon"></i>
                                 <p>Tabel Riwayat Hasil</p>
                             </a>
                         </li>
                     </ul>
                 </li> -->

                     <li class="nav-header ">Utility</li>
                     <li class="nav-item">
                         <a href="<?= base_url('pengguna') ?>" class="nav-link <?= $this->uri->segment(1) == 'pengguna' ? 'active' : '' ?>">
                             <i class="nav-icon fas fa-user-cog"></i>
                             <p>
                                 Role Pengguna
                             </p>
                         </a>
                     </li>

                 <?php } ?>


                 <?php if ($this->session->userdata('role') == 'Pimpinan Toko') { ?>
                     <li class="nav-item">
                         <a href="<?= base_url('profil') ?>" class="nav-link <?= $this->uri->segment(1) == 'profil' ? 'active' : '' ?>">
                             <i class="nav-icon fas fa-user-circle"></i>
                             <p>
                                 Profil
                             </p>
                         </a>
                     </li>

                     <li class="nav-item">
                         <a href="<?= base_url('riwayat-hasil') ?>" class="nav-link <?= $this->uri->segment(1) == 'riwayat-hasil' ? 'active' : '' ?>">
                             <i class="nav-icon fas fa-file-alt"></i>
                             <p>
                                 Report Prediksi
                             </p>
                         </a>
                     </li>
                 <?php } ?>

                 <li class="nav-item">
                     <a href="<?= base_url('logout') ?>" class="nav-link">
                         <i class="nav-icon fas fa-power-off"></i>
                         <p>
                             Logout
                         </p>
                     </a>
                 </li>

                 <!--   <li class="nav-item">
                     <a href="<?= base_url('pengaduan') ?>" class="nav-link <?= $this->uri->segment(1) == 'pengaduan' ? 'active' : '' ?>">
                         <i class="nav-icon fas fa-comments"></i>
                         <p>
                             Pengaduan
                         </p>
                     </a>
                 </li> -->

                 <!-- <li class="nav-header ">Utility</li>
                 <li class="nav-item">
                     <a href="<?= base_url('info-apps') ?>" class="nav-link <?= $this->uri->segment(1) == 'info-apps' ? 'active' : '' ?>">
                         <i class="nav-icon fas fa-info-circle"></i>
                         <p>
                             Info Apps
                         </p>
                     </a>
                 </li>
                 <li class="nav-item">
                     <a href="<?= base_url('logout') ?>" class="nav-link">
                         <i class="nav-icon fas fa-power-off"></i>
                         <p>
                             Logout
                         </p>
                     </a>
                 </li> -->

             </ul>
         </nav>
         <!-- /.sidebar-menu -->
     </div>
     <!-- /.sidebar -->
 </aside>