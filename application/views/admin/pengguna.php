         <!-- Content Wrapper. Contains page content -->
         <div class="content-wrapper">
             <!-- Content Header (Page header) -->
             <section class="content-header">
                 <div class="container-fluid">
                     <div class="row mb-2">
                         <div class="col-sm-6">
                             <h1>Role Pengguna Sistem</h1>
                         </div>
                     </div>
                 </div><!-- /.container-fluid -->
             </section>

             <!-- Main content -->
             <section class="content">
                 <div class="container-fluid">

                     <div class="card card-default">
                         <div class="card-header">
                             <h3 class="card-title">Daftar Role Akses Pengguna</span></h3>
                         </div>
                         <div class="card-body p-0">
                             <table class="table ">
                                 <thead class="table-light">
                                     <tr>
                                         <th>#</th>
                                         <th>Nama Pengguna</th>
                                         <th>Username</th>
                                         <th>Role Akses</th>
                                         <th>Action</th>
                                     </tr>
                                 </thead>
                                 <tbody>
                                     <?php $no = 1;
                                        foreach ($pengguna as $p) { ?>
                                         <tr>
                                             <td><?= $no++; ?></td>
                                             <td><?= $p->nama_pengguna ?></td>
                                             <td><?= $p->username ?></td>
                                             <td>
                                                 <?php if ($p->role == 'Staf Admin') { ?>
                                                     <span class="badge bg-success"><?= $p->role ?></span>
                                                 <?php } else { ?>
                                                     <span class="badge bg-primary"><?= $p->role ?></span>
                                                 <?php } ?>
                                             </td>
                                             <td></td>
                                         </tr>
                                     <?php } ?>
                                 </tbody>
                             </table>
                         </div>
                     </div>

                 </div>
             </section>
         </div>