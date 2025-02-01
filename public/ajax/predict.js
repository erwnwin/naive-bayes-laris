$(document).ready(function () {
    var Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 4000
    });

    $('#btnPrediksi').click(function () {
        var start_date = $('#start_date').val();
        var end_date = $('#end_date').val();

        // Validasi input
        if (start_date && end_date) {
            $('#btnLoader').show(); // Tampilkan spinner
            $('#result-container').hide(); // Sembunyikan hasil sebelumnya

            // Kirim data ke server menggunakan AJAX
            $.ajax({
                url: "perhitungan/prediksi",
                method: "POST",
                data: {
                    start_date: start_date,
                    end_date: end_date
                },
                dataType: "json",
                success: function (response) {
                    $('#btnLoader').hide(); // Sembunyikan spinner
                    $('#result-container').show(); // Tampilkan hasil

                    if (response.status && response.predictions.length > 0) {
                        var resultBody = '';
                        $.each(response.predictions, function (index, prediction) {
                            resultBody += '<tr>';
                            resultBody += '<td>' + prediction.nama_brand + '</td>';
                            resultBody += '<td>' + prediction.prior.Laris.toFixed(4) + '</td>';
                            resultBody += '<td>' + prediction.prior['Tidak Laris'].toFixed(4) + '</td>';
                            resultBody += '<td>' + JSON.stringify(prediction.likelihood.Laris) + '</td>';
                            resultBody += '<td>' + JSON.stringify(prediction.likelihood['Tidak Laris']) + '</td>';
                            resultBody += '<td><span class="badge ' +
                                (prediction.prediksi === 'Laris' ? 'bg-success' : 'bg-danger') +
                                '">' +
                                prediction.prediksi +
                                '</span></td>';
                            resultBody += '</tr>';
                        });
                        $('#result-body').html(resultBody);
                    } else {
                        $('#result-body').html(`
                            <tr>
                                <td colspan="6" class="text-center">
                                    Tidak Ada data disini!!
                                </td>
                            </tr>
                        `);
                    }
                },
                error: function () {
                    $('#btnLoader').hide(); // Sembunyikan spinner
                    Toast.fire({
                        icon: 'error',
                        title: 'Terjadi kesalahan saat menghubungi server.',
                    });
                }
            });
        } else {
            Toast.fire({
                icon: 'error',
                title: 'Sorry!! Silahkan isi kedua range tanggal',
            });
        }
    });
});