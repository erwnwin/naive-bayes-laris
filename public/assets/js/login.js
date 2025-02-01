$(document).ready(function () {
	// SweetAlert2 toast configuration
	var Toast = Swal.mixin({
		toast: true,
		position: 'top-end',
		showConfirmButton: false,
		timer: 4000
	});

	$('#loginForm').on('submit', function (e) {
		e.preventDefault(); // Mencegah form dari pengiriman default


		var username = $('#username').val();
		var password = $('#password').val();

		// Validasi input
		if (!username || !password) {
			Toast.fire({
				icon: response.status === 'success' ? 'success' : 'error',
				title: response.message // Pesan dari respons AJAX
			});
			$('#login-message').html('<div class="alert alert-danger">Username dan Password wajib diisi.</div>');
			return;
		}

		// Menampilkan loader
		$('#btnLoader').show();

		$.ajax({
			url: "auth/login", // Pastikan ini sesuai dengan rute Anda
			type: "POST",
			data: $(this).serialize(),
			dataType: "json",
			success: function (response) {
				// Menyembunyikan loader
				$('#btnLoader').hide();

				// Menampilkan notifikasi menggunakan SweetAlert2 toast
				Toast.fire({
					icon: response.status === 'success' ? 'success' : 'error',
					title: response.message // Pesan dari respons AJAX
				});

				// Mengosongkan form jika login berhasil
				if (response.status === 'success') {
					$('#loginForm')[0].reset(); // Reset form
					setTimeout(function () {
						window.location.href = "dashboard"; // Pastikan ini sesuai dengan rute dashboard Anda
					}, 1500); // Menunggu beberapa detik sebelum redirect
				}
			},
			error: function () {
				$('#btnLoader').hide();
				Toast.fire({
					icon: 'error',
					title: 'Something went wrong. Please try again.'
				});
			}
		});
	});
});
