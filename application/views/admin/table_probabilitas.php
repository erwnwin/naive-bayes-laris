         <!-- Content Wrapper. Contains page content -->
         <div class="content-wrapper">
             <!-- Content Header (Page header) -->
             <section class="content-header">
                 <div class="container-fluid">
                     <div class="row mb-2">
                         <div class="col-sm-6">
                             <h1>Tabel Probabilitas</h1>
                         </div>
                     </div>
                 </div><!-- /.container-fluid -->
             </section>

             <!-- Main content -->
             <section class="content">
                 <div class="container-fluid">


                     <h2>Nama Barang</h2>
                     <table class="table">
                         <thead>
                             <tr>
                                 <th>Nama Barang</th>
                                 <th>Probabilitas Laris</th>
                                 <th>Probabilitas Tidak Laris</th>
                             </tr>
                         </thead>
                         <tbody>
                             <?php foreach ($probabilitas['nama_brand']['laris'] as $nama_brand => $prob_laris): ?>
                                 <tr>
                                     <td><?php echo $nama_brand; ?></td>
                                     <td><?php echo number_format($prob_laris, 4); ?></td>
                                     <td><?php echo number_format(isset($probabilitas['nama_brand']['tidak_laris'][$nama_brand]) ? $probabilitas['nama_brand']['tidak_laris'][$nama_brand] : 0, 4); ?></td>
                                 </tr>
                             <?php endforeach; ?>
                         </tbody>
                     </table>

                     <h2>Harga Brand</h2>
                     <table class="table">
                         <thead>
                             <tr>
                                 <th>Harga Brand</th>
                                 <th>Probabilitas Laris</th>
                                 <th>Probabilitas Tidak Laris</th>
                             </tr>
                         </thead>
                         <tbody>
                             <?php foreach ($probabilitas['harga_brand']['laris'] as $harga_brand => $prob_laris): ?>
                                 <tr>
                                     <td><?php echo $harga_brand; ?></td>
                                     <td><?php echo number_format($prob_laris, 4); ?></td>
                                     <td><?php echo number_format(isset($probabilitas['harga_brand']['tidak_laris'][$harga_brand]) ? $probabilitas['harga_brand']['tidak_laris'][$harga_brand] : 0, 4); ?></td>
                                 </tr>
                             <?php endforeach; ?>
                         </tbody>
                     </table>

                     <h2>Qty</h2>
                     <table class="table">
                         <thead>
                             <tr>
                                 <th>Qty</th>
                                 <th>Probabilitas Laris</th>
                                 <th>Probabilitas Tidak Laris</th>
                             </tr>
                         </thead>
                         <tbody>
                             <?php foreach ($probabilitas['qty']['laris'] as $qty => $prob_laris): ?>
                                 <tr>
                                     <td><?php echo $qty; ?></td>
                                     <td><?php echo number_format($prob_laris, 4); ?></td>
                                     <td><?php echo number_format(isset($probabilitas['qty']['tidak_laris'][$qty]) ? $probabilitas['qty']['tidak_laris'][$qty] : 0, 4); ?></td>
                                 </tr>
                             <?php endforeach; ?>
                         </tbody>
                     </table>

                     <h2>Ukuran</h2>
                     <table class="table">
                         <thead>
                             <tr>
                                 <th>Ukuran</th>
                                 <th>Probabilitas Laris</th>
                                 <th>Probabilitas Tidak Laris</th>
                             </tr>
                         </thead>
                         <tbody>
                             <?php foreach ($probabilitas['ukuran']['laris'] as $ukuran => $prob_laris): ?>
                                 <tr>
                                     <td><?php echo $ukuran; ?></td>
                                     <td><?php echo number_format($prob_laris, 4); ?></td>
                                     <td><?php echo number_format(isset($probabilitas['ukuran']['tidak_laris'][$ukuran]) ? $probabilitas['ukuran']['tidak_laris'][$ukuran] : 0, 4); ?></td>
                                 </tr>
                             <?php endforeach; ?>
                         </tbody>
                     </table>

                 </div>
             </section>
             <div>
                 <br>
             </div>
         </div>