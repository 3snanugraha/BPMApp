<script>
    $(document).ready(function () {
        function loadPatientNotifications() {
            $.ajax({
                url: '../Controllers/ajax/NotifikasiPasienAjax.php',
                type: 'POST',
                dataType: 'json',
                data: {
                    action: 'getLatestNotifications',
                    user_id: '<?= $_SESSION['user_id'] ?>'
                },
                success: function (data) {


                    // Render recommendations
                    const recHtml = data.recommendations.length ? data.recommendations.map(rec => `
                    <a href="rekomendasi.php" class="message-item d-flex align-items-center border-bottom px-3 py-2">
                        <span class="btn btn-light-info text-info btn-circle">
                            <i class="ti ti-heart-rate-monitor fs-5"></i>
                        </span>
                        <div class="w-75 d-inline-block v-middle ps-3">
                            <h6 class="mb-1 fw-semibold">${rec.title}</h6>
                            <span class="fs-2 text-muted d-block">
                                <i class="ti ti-user me-1"></i>${rec.doctor_name}
                            </span>
                        </div>
                    </a>
                `).join('') : '<p class="text-center p-3">Tidak ada rekomendasi baru</p>';

                    $('#latest_recommendations').html(recHtml);

                    // Render prescriptions
                    const presHtml = data.prescriptions.length ? data.prescriptions.map(pres => `
                    <a href="pengobatan.php" class="message-item d-flex align-items-center border-bottom px-3 py-2">
                        <span class="btn btn-light-warning text-warning btn-circle">
                            <i class="ti ti-medicine fs-5"></i>
                        </span>
                        <div class="w-75 d-inline-block v-middle ps-3">
                            <h6 class="mb-1 fw-semibold">${pres.medication_name}</h6>
                            <span class="fs-2 text-muted d-block">
                                <i class="ti ti-user me-1"></i>${pres.doctor_name}
                            </span>
                        </div>
                    </a>
                `).join('') : '<p class="text-center p-3">Tidak ada pengobatan baru</p>';

                    $('#latest_prescriptions').html(presHtml);
                },
                error: function (xhr, status, error) {

                    $('#latest_recommendations, #latest_prescriptions').html(
                        '<p class="text-center p-3 text-danger">Gagal memuat notifikasi</p>'
                    );
                }
            });
        }

        loadPatientNotifications();
        setInterval(loadPatientNotifications, 30000);
    });
</script>