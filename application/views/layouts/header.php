 <!-- Navbar -->
 <nav class="main-header navbar navbar-expand navbar-white navbar-light">
     <!-- Left navbar links -->
     <ul class="navbar-nav">
         <li class="nav-item">
             <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
         </li>
         <!-- <li class="nav-item d-none d-sm-inline-block">
             <a href="../../index3.html" class="nav-link"><i class="fa fa-arrow-left"></i> Back</a>
         </li> -->
     </ul>

     <!-- Right navbar links -->
     <ul class="navbar-nav ml-auto">

         <!-- Notifications Dropdown Menu -->
         <li class="nav-item dropdown">
             <a class="nav-link" data-toggle="dropdown" href="#">
                 <i class="far fa-user-circle"></i> <span class="ml-1"><?=
                                                                        $this->session->userdata('nama_pengguna');
                                                                        ?></span>
                 <!-- <span class="badge badge-warning navbar-badge">15</span> -->
             </a>
             <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                 <span class="dropdown-item dropdown-header">Direct Menu</span>
                 <div class="dropdown-divider"></div>
                 <a href="<?= base_url('profil') ?>" class="dropdown-item">
                     <i class="fas fa-user-circle mr-2"></i> Profil
                 </a>
                 <div class="dropdown-divider"></div>
                 <a href="<?= base_url('logout') ?>" class="dropdown-item">
                     <i class="fas fa-power-off mr-2"></i>Logout
                 </a>

             </div>
         </li>
     </ul>
 </nav>
 <!-- /.navbar -->