<?php
require_once __DIR__ . '/../Controllers/AuthController.php';
require_once __DIR__ . '/../Controllers/RekomendasiController.php';
session_start();

$auth = new AuthController();
$auth->checkAuth();

$rekomendasiController = new RekomendasiController();
$recommendations = $rekomendasiController->getAllRecommendations();
$totalRecommendations = count($recommendations);
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Data Rekomendasi - Sistem Monitoring Tekanan Darah</title>
    <link rel="shortcut icon" type="image/png" href="assets/images/logos/favicon.png" />
    <link rel="stylesheet" href="assets/css/styles.min.css" />
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.bootstrap5.min.css">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />
</head>

<body>
    <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full"
        data-sidebar-position="fixed" data-header-position="fixed">
        <?php include 'partials/sidebar.php'; ?>
        <div class="body-wrapper">
            <?php include 'partials/header.php'; ?>
            <div class="container-fluid">
                <!-- Information Section -->
                <div class="row">
                    <div class="col-12">
                        <div class="card w-100">
                            <div class="card-body bg-light-primary">
                                <div class="row align-items-center">
                                    <div class="col-lg-4">
                                        <img src="assets/images/data/data.png" alt="Recommendation Statistics"
                                            class="img-fluid">
                                    </div>
                                    <div class="col-lg-6">
                                        <h3 class="fw-semibold mb-3">Rekomendasi Pasien</h3>
                                        <p class="fs-4 mb-4">
                                            Riwayat rekomendasi kesehatan berdasarkan hasil pengukuran tekanan darah
                                            pasien.
                                            <?php if (in_array($_SESSION['role'], ['admin', 'doctor'])): ?>
                                                Anda dapat memberikan rekomendasi kesehatan untuk setiap hasil pengukuran.
                                            <?php endif; ?>
                                        </p>

                                        <div class="card bg-primary text-white mb-4">
                                            <div class="card-body d-flex align-items-center">
                                                <i class="ti ti-heart-rate-monitor fs-6 me-3"></i>
                                                <div>
                                                    <h2 class="text-white mb-0"><?= $totalRecommendations ?></h2>
                                                    <p class="mb-0">Total Rekomendasi Diberikan</p>
                                                </div>
                                            </div>
                                        </div>

                                        <?php if (in_array($_SESSION['role'], ['admin', 'doctor'])): ?>
                                            <button type="button" class="btn btn-primary d-flex align-items-center"
                                                data-bs-toggle="modal" data-bs-target="#addRecommendationModal"
                                                style="width: fit-content;">
                                                <i class="ti ti-plus fs-5 me-2"></i>
                                                <span>Berikan Rekomendasi</span>
                                            </button>
                                        <?php endif; ?>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End Information Section -->

                <!-- Alert Messages -->
                <div class="row m-5">
                    <?php if (isset($_SESSION['error'])): ?>
                        <div class="alert alert-danger alert-dismissible fade show border-start border-danger border-5"
                            role="alert">
                            <div class="d-flex align-items-center">
                                <i class="ti ti-alert-circle fs-5 me-2"></i>
                                <div>
                                    <strong>Oops!</strong> <?= $_SESSION['error'] ?>
                                </div>
                            </div>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                        <?php unset($_SESSION['error']); ?>
                    <?php endif; ?>

                    <?php if (isset($_SESSION['success'])): ?>
                        <div class="alert alert-success alert-dismissible fade show border-start border-success border-5"
                            role="alert">
                            <div class="d-flex align-items-center">
                                <i class="ti ti-check-circle fs-5 me-2"></i>
                                <div>
                                    <strong>Berhasil!</strong> <?= $_SESSION['success'] ?>
                                </div>
                            </div>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                        <?php unset($_SESSION['success']); ?>
                    <?php endif; ?>
                </div>
                <!-- /Alert Messages -->

                <!-- Recommendations Table Section -->
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="recommendationTable"
                                        class="table table-striped dt-responsive nowrap w-100">
                                        <thead>
                                            <tr>
                                                <th>Pasien</th>
                                                <th>Pengukuran</th>
                                                <th>Judul</th>
                                                <th>Deskripsi</th>
                                                <th>Dibuat Oleh</th>
                                                <th>Tanggal</th>
                                                <?php if (in_array($_SESSION['role'], ['admin', 'doctor'])): ?>
                                                    <th>Aksi</th>
                                                <?php endif; ?>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($recommendations as $recommendation): ?>
                                                <tr>
                                                    <td><?= htmlspecialchars($recommendation['patient_name']) ?></td>
                                                    <td>
                                                        <?= $recommendation['systolic'] ?>/<?= $recommendation['diastolic'] ?>
                                                        mmHg
                                                        <br>
                                                        <small class="text-muted">
                                                            <?= date('d/m/Y H:i', strtotime($recommendation['reading_date'])) ?>
                                                        </small>
                                                    </td>
                                                    <td><?= htmlspecialchars($recommendation['title']) ?></td>
                                                    <td><?= htmlspecialchars(substr($recommendation['description'], 0, 50)) ?>...
                                                    </td>
                                                    <td><?= htmlspecialchars($recommendation['created_by_name']) ?></td>
                                                    <td><?= date('d/m/Y H:i', strtotime($recommendation['created_at'])) ?>
                                                    </td>
                                                    <?php if (in_array($_SESSION['role'], ['admin', 'doctor'])): ?>
                                                        <td>
                                                            <button type="button"
                                                                class="btn btn-info btn-sm view-recommendation me-1"
                                                                data-recommendation='<?= htmlspecialchars(json_encode($recommendation), ENT_QUOTES, 'UTF-8') ?>'>
                                                                <i class="ti ti-eye"></i>
                                                            </button>
                                                            <button type="button"
                                                                class="btn btn-warning btn-sm edit-recommendation me-1"
                                                                data-recommendation='<?= htmlspecialchars(json_encode($recommendation), ENT_QUOTES, 'UTF-8') ?>'>
                                                                <i class="ti ti-edit"></i>
                                                            </button>
                                                            <button type="button"
                                                                class="btn btn-danger btn-sm delete-recommendation"
                                                                data-id="<?= $recommendation['patient_recommendation_id'] ?>">
                                                                <i class="ti ti-trash"></i>
                                                            </button>
                                                        </td>
                                                    <?php endif; ?>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End Recommendations Table Section -->

                <?php include 'partials/footer.php'; ?>
                <?php include 'partials/rekomendasi-modals.php'; ?>
            </div>
        </div>
    </div>

    <script src="assets/libs/jquery/dist/jquery.min.js"></script>
    <script src="assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/sidebarmenu.js"></script>
    <script src="assets/js/app.min.js"></script>
    <script src="assets/libs/simplebar/dist/simplebar.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.5.0/js/responsive.bootstrap5.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script>

        // View recommendation
        $(document).on('click', '.view-recommendation', function () {
            const recommendation = $(this).data('recommendation');
            $('#view_reading_systolic').text(recommendation.systolic);
            $('#view_reading_diastolic').text(recommendation.diastolic);
            $('#view_reading_date').text(new Date(recommendation.reading_date).toLocaleString('id-ID'));
            $('#view_title').text(recommendation.title);
            $('#view_description').text(recommendation.description);
            $('#view_created_by').text(recommendation.created_by_name);
            $('#view_created_at').text(new Date(recommendation.created_at).toLocaleString('id-ID'));
            $('#viewRecommendationModal').modal('show');
        });

        // Edit recommendation
        $(document).on('click', '.edit-recommendation', function () {
            const recommendation = $(this).data('recommendation');
            $('#edit_recommendation_id').val(recommendation.patient_recommendation_id);
            $('#edit_reading_systolic').text(recommendation.systolic);
            $('#edit_reading_diastolic').text(recommendation.diastolic);
            $('#edit_reading_date').text(new Date(recommendation.reading_date).toLocaleString('id-ID'));
            $('#edit_title').val(recommendation.title);
            $('#edit_description').val(recommendation.description);
            $('#editRecommendationModal').modal('show');
        });

        // Delete recommendation
        $(document).on('click', '.delete-recommendation', function () {
            if (confirm('Apakah Anda yakin ingin menghapus rekomendasi ini?')) {
                const recommendationId = $(this).data('id');
                const form = $('<form>', {
                    'method': 'POST',
                    'action': '../Controllers/RekomendasiController.php'
                });

                form.append($('<input>', {
                    'type': 'hidden',
                    'name': 'action',
                    'value': 'delete_recommendation'
                }));

                form.append($('<input>', {
                    'type': 'hidden',
                    'name': 'recommendation_id',
                    'value': recommendationId
                }));

                $('body').append(form);
                form.submit();
            }
        });

        $(document).ready(function () {
            var table = $('#recommendationTable').DataTable({
                responsive: true,
                language: {
                    url: 'https://cdn.datatables.net/plug-ins/1.13.7/i18n/id.json'
                }
            });

            // Initialize Select2
            $('#patient_selector').select2({
                theme: 'bootstrap-5',
                dropdownParent: $('#addRecommendationModal'),
                ajax: {
                    url: '../Controllers/ajax/RekomendasiAjax.php',
                    type: 'POST',
                    dataType: 'json',
                    delay: 250,
                    data: function (params) {
                        return {
                            action: 'getPatients',
                            search: params.term
                        };
                    },
                    processResults: function (data) {
                        return {
                            results: data.map(function (item) {
                                return {
                                    id: item.patient_id,
                                    text: item.full_name
                                };
                            })
                        };
                    },
                    cache: true
                },
                placeholder: 'Pilih pasien...',
                allowClear: true
            });


            // Handle patient selection
            $('#patient_selector').on('change', function () {
                const patientId = $(this).val();
                if (patientId) {
                    $.ajax({
                        url: '../Controllers/ajax/RekomendasiAjax.php',
                        type: 'POST',
                        data: {
                            action: 'getPatientReadings',
                            patient_id: patientId
                        },
                        success: function (response) {
                            const readings = JSON.parse(response);
                            displayReadings(readings);
                            $('#readings_section').show();
                            $('#addRecommendationForm').hide();
                        }
                    });
                } else {
                    $('#readings_section, #addRecommendationForm').hide();
                }
            });

            // Handle reading selection
            $(document).on('change', '.reading-selector', function () {
                const reading = $(this).data('reading');

                $('#selected_patient_id').val($('#patient_selector').val());
                $('#selected_reading_id').val(reading.reading_id);

                $('#selected_reading_info').html(`
            <strong>Tanggal:</strong> ${new Date(reading.reading_date).toLocaleString('id-ID')}<br>
            <strong>Tekanan Darah:</strong> ${reading.systolic}/${reading.diastolic} mmHg<br>
            <strong>Pulse Rate:</strong> ${reading.pulse_rate} bpm<br>
            <strong>Catatan:</strong> ${reading.notes || '-'}
        `);

                $('#addRecommendationForm').show();
            });

            function displayReadings(readings) {
                let html = '';
                readings.forEach(reading => {
                    html += `
                <tr>
                    <td class="text-center">
                        <input type="radio" name="reading_selection" class="reading-selector" 
                               data-reading='${JSON.stringify(reading)}'>
                    </td>
                    <td>${new Date(reading.reading_date).toLocaleString('id-ID')}</td>
                    <td>${reading.systolic}</td>
                    <td>${reading.diastolic}</td>
                    <td>${reading.pulse_rate}</td>
                    <td>${reading.notes || '-'}</td>
                </tr>
            `;
                });
                $('#readings_table_body').html(html);
            }
        });
    </script>

    <?php if ($_SESSION['role'] === 'patient'): ?>
        <?php include 'partials/notification-script.php'; ?>
    <?php endif; ?>
</body>

</html>