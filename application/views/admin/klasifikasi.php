<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Data Penjualan dengan Klasifikasi</h1>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">


            <div class="row">
                <div class="col-sm-7">
                    <div class="alert custom-alert-danger alert-dismissible">
                        <!-- <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> -->
                        <h5><i class="icon far fa-question-circle"></i>Mohon Diperhatikan!</h5>
                        <p>Klasifikasi / Label (Laris || Tidak Laris) didapatkan dari:</p>

                        <!-- Ganti <ul> dengan <div> dan tambahkan gambar -->
                        <div class="classification-info">
                            <div class="criteria">
                                <ol style="font-weight: bold;">
                                    <li>Qty >= 250</li>

                                </ol>
                            </div>
                        </div>
                        <p>Data klasifikasi ini didapatkan dari data set yang telah diimport sebelumnya.</p>
                    </div>


                </div>
                <div class="col-sm-5">
                    <div class="alert custom-alert-success alert-dismissible">
                        <!-- <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> -->
                        <h5><i class="icon far fa-question-circle"></i>Mohon Diperhatikan!</h5>

                        #Terdapat 7 Fitur yang akan digunakan yakni:
                        <div class="row">
                            <div class="col-sm-3">
                                <p>1. Qty <br>
                                    2. Value <br>
                                </p>
                            </div>
                            <div class="col-sm-3">
                                <p>
                                    3. Gross <br>
                                    4. Disc <br>
                                </p>
                            </div>
                            <div class="col-sm-3">
                                <p>
                                    5. SubTotal <br>
                                    6. Cons <br>
                                </p>
                            </div>
                            <div class="col-sm-3">
                                <p>
                                    7. Netto <br>
                                    8. Periode <br>
                                </p>
                            </div>
                        </div>

                    </div>
                </div>
            </div>


            <div class="card card-default">
                <div class="card-header">
                    <h3 class="card-title">Data Klasifikasi : Label</span></h3>
                    <div class="card-tools">
                        <!-- <form id="filter-form">
                            <div class="row">
                                <div class="col-md-6">
                                    <select id="bulan" name="bulan" class="form-control">
                                        <option value="">-- Pilih Bulan --</option>
                                        <?php
                                        $bulan_array = [
                                            '01' => 'Januari',
                                            '02' => 'Februari',
                                            '03' => 'Maret',
                                            '04' => 'April',
                                            '05' => 'Mei',
                                            '06' => 'Juni',
                                            '07' => 'Juli',
                                            '08' => 'Agustus',
                                            '09' => 'September',
                                            '10' => 'Oktober',
                                            '11' => 'November',
                                            '12' => 'Desember',
                                        ];

                                        foreach ($bulan_array as $key => $value) {
                                            // Tetapkan bulan yang dipilih (jika ada)
                                            $selected = ($this->input->get('bulan') == $key) ? 'selected' : '';
                                            echo "<option value='$key' $selected>$value</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <select id="tahun" name="tahun" class="form-control">
                                        <option value="">-- Pilih Tahun --</option>
                                        <?php
                                        $currentYear = date('Y');
                                        for ($i = $currentYear; $i >= $currentYear - 6; $i--) {
                                            $selected = ($this->input->get('tahun') == $i) ? 'selected' : '';
                                            echo "<option value='$i' $selected>$i</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                        </form> -->
                        <!-- <button class="btn btn-primaryku mt-2" id="exportBtn">Export to Excel</button> -->

                    </div>
                    <!-- <div class="card-tools">
                    </div> -->
                    <!-- <a href="<?= base_url('klasifikasi/export_to_excel') . '?bulan=' . $this->input->get('bulan') . '&tahun=' . $this->input->get('tahun') ?>" class="btn btn-success btn-sm">Export ke Excel</a> -->


                </div>
                <div class="card-body p-0">


                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Nama Barang</th>
                                    <th>Qty</th>
                                    <th>Value</th>
                                    <th>Gross</th>
                                    <th>Disc</th>
                                    <th>Sub Total</th>
                                    <th>Cons</th>
                                    <th>Netto</th>
                                    <th>Label</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($results)): ?>
                                    <?php $no = 1; ?>
                                    <?php foreach ($results as $row): ?>
                                        <tr>
                                            <td><?= $no++; ?></td>
                                            <td><?= htmlspecialchars($row->nama_barang); ?></td>
                                            <td><?= htmlspecialchars($row->qty); ?></td>
                                            <td><?= htmlspecialchars($row->value); ?></td>
                                            <td><?= htmlspecialchars($row->gross); ?></td>
                                            <td><?= htmlspecialchars($row->disc); ?></td>
                                            <td><?= htmlspecialchars($row->subtotal); ?></td>
                                            <td><?= htmlspecialchars($row->cons); ?></td>
                                            <td><?= htmlspecialchars($row->netto); ?></td>
                                            <td>
                                                <?php if ($row->label == 'Laris'): ?>
                                                    <span class="badge bg-success"><?= $row->label; ?></span>
                                                <?php else: ?>
                                                    <span class="badge bg-danger"><?= $row->label; ?></span>
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="5" class="text-center">Tidak ada data barang.</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>


                    <!-- <div class="table-responsive">
                        <table class="table table-bordered" id="penjualan-table">
                            <thead class="table-light">
                                <tr>
                                    <th>#</th>
                                    <th>Nama Barang</th>
                                    <th>Gross</th>
                                    <th>Qty</th>
                                    <th>Status Popularitas / Label</th>
                                </tr>
                            </thead>
                            <tbody id="penjualan-body">
                            </tbody>
                        </table>
                    </div> -->
                </div>
            </div>




        </div>
    </section>
</div>