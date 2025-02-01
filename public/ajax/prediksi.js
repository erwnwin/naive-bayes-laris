$(document).ready(function () {
	// Event listener untuk tombol "Proses Naive Bayes"
	$('#btnPrediksi').click(function () {
		// Tampilkan loader
		$('#btnLoader').show();

		// Ambil nilai tanggal awal dan tanggal akhir
		var tanggal_awal = $('#tanggal_awal').val();
		var tanggal_akhir = $('#tanggal_akhir').val();

		// Kirim data ke server menggunakan AJAX
		$.ajax({
			url: "naivebayes/predict_by_range", // URL endpoint
			type: 'POST',
			data: {
				tanggal_awal: tanggal_awal,
				tanggal_akhir: tanggal_akhir
			},
			dataType: 'json',
			success: function (response) {
				// Sembunyikan loader
				$('#btnLoader').hide();

				// Tampilkan container hasil prediksi
				$('#result-container').show();

				// Kosongkan tabel hasil prediksi
				$('#result-body').empty();

				// Loop melalui hasil prediksi dan tambahkan ke tabel
				response.forEach(function (prediction) {
					var row = `<tr>
                            <td>${prediction.kode_produk}</td>
                            <td>${prediction.nama_brand}</td>
                            <td>${prediction.tanggal}</td>
                            <td>${prediction.prediction}</td>
							<td>
                            <a href="perhitungan/detail/${encodeURIComponent(prediction.nama_brand)}?tanggal_awal=${tanggal_awal}&tanggal_akhir=${tanggal_akhir}" 
                               class="btn btn-sm btn-primary">
                                Detail
                            </a>
                        </td>
                        </tr>`;
					$('#result-body').append(row);
				});
			},
			error: function (xhr, status, error) {
				// Sembunyikan loader
				$('#btnLoader').hide();

				// Tampilkan pesan error
				alert('Terjadi kesalahan saat memproses prediksi.');
				console.error(xhr.responseText);
			}
		});
	});
});

// Fungsi untuk menampilkan detail (opsional)
function showDetail(nama_brand) {
	alert('Detail untuk brand: ' + nama_brand);
}
