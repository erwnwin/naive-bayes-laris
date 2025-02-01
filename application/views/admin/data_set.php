         <!-- Content Wrapper. Contains page content -->
         <div class="content-wrapper">
             <!-- Content Header (Page header) -->
             <section class="content-header">
                 <div class="container-fluid">
                     <div class="row mb-2">
                         <div class="col-sm-6">
                             <h1>Data Set / Penjualan</h1>
                         </div>
                     </div>
                 </div><!-- /.container-fluid -->
             </section>

             <!-- Main content -->
             <section class="content">
                 <div class="container-fluid">

                     <div class="alert custom-alert-danger alert-dismissible">
                         <!-- <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> -->
                         <h5><i class="icon far fa-question-circle"></i>Mohon Diperhatikan!</h5>
                         Data set berikut adalah data yang diberikan oleh Pihak Issue Shop adalah data rekap untuk <strong>Bulan Maret 2024</strong>!
                         <br>
                         <br>*<u>Note:</u> Hanya data terlampir yang diberikan oleh Issue Shop. Terima Kasih! <br>
                         <a href="<?= base_url('public/storage/report payment brand maret 2024 issue bougenville.pdf') ?>" target="_blank" style="text-decoration: none; margin-top:20px;" class="btn btn-sm btn-success">Lihat Temuan Data</a>
                     </div>

                     <div class="card card-default">
                         <div class="card-header">
                             <div class="card-title">
                                 <a href="<?= base_url('data-set/sample') ?>" class="btn btn-sm btn-primaryku mt-2">Sample File</a>

                                 <!-- <form id="filterForm" method="get">
                                     <div class="input-group input-group-sm mb-3">
                                         <select id="bulan" name="bulan" class="form-control" required>
                                             <option value="">Pilih Bulan</option>
                                             <option value="1" <?= $bulan == 1 ? 'selected' : '' ?>>Januari</option>
                                             <option value="2" <?= $bulan == 2 ? 'selected' : '' ?>>Februari</option>
                                             <option value="3" <?= $bulan == 3 ? 'selected' : '' ?>>Maret</option>
                                             <option value="4" <?= $bulan == 4 ? 'selected' : '' ?>>April</option>
                                             <option value="5" <?= $bulan == 5 ? 'selected' : '' ?>>Mei</option>
                                             <option value="6" <?= $bulan == 6 ? 'selected' : '' ?>>Juni</option>
                                             <option value="7" <?= $bulan == 7 ? 'selected' : '' ?>>Juli</option>
                                             <option value="8" <?= $bulan == 8 ? 'selected' : '' ?>>Agustus</option>
                                             <option value="9" <?= $bulan == 9 ? 'selected' : '' ?>>September</option>
                                             <option value="10" <?= $bulan == 10 ? 'selected' : '' ?>>Oktober</option>
                                             <option value="11" <?= $bulan == 11 ? 'selected' : '' ?>>November</option>
                                             <option value="12" <?= $bulan == 12 ? 'selected' : '' ?>>Desember</option>
                                         </select>
                                         <input type="text" id="tahun" name="tahun" class="form-control" min="2000" max="2099" maxlength="4" value="<?= $tahun ?>">
                                         <div class="input-group-append">
                                             <button class="btn btn-primaryku" type="submit">
                                                 <i class="fas fa-search"></i> Filter
                                             </button>
                                         </div>
                                     </div>
                                 </form> -->
                             </div>


                             <div class="card-tools">
                                 <form id="uploadForm" method="post" enctype="multipart/form-data">
                                     <input type="file" name="uploaded_file" id="fileInput" class="form-control-file" accept=".csv, .xls, .xlsx" required>
                                 </form>

                                 <div id="progressContainer" style="display: none;">
                                     <p>Uploading... <span id="progressPercentage">0%</span></p>
                                     <progress id="progressBar" value="0" max="100" style="width: 100%;"></progress>
                                 </div>

                                 <!-- <a href="<?= base_url('data-set/sample') ?>" class="btn btn-sm btn-primaryku mt-2">Sample File</a> -->


                             </div>
                         </div>
                         <!-- /.card-header -->
                         <div class="card-body">


                             <div id="filteredData">
                                 <div class="table-responsive">
                                     <table class="table">
                                         <thead>
                                             <tr>
                                                 <th><input type="checkbox" id="select_all"></th>
                                                 <th>#</th>
                                                 <th>Nama Brand</th>
                                                 <th>Gross</th>
                                                 <th>Qty</th>
                                                 <!-- <th>Label</th> -->
                                                 <th>Action</th> <!-- Kolom Action untuk Hapus -->
                                             </tr>
                                         </thead>
                                         <tbody>
                                             <?php if (!empty($results)): ?>
                                                 <?php $no = 1; ?>
                                                 <?php foreach ($results as $row): ?>
                                                     <tr>
                                                         <td><input type="checkbox" class="row_check" data-id="<?= $row->id; ?>"></td>
                                                         <td><?= $no++; ?></td>
                                                         <td><?= htmlspecialchars($row->nama_barang); ?></td>
                                                         <td><?= htmlspecialchars($row->gross); ?></td>
                                                         <td><?= htmlspecialchars($row->qty); ?></td>
                                                         <!-- <td>
                                                             <?php if ($row->label == 'Laris'): ?>
                                                                 <span class="badge bg-success"><?= $row->label; ?></span>
                                                             <?php else: ?>
                                                                 <span class="badge bg-danger"><?= $row->label; ?></span>
                                                             <?php endif; ?>
                                                         </td> -->
                                                         <td>
                                                             <!-- Tombol untuk menghapus data individu -->
                                                             <button type="button" class="btn btn-sm btn-danger delete-row" data-id="<?= $row->id; ?>"><i class="fas fa-trash"></i></button>
                                                         </td>
                                                     </tr>
                                                 <?php endforeach; ?>
                                             <?php else: ?>
                                                 <tr>
                                                     <td colspan="7" class="text-center">Tidak ada data untuk bulan dan tahun yang dipilih.</td>
                                                 </tr>
                                             <?php endif; ?>
                                         </tbody>
                                     </table>

                                     <!-- Tombol untuk menghapus data yang dipilih -->
                                     <button type="button" class="btn btn-danger btn-block" id="delete_selected">Hapus Data Terpilih</button>
                                 </div>

                             </div>
                         </div>


                     </div>

             </section>
             <div>
                 <br>
             </div>
         </div>