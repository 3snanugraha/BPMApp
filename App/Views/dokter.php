<?php
require_once __DIR__ . '/../Controllers/AuthController.php';
require_once __DIR__ . '/../Controllers/DokterController.php';
session_start();

$auth = new AuthController();
$auth->checkAuth();

$dokterController = new DokterController();
$doctors = $dokterController->getAllDoctors();
$totalDoctors = count($doctors);
?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Data Dokter - Sistem Monitoring Tekanan Darah</title>
    <link rel="shortcut icon" type="image/png" href="assets/images/logos/favicon.png" />
    <link rel="stylesheet" href="assets/css/styles.min.css" />
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.bootstrap5.min.css">
</head>

<body>
    <!--  Body Wrapper -->
    <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full"
        data-sidebar-position="fixed" data-header-position="fixed">
        <!-- Sidebar Start -->
        <?php include 'partials/sidebar.php'; ?>
        <!--  Sidebar End -->
        <!--  Main wrapper -->
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
                                        <img src="assets/images/data/data-dashboard.png" alt="Doctor Statistics"
                                            class="img-fluid">
                                    </div>
                                    <div class="col-lg-6">
                                        <h3 class="fw-semibold mb-3">Data Dokter</h3>
                                        <p class="fs-4 mb-4">
                                            Kelola data dokter yang terdaftar dalam sistem monitoring tekanan darah.
                                            Anda dapat menambah, mengubah, dan menghapus data dokter.
                                        </p>

                                        <div class="card bg-primary text-white mb-4">
                                            <div class="card-body d-flex align-items-center">
                                                <i class="ti ti-users fs-6 me-3"></i>
                                                <div>
                                                    <h2 class="text-white mb-0"><?= $totalDoctors ?></h2>
                                                    <p class="mb-0">Total Dokter Terdaftar</p>
                                                </div>
                                            </div>
                                        </div>

                                        <button class="btn btn-primary d-flex align-items-center" data-bs-toggle="modal"
                                            data-bs-target="#addDoctorModal">
                                            <i class="ti ti-user-plus fs-5 me-2"></i>
                                            <span>Tambah Data Dokter</span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /Information Section -->

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

                <!-- Custom Datatable Section -->
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="doctorTable" class="table table-striped dt-responsive nowrap w-100">
                                        <thead>
                                            <tr>
                                                <th>Nama Lengkap</th>
                                                <th>Spesialisasi</th>
                                                <th>No. Lisensi</th>
                                                <th>Email</th>
                                                <th>No. Telepon</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($doctors as $doctor): ?>
                                                <tr>
                                                    <td><?= htmlspecialchars($doctor['full_name']) ?></td>
                                                    <td><?= htmlspecialchars($doctor['specialization']) ?></td>
                                                    <td><?= htmlspecialchars($doctor['license_number']) ?></td>
                                                    <td><?= htmlspecialchars($doctor['email']) ?></td>
                                                    <td><?= htmlspecialchars($doctor['phone_number']) ?></td>
                                                    <td>
                                                        <button type="button" class="btn btn-info btn-sm view-doctor"
                                                            data-bs-toggle="modal" data-bs-target="#viewDoctorModal"
                                                            data-doctor='<?= json_encode($doctor) ?>'>
                                                            <i class="ti ti-eye"></i>
                                                        </button>
                                                        <button type="button" class="btn btn-warning btn-sm edit-doctor"
                                                            data-bs-toggle="modal" data-bs-target="#editDoctorModal"
                                                            data-doctor='<?= json_encode($doctor) ?>'>
                                                            <i class="ti ti-edit"></i>
                                                        </button>
                                                        <button type="button" class="btn btn-danger btn-sm delete-doctor"
                                                            data-bs-toggle="modal" data-bs-target="#deleteDoctorModal"
                                                            data-id="<?= $doctor['doctor_id'] ?>">
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
                <?php include 'partials/dokter-modals.php'; ?>
                <!-- /Modals -->
            </div>
        </div>
    </div>
    <script src="assets/libs/jquery/dist/jquery.min.js"></script>
    <script src="assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/sidebarmenu.js"></script>
    <script src="assets/js/app.min.js"></script>
    <script src="assets/libs/apexcharts/dist/apexcharts.min.js"></script>
    <script src="assets/libs/simplebar/dist/simplebar.js"></script>
    <script src="assets/js/dashboard.js"></script>

    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.5.0/js/responsive.bootstrap5.min.js"></script>

    <script>
        $(document).ready(function () {
            // Initialize DataTable
            var table = $('#doctorTable').DataTable({
                responsive: true,
                language: {
                    url: 'https://cdn.datatables.net/plug-ins/1.13.7/i18n/id.json'
                }
            });

            // Handle View Doctor
            $('.view-doctor').on('click', function () {
                var doctor = $(this).data('doctor');
                $('#view_full_name').text(doctor.full_name);
                $('#view_username').text(doctor.username);
                $('#view_email').text(doctor.email);
                $('#view_specialization').text(doctor.specialization);
                $('#view_license_number').text(doctor.license_number);
                $('#view_phone_number').text(doctor.phone_number);
            });

            // Handle Edit Doctor
            $('.edit-doctor').on('click', function () {
                var doctor = $(this).data('doctor');
                $('#edit_doctor_id').val(doctor.doctor_id);
                $('#edit_email').val(doctor.email);
                $('#edit_full_name').val(doctor.full_name);
                $('#edit_specialization').val(doctor.specialization);
                $('#edit_license_number').val(doctor.license_number);
                $('#edit_phone_number').val(doctor.phone_number);
            });

            // Handle Delete Doctor
            $('.delete-doctor').on('click', function () {
                var doctorId = $(this).data('id');
                $('#delete_doctor_id').val(doctorId);
            });
        });
    </script>

    <?php if ($_SESSION['role'] === 'patient'): ?>
        <?php include 'partials/notification-script.php'; ?>
    <?php endif; ?>
</body>

</html>