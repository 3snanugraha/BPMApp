<?php
require_once __DIR__ . '/../Controllers/AuthController.php';
require_once __DIR__ . '/../Controllers/RiwayatController.php';
session_start();

$auth = new AuthController();
$auth->checkAuth();

$riwayatController = new RiwayatController();
$readings = $riwayatController->getReadings();
$totalReadings = count($readings);
$readingStats = $riwayatController->getReadingStats();
$monthlyAverages = $riwayatController->getMonthlyAverages();
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Data Riwayat - Sistem Monitoring Tekanan Darah</title>
    <link rel="shortcut icon" type="image/png" href="assets/images/logos/favicon.png" />
    <link rel="stylesheet" href="assets/css/styles.min.css" />
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.bootstrap5.min.css">
    <!-- Add Chart.js for statistics -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body>
    <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full"
        data-sidebar-position="fixed" data-header-position="fixed">
        <!-- Sidebar Start -->
        <?php include 'partials/sidebar.php'; ?>
        <!--  Sidebar End -->
        <div class="body-wrapper">
            <!--  Header Start -->
            <?php include 'partials/header.php'; ?>
            <!--  Header End -->
            <div class="container-fluid">
                <!-- Information Section -->
                <div class="row">
                    <div class="col-12">
                        <div class="card w-100">
                            <div class="card-body bg-light-primary">
                                <div class="row align-items-center">
                                    <div class="col-lg-4">
                                        <img src="assets/images/data/data.png" alt="Blood Pressure Statistics"
                                            class="img-fluid">
                                    </div>
                                    <div class="col-lg-6">
                                        <h3 class="fw-semibold mb-3">Riwayat Tekanan Darah</h3>
                                        <p class="fs-4 mb-4">
                                            Kelola data riwayat tekanan darah dalam sistem monitoring.
                                            Anda dapat melihat tren dan statistik tekanan darah.
                                        </p>

                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="card bg-primary text-white mb-4">
                                                    <div class="card-body d-flex align-items-center">
                                                        <i class="ti ti-heart-rate fs-6 me-3"></i>
                                                        <div>
                                                            <h2 class="text-white mb-0"><?= $totalReadings ?></h2>
                                                            <p class="mb-0">Total Pengukuran</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="card bg-success text-white mb-4">
                                                    <div class="card-body d-flex align-items-center">
                                                        <i class="ti ti-activity fs-6 me-3"></i>
                                                        <div>
                                                            <h2 class="text-white mb-0">
                                                                <?= round((float) $readingStats['avg_systolic'] ?? 0) ?>/<?= round((float) $readingStats['avg_diastolic'] ?? 0) ?>
                                                            </h2>
                                                            <p class="mb-0">Rata-rata Tekanan Darah</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <button class="btn btn-primary d-flex align-items-center" data-bs-toggle="modal"
                                            data-bs-target="#addReadingModal">
                                            <i class="ti ti-plus fs-5 me-2"></i>
                                            <span>Tambah Data Tekanan Darah</span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /Information Section -->

                <!-- Statistics Section -->
                <div class="row mb-4">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Tren Tekanan Darah</h5>
                                <canvas id="bloodPressureChart"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /Statistics Section -->

                <!-- Custom Datatable Section -->
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="readingsTable" class="table table-striped dt-responsive nowrap w-100">
                                        <thead>
                                            <tr>
                                                <th>Tanggal</th>
                                                <th>Systolic</th>
                                                <th>Diastolic</th>
                                                <th>Detak Jantung</th>
                                                <th>Catatan</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($readings as $reading): ?>
                                                <tr>
                                                    <td><?= date('d/m/Y H:i', strtotime($reading['reading_date'])) ?></td>
                                                    <td><?= htmlspecialchars($reading['systolic']) ?></td>
                                                    <td><?= htmlspecialchars($reading['diastolic']) ?></td>
                                                    <td><?= htmlspecialchars($reading['pulse_rate']) ?></td>
                                                    <td><?= htmlspecialchars($reading['notes']) ?></td>
                                                    <td>
                                                        <button type="button" class="btn btn-info btn-sm view-reading"
                                                            data-reading='<?= htmlspecialchars(json_encode($reading), ENT_QUOTES, 'UTF-8') ?>'>
                                                            <i class="ti ti-eye"></i>
                                                        </button>
                                                        <button type="button" class="btn btn-warning btn-sm edit-reading"
                                                            data-reading='<?= htmlspecialchars(json_encode($reading), ENT_QUOTES, 'UTF-8') ?>'>
                                                            <i class="ti ti-edit"></i>
                                                        </button>
                                                        <button type="button" class="btn btn-danger btn-sm delete-reading"
                                                            data-id="<?= $reading['reading_id'] ?>">
                                                            <i class="ti ti-trash"></i>
                                                        </button>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /Custom Datatable Section -->

                <!-- Footer -->
                <?php include 'partials/footer.php'; ?>
                <!-- /Footer -->

                <!-- Modals -->
                <?php include 'partials/riwayat-modals.php'; ?>
                <!-- /Modals -->
            </div>
        </div>
    </div>

    <script src="assets/libs/jquery/dist/jquery.min.js"></script>
    <script src="assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/sidebarmenu.js"></script>
    <script src="assets/js/app.min.js"></script>
    <script src="assets/libs/simplebar/dist/simplebar.js"></script>

    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.5.0/js/responsive.bootstrap5.min.js"></script>

    <script>
        $(document).ready(function () {
            // Initialize DataTable
            var table = $('#readingsTable').DataTable({
                responsive: true,
                language: {
                    url: '//cdn.datatables.net/plug-ins/1.13.7/i18n/id.json'
                },
                order: [[0, 'desc']]
            });

            // Initialize Blood Pressure Chart
            var ctx = document.getElementById('bloodPressureChart').getContext('2d');
            var monthlyData = <?= json_encode($monthlyAverages) ?>;

            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: monthlyData.map(item => item.month),
                    datasets: [{
                        label: 'Systolic',
                        data: monthlyData.map(item => item.avg_systolic),
                        borderColor: 'rgb(255, 99, 132)',
                        tension: 0.1
                    }, {
                        label: 'Diastolic',
                        data: monthlyData.map(item => item.avg_diastolic),
                        borderColor: 'rgb(54, 162, 235)',
                        tension: 0.1
                    }]
                },
                options: {
                    responsive: true,
                    scales: {
                        y: {
                            beginAtZero: false
                        }
                    }
                }
            });

            // Handle View Reading
            $(document).on('click', '.view-reading', function () {
                var reading = $(this).data('reading');
                $('#viewReadingModal').modal('show');
                $('#view_patient_name').text(reading.patient_name || '-');
                $('#view_systolic').text(reading.systolic);
                $('#view_diastolic').text(reading.diastolic);
                $('#view_pulse_rate').text(reading.pulse_rate);
                $('#view_notes').text(reading.notes || '-');
                $('#view_reading_date').text(new Date(reading.reading_date).toLocaleString('id-ID'));
                $('#view_recommendation_title').text(reading.recommendation_title || '-');
                $('#view_recommendation_description').text(reading.recommendation_description || '-');
            });

            // Handle Edit Reading
            $(document).on('click', '.edit-reading', function () {
                var reading = $(this).data('reading');
                $('#editReadingModal').modal('show');
                $('#edit_reading_id').val(reading.reading_id);
                $('#edit_systolic').val(reading.systolic);
                $('#edit_diastolic').val(reading.diastolic);
                $('#edit_pulse_rate').val(reading.pulse_rate);
                $('#edit_notes').val(reading.notes);
            });

            // Handle Delete Reading
            $(document).on('click', '.delete-reading', function () {
                var readingId = $(this).data('id');
                $('#deleteReadingModal').modal('show');
                $('#delete_reading_id').val(readingId);
            });
        });
    </script>
</body>


</html>