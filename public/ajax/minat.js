$('#btnPrediksiMinat').click(function () {


	var Toast = Swal.mixin({
		toast: true,
		position: 'top-end',
		showConfirmButton: false,
		timer: 4000
	});

	var brand = $('#brand').val();
	var start_date = $('#start_date').val();
	var end_date = $('#end_date').val();

	if (brand && start_date && end_date) {
		$('#btnLoader').show();

		$.ajax({
			url: "prediksi-minat/act-result",
			method: "POST",
			data: {
				brand: brand,
				start_date: start_date,
				end_date: end_date
			},
			dataType: "json",
			success: function (response) {
				$('#btnLoader').hide();

				if (response.status) {
					var result = response.result;
					var resultBody = `
                        <tr>
                            <td>${result.nama_brand}</td>
                            <td>${result.prior['Minat Tinggi'].toFixed(4)}</td>
                            <td>${result.prior['Minat Sedang'].toFixed(4)}</td>
                            <td>${result.prior['Minat Rendah'].toFixed(4)}</td>
                            <td>
								<span class="badge ${result.prediksi === 'Minat Tinggi' ? 'bg-success' : (result.prediksi === 'Minat Sedang' ? 'bg-warning' : 'bg-danger')}">
									${result.prediksi}
								</span>
							</td>
                        </tr>`;
					$('#result-body').html(resultBody);
					$('#result-container').show();
				} else {
					Toast.fire({
						icon: 'error',
						title: response.message,
					});
					// alert(response.message);
				}
			},
			error: function () {
				$('#btnLoader').hide();
				Toast.fire({
					icon: 'error',
					title: 'Terjadi kesalahan saat menghubungi server atau data tidak tersedia pada range tanggal yang dipilih!',
				});
				// alert("Terjadi kesalahan saat menghubungi server.");
			}
		});
	} else {
		Toast.fire({
			icon: 'error',
			title: 'Tolong isi semua input (brand, tanggal mulai, tanggal akhir).',
		});
		// alert('Tolong isi semua input (brand, tanggal mulai, tanggal akhir).');
	}
});
