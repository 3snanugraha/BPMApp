<?php
require_once __DIR__ . '/../Controllers/AuthController.php';
require_once __DIR__ . '/../Controllers/PencatatanController.php';
session_start();

$auth = new AuthController();
$auth->checkAuth();

$pencatatanController = new PencatatanController();
$todayReadings = $pencatatanController->getTodayReadings();
$latestReading = $pencatatanController->getLatestReading();
$readingTrend = $pencatatanController->getReadingTrend();
$abnormalReadings = $pencatatanController->getAbnormalReadings();

// Get patient data if user is doctor
$patients = [];
if ($_SESSION['role'] === 'doctor') {
    $patients = $pencatatanController->getDoctorPatients();
}
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Pencatatan Tekanan Darah - Sistem Monitoring Tekanan Darah</title>
    <link rel="shortcut icon" type="image/png" href="assets/images/logos/favicon.png" />
    <link rel="stylesheet" href="assets/css/styles.min.css" />
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.bootstrap5.min.css">
    <!-- Chart.js -->
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
                                        <img src="assets/images/data/data.png" alt="Blood Pressure Recording"
                                            class="img-fluid">
                                    </div>
                                    <div class="col-lg-6">
                                        <h3 class="fw-semibold mb-3">Pencatatan Tekanan Darah</h3>
                                        <p class="fs-4 mb-4">
                                            Catat dan pantau tekanan darah Anda secara teratur.
                                            Data akan dianalisis untuk memberikan rekomendasi kesehatan yang sesuai.
                                        </p>

                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="card bg-primary text-white mb-4">
                                                    <div class="card-body d-flex align-items-center">
                                                        <i class="ti ti-heart-rate fs-6 me-3"></i>
                                                        <div>
                                                            <h2 class="text-white mb-0"><?= count($todayReadings) ?>
                                                            </h2>
                                                            <p class="mb-0">Pengukuran Hari Ini</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <?php if ($latestReading): ?>
                                                <div class="col-md-6">
                                                    <div class="card bg-success text-white mb-4">
                                                        <div class="card-body text-center">
                                                            <h6 class="mb-2">Pengukuran Terakhir</h6>
                                                            <h3 class="text-white mb-0">
                                                                <?= $latestReading['systolic'] ?>/<?= $latestReading['diastolic'] ?>
                                                            </h3>
                                                            <small>mmHg</small>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php endif; ?>
                                        </div>

                                        <div class="d-flex gap-2">
                                            <button class="btn btn-primary d-flex align-items-center"
                                                data-bs-toggle="modal" data-bs-target="#addReadingModal">
                                                <i class="ti ti-plus fs-5 me-2"></i>
                                                <span>Catat Tekanan Darah</span>
                                            </button>
                                            <button class="btn btn-info d-flex align-items-center"
                                                data-bs-toggle="modal" data-bs-target="#chartModal">
                                                <i class="ti ti-chart-line fs-5 me-2"></i>
                                                <span>Lihat Grafik</span>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Today's Readings Section -->
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title mb-3">Pengukuran Hari Ini</h5>
                                <div class="table-responsive">
                                    <table id="readingsTable" class="table table-striped dt-responsive nowrap w-100">
                                        <thead>
                                            <tr>
                                                <th>Waktu</th>
                                                <th>Systolic</th>
                                                <th>Diastolic</th>
                                                <th>Detak Jantung</th>
                                                <th>Status</th>
                                                <th>Catatan</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($todayReadings as $reading): ?>
                                                <tr>
                                                    <td><?= date('H:i', strtotime($reading['reading_date'])) ?></td>
                                                    <td><?= $reading['systolic'] ?></td>
                                                    <td><?= $reading['diastolic'] ?></td>
                                                    <td><?= $reading['pulse_rate'] ?> bpm</td>
                                                    <td>
                                                        <?php
                                                        $status = '';
                                                        $class = '';
                                                        if ($reading['systolic'] >= 140 || $reading['diastolic'] >= 90) {
                                                            $status = 'Tinggi';
                                                            $class = 'danger';
                                                        } elseif ($reading['systolic'] >= 120 || $reading['diastolic'] >= 80) {
                                                            $status = 'Prehipertensi';
                                                            $class = 'warning';
                                                        } else {
                                                            $status = 'Normal';
                                                            $class = 'success';
                                                        }
                                                        ?>
                                                        <span class="badge bg-<?= $class ?>"><?= $status ?></span>
                                                    </td>
                                                    <td><?= htmlspecialchars($reading['notes']) ?></td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Abnormal Readings Section -->
                <?php if (!empty($abnormalReadings)): ?>
                    <div class="row mt-4">
                        <div class="col-12">
                            <div class="card border-danger">
                                <div class="card-body">
                                    <h5 class="card-title text-danger mb-3">
                                        <i class="ti ti-alert-triangle me-2"></i>Pengukuran Tidak Normal (30 Hari Terakhir)
                                    </h5>
                                    <div class="table-responsive">
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th>Tanggal</th>
                                                    <th>Tekanan Darah</th>
                                                    <th>Rekomendasi</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach ($abnormalReadings as $reading): ?>
                                                    <tr>
                                                        <td><?= date('d/m/Y H:i', strtotime($reading['reading_date'])) ?></td>
                                                        <td><?= $reading['systolic'] ?>/<?= $reading['diastolic'] ?> mmHg</td>
                                                        <td><?= $reading['recommendation_title'] ?></td>
                                                    </tr>
                                                <?php endforeach; ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>

                <!-- Footer -->
                <?php include 'partials/footer.php'; ?>
                <!-- /Footer -->

                <!-- Modals -->
                <?php include 'partials/pencatatan-modals.php'; ?>
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
            var ctx = document.getElementById('bpTrendChart').getContext('2d');
            var trendData = <?= json_encode($readingTrend) ?>;

            var chart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: trendData.map(item => item.date),
                    datasets: [{
                        label: 'Systolic',
                        data: trendData.map(item => item.avg_systolic),
                        borderColor: 'rgb(255, 99, 132)',
                        tension: 0.1
                    }, {
                        label: 'Diastolic',
                        data: trendData.map(item => item.avg_diastolic),
                        borderColor: 'rgb(54, 162, 235)',
                        tension: 0.1
                    }]
                },
                options: {
                    responsive: true,
                    scales: {
                        y: {
                            beginAtZero: false,
                            title: {
                                display: true,
                                text: 'mmHg'
                            }
                        },
                        x: {
                            title: {
                                display: true,
                                text: 'Tanggal'
                            }
                        }
                    }
                }
            });

            // Handle period change
            $('.btn-group button').click(function () {
                $('.btn-group button').removeClass('active');
                $(this).addClass('active');
                var days = $(this).data('period');
                updateChart(days);
            });

            // Form submission handling
            $('#addReadingForm').on('submit', function (e) {
                e.preventDefault();
                $.ajax({
                    url: $(this).attr('action'),
                    type: 'POST',
                    data: $(this).serialize(),
                    dataType: 'json',
                    success: function (response) {
                        if (response.success) {
                            $('#addReadingModal').modal('hide');
                            showResult(response.reading);
                            location.reload();
                        } else {
                            alert(response.message);
                        }
                    }
                });
            });

            function showResult(reading) {
                // Update result modal with reading data
                $('#resultSystolic').text(reading.systolic);
                $('#resultDiastolic').text(reading.diastolic);
                $('#resultPulseRate').text(reading.pulse_rate + ' bpm');
                $('#resultNotes').text(reading.notes || '-');

                // Set status and recommendation
                let status = '';
                let icon = '';
                if (reading.systolic >= 140 || reading.diastolic >= 90) {
                    status = 'Tekanan Darah Tinggi';
                    icon = '⚠️';
                } else if (reading.systolic >= 120 || reading.diastolic >= 80) {
                    status = 'Prehipertensi';
                    icon = '⚡';
                } else {
                    status = 'Normal';
                    icon = '✅';
                }

                $('#resultIcon').text(icon);
                $('#resultTitle').text(status);
                $('#resultRecommendation').text(reading.recommendation_description || '-');

                $('#resultModal').modal('show');
            }
        });
    </script>
</body>


</html>