<footer class="main-footer">
    <div class="float-right d-none d-sm-block">
        Anything you want
    </div>
    <strong>Copyright &copy; 2022-<?php echo date('Y'); ?> <a href="">Titik Balik Teknologi</a>.</strong>
</footer>

<aside class="control-sidebar control-sidebar-dark">
</aside>
</div>

<script src="<?= base_url() ?>public/assets/plugins/jquery/jquery.min.js"></script>
<script src="<?= base_url() ?>public/assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="<?= base_url() ?>public/assets/plugins/sweetalert2/sweetalert2.min.js"></script>
<script src="<?= base_url() ?>public/assets/plugins/toastr/toastr.min.js"></script>
<script src="<?= base_url() ?>public/assets/dist/js/adminlte.min.js"></script>
<script src="<?= base_url() ?>public/assets/js/upload.js"></script>
<script src="<?= base_url() ?>public/ajax/prediksi.js"></script>
<script src="<?= base_url() ?>public/ajax/minat.js"></script>
<script src="<?= base_url() ?>public/ajax/filter.js"></script>
<!-- <script src="<?= base_url() ?>public/assets/js/update-kategori.js"></script> -->
<script src="<?= base_url() ?>public/assets/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?= base_url() ?>public/assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="<?= base_url() ?>public/assets/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="<?= base_url() ?>public/assets/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="<?= base_url() ?>public/assets/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
<script src="<?= base_url() ?>public/assets/plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
<script src="<?= base_url() ?>public/assets/plugins/jszip/jszip.min.js"></script>
<script src="<?= base_url() ?>public/assets/plugins/pdfmake/pdfmake.min.js"></script>
<script src="<?= base_url() ?>public/assets/plugins/pdfmake/vfs_fonts.js"></script>
<script src="<?= base_url() ?>public/assets/plugins/datatables-buttons/js/buttons.html5.min.js"></script>
<script src="<?= base_url() ?>public/assets/plugins/datatables-buttons/js/buttons.print.min.js"></script>
<script src="<?= base_url() ?>public/assets/plugins/datatables-buttons/js/buttons.colVis.min.js"></script>
<!-- Chart.js CDN -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    $(document).ready(function() {
        // Event listener untuk button "Tambahkan"
        $('.btn-tampilkan-rekomendasi').click(function() {
            // Ambil nama barang dari atribut data-nama
            var namaBarang = $(this).data('nama');
            // Tampilkan rekomendasi qty
            $('#rekomendasi-' + namaBarang).toggle();
        });
    });
</script>

<script>
    $(function() {
        $("#example1").DataTable({
            "responsive": true,
            "lengthChange": false,
            "autoWidth": false,
            "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
        }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
        $('#example2').DataTable({
            "paging": true,
            "lengthChange": false,
            "searching": false,
            "ordering": true,
            "info": true,
            "autoWidth": false,
            "responsive": true,
        });
    });
</script>
<script src="https://cdn.jsdelivr.net/npm/mathjax@3/es5/tex-mml-chtml.js"></script>


<script>
    $(document).ready(function() {
        // Checkbox "select all"
        $('#select_all').click(function() {
            var isChecked = $(this).prop('checked');
            $('.row_check').prop('checked', isChecked);
        });

        // Menghapus data terpilih
        $('#delete_selected').click(function() {
            var selectedIds = [];
            $('.row_check:checked').each(function() {
                selectedIds.push($(this).data('id'));
            });

            if (selectedIds.length > 0) {
                // Kirim data ID yang terpilih ke server untuk dihapus
                if (confirm('Apakah Anda yakin ingin menghapus data yang dipilih?')) {
                    $.ajax({
                        url: '<?= base_url("data-set/delete-selected"); ?>', // Ganti dengan URL controller untuk hapus
                        method: 'POST',
                        data: {
                            ids: selectedIds
                        },
                        success: function(response) {
                            // Tanggapan dari server (bisa menghapus row atau memuat ulang data)
                            alert('Data berhasil dihapus.');
                            location.reload(); // Reload halaman setelah data dihapus
                        },
                        error: function() {
                            alert('Terjadi kesalahan saat menghapus data.');
                        }
                    });
                }
            } else {
                alert('Pilih data yang ingin dihapus.');
            }
        });

        // Menghapus data individual
        $('.delete-row').click(function() {
            var id = $(this).data('id');
            if (confirm('Apakah Anda yakin ingin menghapus data ini?')) {
                $.ajax({
                    url: '<?= base_url("data-set/delete-data"); ?>', // Ganti dengan URL controller untuk hapus
                    method: 'POST',
                    data: {
                        id: id
                    },
                    success: function(response) {
                        alert('Data berhasil dihapus.');
                        location.reload(); // Reload halaman setelah data dihapus
                    },
                    error: function() {
                        alert('Terjadi kesalahan saat menghapus data.');
                    }
                });
            }
        });
    });
</script>


<script>
    var ctx = document.getElementById('larisChart').getContext('2d');
    var larisChart = new Chart(ctx, {
        type: 'pie', // Tipe chart: pie atau bar
        data: {
            labels: ['Laris', 'Tidak Laris'], // Label untuk chart
            datasets: [{
                label: 'Jumlah Barang',
                data: [<?= $total_prediksi_laris; ?>, <?= $total_prediksi_tidak_laris; ?>], // Data dari controller
                backgroundColor: ['#17a2b8', '#28a745'], // Warna untuk Laris dan Tidak Laris
                borderColor: ['#ffffff', '#ffffff'], // Warna border
                borderWidth: 1
            }]
        },
        options: {
            responsive: true, // Membuat chart responsif
            maintainAspectRatio: false, // Menonaktifkan rasio aspek tetap
            plugins: {
                legend: {
                    position: 'top',
                },
                tooltip: {
                    callbacks: {
                        label: function(tooltipItem) {
                            return tooltipItem.label + ': ' + tooltipItem.raw;
                        }
                    }
                }
            }
        }
    });
</script>



</body>

</html>