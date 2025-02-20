<?php
require_once __DIR__ . '/../Controllers/AuthController.php';
require_once __DIR__ . '/../Controllers/PencatatanController.php';

session_start();

$auth = new AuthController();
$auth->checkAuth();

$pencatatanController = new PencatatanController();
$readings = $pencatatanController->getReadings();
$totalReadings = count($readings);
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
                                        <img src="assets/images/data/data.png" alt="Blood Pressure Statistics"
                                            class="img-fluid">
                                    </div>
                                    <div class="col-lg-6">
                                        <h3 class="fw-semibold mb-3">Pencatatan Tekanan Darah</h3>
                                        <p class="fs-4 mb-4">
                                            Kelola data pencatatan tekanan darah.
                                            <?php if ($_SESSION['role'] === 'patient'): ?>
                                                Anda dapat mencatat, mengubah, dan melihat riwayat tekanan darah Anda.
                                            <?php else: ?>
                                                Anda dapat mengelola pencatatan tekanan darah semua pasien.
                                            <?php endif; ?>
                                        </p>

                                        <div class="card bg-primary text-white mb-4">
                                            <div class="card-body d-flex align-items-center">
                                                <i class="ti ti-heart-rate-monitor fs-6 me-3"></i>
                                                <div>
                                                    <h2 class="text-white mb-0"><?= $totalReadings ?></h2>
                                                    <p class="mb-0">Total Pencatatan</p>
                                                </div>
                                            </div>
                                        </div>

                                        <button class="btn btn-primary d-flex align-items-center" data-bs-toggle="modal"
                                            data-bs-target="#addReadingModal">
                                            <i class="ti ti-plus fs-5 me-2"></i>
                                            <span>Tambah Pencatatan</span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Custom Datatable Section -->
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="readingTable" class="table table-striped dt-responsive nowrap w-100">
                                        <thead>
                                            <tr>
                                                <?php if ($_SESSION['role'] !== 'patient'): ?>
                                                    <th>Pasien</th>
                                                <?php endif; ?>
                                                <th>Systolic</th>
                                                <th>Diastolic</th>
                                                <th>Detak Jantung</th>
                                                <th>Tanggal</th>
                                                <th>Catatan</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($readings as $reading): ?>
                                                <tr>
                                                    <?php if ($_SESSION['role'] !== 'patient'): ?>
                                                        <td><?= htmlspecialchars($reading['patient_name']) ?></td>
                                                    <?php endif; ?>
                                                    <td><?= htmlspecialchars($reading['systolic']) ?></td>
                                                    <td><?= htmlspecialchars($reading['diastolic']) ?></td>
                                                    <td><?= htmlspecialchars($reading['pulse_rate']) ?></td>
                                                    <td><?= date('d/m/Y H:i', strtotime($reading['reading_date'])) ?></td>
                                                    <td><?= htmlspecialchars($reading['notes']) ?></td>
                                                    <td>
                                                        <button type="button" class="btn btn-info btn-sm view-reading"
                                                            data-bs-toggle="modal" data-bs-target="#viewReadingModal"
                                                            data-reading='<?= json_encode($reading) ?>'>
                                                            <i class="ti ti-eye"></i>
                                                        </button>
                                                        <button type="button" class="btn btn-warning btn-sm edit-reading"
                                                            data-bs-toggle="modal" data-bs-target="#editReadingModal"
                                                            data-reading='<?= json_encode($reading) ?>'>
                                                            <i class="ti ti-edit"></i>
                                                        </button>
                                                        <button type="button" class="btn btn-danger btn-sm delete-reading"
                                                            data-bs-toggle="modal" data-bs-target="#deleteReadingModal"
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

                <?php include 'partials/footer.php'; ?>
                <?php include 'partials/pencatatan-modals.php'; ?>
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
            var table = $('#readingTable').DataTable({
                responsive: true,
                language: {
                    url: 'https://cdn.datatables.net/plug-ins/1.13.7/i18n/id.json'
                }
            });

            $('.view-reading').on('click', function () {
                var reading = $(this).data('reading');
                $('#view_patient_name').text(reading.patient_name);
                $('#view_blood_pressure').text(reading.systolic + '/' + reading.diastolic + ' mmHg');
                $('#view_pulse_rate').text(reading.pulse_rate + ' bpm');
                $('#view_reading_date').text(new Date(reading.reading_date).toLocaleString());
                $('#view_notes').text(reading.notes);
            });

            $('.edit-reading').on('click', function () {
                var reading = $(this).data('reading');
                $('#edit_reading_id').val(reading.reading_id);
                $('#edit_systolic').val(reading.systolic);
                $('#edit_diastolic').val(reading.diastolic);
                $('#edit_pulse_rate').val(reading.pulse_rate);
                $('#edit_notes').val(reading.notes);
            });

            $('.delete-reading').on('click', function () {
                var readingId = $(this).data('id');
                $('#delete_reading_id').val(readingId);
            });
        });
    </script>

    <?php if ($_SESSION['role'] === 'patient'): ?>
        <?php include 'partials/notification-script.php'; ?>
    <?php endif; ?>
</body>

</html>