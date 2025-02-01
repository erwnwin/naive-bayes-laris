         <!-- Content Wrapper. Contains page content -->
         <div class="content-wrapper">
             <!-- Content Header (Page header) -->
             <section class="content-header">
                 <div class="container-fluid">
                     <div class="row mb-2">
                         <div class="col-sm-6">
                             <h1>Prediksi Minat</h1>
                         </div>
                     </div>
                 </div><!-- /.container-fluid -->
             </section>

             <!-- Main content -->
             <section class="content">
                 <div class="container-fluid">

                     <div class="row">
                         <div class="col-lg-2">
                         </div>

                         <div class="col-lg-8 col-12">
                             <div class="card card-default">
                                 <div class="card-header">
                                     <h3 class="card-title">Form Prediksi Minat</span>
                                     </h3>
                                 </div>
                                 <div class="card-body p-0">
                                     <form id="form-predict-interest">
                                         <div class="card-body">
                                             <div class="form-group row">
                                                 <label for="inputEmail3" class="col-sm-4 col-form-label">Nama Brand/Produk</label>
                                                 <div class="col-sm-8">
                                                     <select id="brand" class="form-control" name="brand" required>
                                                         <option value="">-- Pilih Brand --</option>
                                                         <?php foreach ($brands as $brand): ?>
                                                             <option value="<?= $brand['nama_brand']; ?>"><?= $brand['nama_brand']; ?></option>
                                                         <?php endforeach; ?>
                                                     </select>
                                                 </div>
                                             </div>
                                             <div class="form-group row">
                                                 <label for="inputEmail3" class="col-sm-4 col-form-label">Start Date</label>
                                                 <div class="col-sm-8">
                                                     <input type="date" class="form-control" id="start_date" name="start_date" required>
                                                 </div>
                                             </div>
                                             <div class="form-group row">
                                                 <label for="inputEmail3" class="col-sm-4 col-form-label">End Date</label>
                                                 <div class="col-sm-8">
                                                     <input type="date" class="form-control" id="end_date" name="end_date" required>
                                                 </div>
                                             </div>
                                         </div>
                                         <div class="card-footer">
                                             <!-- <button type="submit" class="btn btn-info">Sign in</button> -->
                                             <button type="button" class="btn btn-primaryku btn-sm float-right"
                                                 id="btnPrediksiMinat">
                                                 <span id="btnLoader" style="display: none;">
                                                     <i class="fas fa-spinner fa-spin"></i>
                                                 </span>
                                                 Prediksi Minat
                                             </button>
                                         </div>

                                         <!-- <button type="submit" class="btn btn-primaryku">Predict</button> -->
                                     </form>
                                 </div>
                             </div>

                             <div id="result-container" style="display:none;">
                                 <div class="card">
                                     <div class="card-header">
                                         <h3 class="card-title">Minat Untuk Produk</h3>
                                     </div>
                                     <!-- /.card-header -->
                                     <div class="card-body p-0">
                                         <div class="table-responsive">
                                             <table class="table table-bordered" id="result-table">
                                                 <thead>
                                                     <tr>
                                                         <th>Nama Brand</th>
                                                         <th>Minat Tinggi</th>
                                                         <th>Minat Sedang</th>
                                                         <th>Minat Rendah</th>
                                                         <th>Keterangan</th>
                                                     </tr>
                                                 </thead>
                                                 <tbody id="result-body">
                                                     <!-- Hasil akan muncul di sini -->
                                                 </tbody>
                                             </table>
                                         </div>
                                     </div>
                                     <!-- /.card-body -->
                                 </div>
                                 <!-- /.card -->
                             </div>

                         </div>

                         <div class="col-lg-2">
                         </div>
                     </div>



                 </div>
             </section>
             <div>
                 <br>
             </div>
         </div>