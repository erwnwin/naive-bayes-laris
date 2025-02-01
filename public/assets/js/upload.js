document.getElementById('fileInput').addEventListener('change', function () {
	var file = this.files[0];

	var Toast = Swal.mixin({
		toast: true,
		position: 'top-end',
		showConfirmButton: false,
		timer: 4000
	});

	if (file) {
		// Check if the file type is allowed
		var allowedExtensions = /(\.csv|\.xls|\.xlsx)$/i;
		if (!allowedExtensions.exec(file.name)) {
			Toast.fire({
				icon: 'error',
				title: 'Please upload a file with .csv, .xls, or .xlsx extension.'
			});
			this.value = ''; // Clear the input
			return;
		}

		var formData = new FormData(document.getElementById('uploadForm'));
		var xhr = new XMLHttpRequest();

		// Show progress container
		document.getElementById('progressContainer').style.display = 'block';

		// Update progress bar with delay
		xhr.upload.addEventListener('progress', function (e) {
			if (e.lengthComputable) {
				var percentage = Math.round((e.loaded / e.total) * 100);
				setTimeout(function () {
					document.getElementById('progressPercentage').textContent = percentage + '%';
					document.getElementById('progressBar').value = percentage;
				}, 100); // 100ms delay
			}
		});

		// Handle the response
		xhr.onreadystatechange = function () {
			if (xhr.readyState === 4) {
				document.getElementById('progressContainer').style.display = 'none';

				if (xhr.status === 200) {
					var response = JSON.parse(xhr.responseText);
					if (response.status === 'success') {
						Toast.fire({
							icon: 'success',
							title: response.message
						});
						// Automatically reload after success
						setTimeout(function () {
							location.reload();
						}, 1500); // Reload after 1.5 seconds
					} else {
						Toast.fire({
							icon: 'error',
							title: response.message
						});
					}
				} else {
					Toast.fire({
						icon: 'error',
						title: 'An error occurred during the upload. Please try again.'
					});
				}
			}
		};

		// Send the request
		xhr.open('POST', 'data-set/upload', true);
		xhr.send(formData);
	}
});
