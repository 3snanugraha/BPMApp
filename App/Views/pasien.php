<?php
require_once __DIR__ . '/../Controllers/AuthController.php';
require_once __DIR__ . '/../Controllers/PasienController.php';
session_start();

$auth = new AuthController();
$auth->checkAuth();

$pasienController = new PasienController();
$patients = $pasienController->getAllPatients();
$totalPatients = count($patients);
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Data Pasien - Sistem Monitoring Tekanan Darah</title>
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
                                        <img src="assets/images/data/data.png" alt="Patient Statistics"
                                            class="img-fluid">
                                    </div>
                                    <div class="col-lg-6">
                                        <h3 class="fw-semibold mb-3">Data Pasien</h3>
                                        <p class="fs-4 mb-4">
                                            Kelola data pasien yang terdaftar dalam sistem monitoring tekanan darah.
                                            Anda dapat menambah, mengubah, dan menghapus data pasien.
                                        </p>

                                        <div class="card bg-primary text-white mb-4">
                                            <div class="card-body d-flex align-items-center">
                                                <i class="ti ti-users fs-6 me-3"></i>
                                                <div>
                                                    <h2 class="text-white mb-0"><?= $totalPatients ?></h2>
                                                    <p class="mb-0">Total Pasien Terdaftar</p>
                                                </div>
                                            </div>
                                        </div>

                                        <button class="btn btn-primary d-flex align-items-center" data-bs-toggle="modal"
                                            data-bs-target="#addPatientModal">
                                            <i class="ti ti-user-plus fs-5 me-2"></i>
                                            <span>Tambah Data Pasien</span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /Information Section -->


                <!-- Custom Datatable Section -->
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="patientTable" class="table table-striped dt-responsive nowrap w-100">
                                        <thead>
                                            <tr>
                                                <th>Nama Lengkap</th>
                                                <th>Tanggal Lahir</th>
                                                <th>Jenis Kelamin</th>
                                                <th>Email</th>
                                                <th>No. Telepon</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($patients as $patient): ?>
                                                <tr>
                                                    <td><?= htmlspecialchars($patient['full_name']) ?></td>
                                                    <td><?= htmlspecialchars($patient['date_of_birth']) ?></td>
                                                    <td><?= htmlspecialchars($patient['gender'] == 'M' ? 'Laki-laki' : 'Perempuan') ?>
                                                    </td>
                                                    <td><?= htmlspecialchars($patient['email']) ?></td>
                                                    <td><?= htmlspecialchars($patient['phone_number']) ?></td>
                                                    <td>
                                                        <button type="button" class="btn btn-info btn-sm view-patient"
                                                            data-bs-toggle="modal" data-bs-target="#viewPatientModal"
                                                            data-patient='<?= json_encode($patient) ?>'>
                                                            <i class="ti ti-eye"></i>
                                                        </button>
                                                        <button type="button" class="btn btn-warning btn-sm edit-patient"
                                                            data-bs-toggle="modal" data-bs-target="#editPatientModal"
                                                            data-patient='<?= json_encode($patient) ?>'>
                                                            <i class="ti ti-edit"></i>
                                                        </button>
                                                        <button type="button" class="btn btn-danger btn-sm delete-patient"
                                                            data-bs-toggle="modal" data-bs-target="#deletePatientModal"
                                                            data-id="<?= $patient['patient_id'] ?>">
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
                <?php include 'partials/pasien-modals.php'; ?>
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
            var table = $('#patientTable').DataTable({
                responsive: true,
                language: {
                    url: 'https://cdn.datatables.net/plug-ins/1.13.7/i18n/id.json'
                }
            });

            // Handle View Patient
            $('.view-patient').on('click', function () {
                var patient = $(this).data('patient');
                $('#view_full_name').text(patient.full_name);
                $('#view_username').text(patient.username);
                $('#view_email').text(patient.email);
                $('#view_date_of_birth').text(patient.date_of_birth);
                $('#view_gender').text(patient.gender == 'M' ? 'Laki-laki' : 'Perempuan');
                $('#view_address').text(patient.address);
                $('#view_phone_number').text(patient.phone_number);
                $('#view_emergency_contact').text(patient.emergency_contact);
                $('#view_emergency_phone').text(patient.emergency_phone);
                $('#view_medical_history').text(patient.medical_history);
            });

            // Handle Edit Patient
            $('.edit-patient').on('click', function () {
                var patient = $(this).data('patient');
                $('#edit_patient_id').val(patient.patient_id);
                $('#edit_email').val(patient.email);
                $('#edit_full_name').val(patient.full_name);
                $('#edit_date_of_birth').val(patient.date_of_birth);
                $('#edit_gender').val(patient.gender);
                $('#edit_address').val(patient.address);
                $('#edit_phone_number').val(patient.phone_number);
                $('#edit_emergency_contact').val(patient.emergency_contact);
                $('#edit_emergency_phone').val(patient.emergency_phone);
                $('#edit_medical_history').val(patient.medical_history);
            });

            // Handle Delete Patient
            $('.delete-patient').on('click', function () {
                var patientId = $(this).data('id');
                $('#delete_patient_id').val(patientId);
            });
        });
    </script>
    <?php if ($_SESSION['role'] === 'patient'): ?>
        <?php include 'partials/notification-script.php'; ?>
    <?php endif; ?>
</body>

</html>