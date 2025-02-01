$(document).ready(function () {
	// Function to load table data based on bulan and tahun

	var Toast = Swal.mixin({
		toast: true,
		position: 'top-end',
		showConfirmButton: false,
		timer: 4000
	});


	function loadTableData() {
		var bulan = $('#bulan').val();
		var tahun = $('#tahun').val();



		// Send the filter data to the server
		$.ajax({
			url: "klasifikasi/filter", // Endpoint to get filtered data
			method: "POST",
			data: {
				bulan: bulan,
				tahun: tahun
			},
			dataType: "json",
			success: function (response) {
				if (response.status) {
					var resultBody = '';
					$.each(response.data, function (index, item) {
						resultBody += `
                            <tr>
                                <td>${index + 1}</td>
                                <td>${item.kode_produk}</td>
                                <td>${item.nama_brand}</td>
                                <td>${item.qty}</td>
                                <td>Rp ${parseInt(item.total_harga).toLocaleString('id-ID')}</td>
                                <td>${new Date(item.tanggal).toLocaleDateString('id-ID')}</td>
                                <td>
                                    <span class="badge ${item.status_popularitas === 'Laris' ? 'bg-success' : 'bg-danger'}">
                                        ${item.status_popularitas}
                                    </span>
                                </td>
                            </tr>`;
					});
					$('#penjualan-body').html(resultBody);
					$('#exportBtn').prop('disabled', false); // Enable the Export button
				} else {
					$('#penjualan-body').html('<tr><td colspan="7" class="text-center">Data tidak ditemukan.</td></tr>');
					$('#exportBtn').prop('disabled', true); // Disable the Export button if no data
				}
			},
			error: function () {
				Toast.fire({
					icon: 'error',
					title: 'Terjadi kesalahan saat mengambil data!',
				});
				// alert('Terjadi kesalahan saat mengambil data.');
			}
		});
	}

	// Event listener for changes in bulan and tahun dropdown
	$('#bulan, #tahun').change(function () {
		loadTableData(); // Load the filtered data based on the selected month and year
	});

	// Initial load
	loadTableData();

	// Export to Excel button
	$('#exportBtn').click(function () {
		var bulan = $('#bulan').val();
		var tahun = $('#tahun').val();

		// Ensure both bulan and tahun are selected
		if (!bulan || !tahun) {
			Toast.fire({
				icon: 'error',
				title: 'Silakan pilih bulan dan tahun terlebih dahulu!',
			});
			// alert('Silakan pilih bulan dan tahun terlebih dahulu.');
			return;
		}

		// Trigger the Excel export via AJAX
		window.location.href = "klasifikasi/export_to_excel?bulan=" + bulan + "&tahun=" + tahun;
	});
});


// $(document).ready(function () {
// 	// Fungsi untuk memuat data berdasarkan bulan dan tahun
// 	function loadTableData() {
// 		var bulan = $('#bulan').val();
// 		var tahun = $('#tahun').val();

// 		// Kirim data filter ke server
// 		$.ajax({
// 			url: "klasifikasi/filter", // Endpoint untuk AJAX
// 			method: "POST",
// 			data: {
// 				bulan: bulan,
// 				tahun: tahun
// 			},
// 			dataType: "json",
// 			success: function (response) {
// 				if (response.status) {
// 					var resultBody = '';
// 					$.each(response.data, function (index, item) {
// 						resultBody += `
//                             <tr>
//                                 <td>${index + 1}</td>
//                                 <td>${item.kode_produk}</td>
//                                 <td>${item.nama_brand}</td>
//                                 <td>${item.qty}</td>
//                                 <td>Rp ${parseInt(item.total_harga).toLocaleString('id-ID')}</td>
//                                 <td>${new Date(item.tanggal).toLocaleDateString('id-ID')}</td>
//                                 <td>
//                                     <span class="badge ${item.status_popularitas === 'Laris' ? 'bg-success' : 'bg-danger'}">
//                                         ${item.status_popularitas}
//                                     </span>
//                                 </td>
//                             </tr>`;
// 					});
// 					$('#penjualan-body').html(resultBody);
// 				} else {
// 					$('#penjualan-body').html('<tr><td colspan="7" class="text-center">Data tidak ditemukan.</td></tr>');
// 				}
// 			},
// 			error: function () {
// 				alert('Terjadi kesalahan saat mengambil data.');
// 			}
// 		});
// 	}

// 	// Event listener untuk perubahan pada dropdown bulan dan tahun
// 	$('#bulan, #tahun').change(function () {
// 		loadTableData(); // Panggil fungsi untuk memuat data
// 	});

// 	// Muat data awal jika diperlukan
// 	loadTableData();
// });
