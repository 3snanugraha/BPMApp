<?php
require_once __DIR__ . '/../Controllers/AuthController.php';
require_once __DIR__ . '/../Controllers/ObatObatanController.php';
session_start();

$auth = new AuthController();
$auth->checkAuth();

$obatController = new ObatObatanController();
$medications = $obatController->getAllMedications();
$totalMedications = count($medications);
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Data Obat - Sistem Monitoring Tekanan Darah</title>
    <link rel="shortcut icon" type="image/png" href="assets/images/logos/favicon.png" />
    <link rel="stylesheet" href="assets/css/styles.min.css" />
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.bootstrap5.min.css">
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
                                        <img src="assets/images/data/data.png" alt="Medication Statistics"
                                            class="img-fluid">
                                    </div>
                                    <div class="col-lg-6">
                                        <h3 class="fw-semibold mb-3">Data Obat</h3>
                                        <p class="fs-4 mb-4">
                                            Kelola data obat yang tersedia dalam sistem monitoring tekanan darah.
                                            Anda dapat menambah, mengubah, dan menghapus data obat.
                                        </p>

                                        <div class="card bg-primary text-white mb-4">
                                            <div class="card-body d-flex align-items-center">
                                                <i class="ti ti-pills fs-6 me-3"></i>
                                                <div>
                                                    <h2 class="text-white mb-0"><?= $totalMedications ?></h2>
                                                    <p class="mb-0">Total Obat Terdaftar</p>
                                                </div>
                                            </div>
                                        </div>

                                        <button class="btn btn-primary d-flex align-items-center" data-bs-toggle="modal"
                                            data-bs-target="#addMedicationModal">
                                            <i class="ti ti-plus fs-5 me-2"></i>
                                            <span>Tambah Data Obat</span>
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
                                    <table id="medicationTable" class="table table-striped dt-responsive nowrap w-100">
                                        <thead>
                                            <tr>
                                                <th>Nama Obat</th>
                                                <th>Bentuk Sediaan</th>
                                                <th>Deskripsi</th>
                                                <th>Dibuat Oleh</th>
                                                <th>Tanggal Dibuat</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($medications as $medication): ?>
                                                <tr>
                                                    <td><?= htmlspecialchars($medication['name']) ?></td>
                                                    <td><?= htmlspecialchars($medication['dosage_form']) ?></td>
                                                    <td><?= htmlspecialchars($medication['description']) ?></td>
                                                    <td><?= htmlspecialchars($medication['created_by_name']) ?></td>
                                                    <td><?= htmlspecialchars($medication['created_at']) ?></td>
                                                    <td>
                                                        <button type="button" class="btn btn-info btn-sm view-medication"
                                                            data-bs-toggle="modal" data-bs-target="#viewMedicationModal"
                                                            data-medication='<?= json_encode($medication) ?>'>
                                                            <i class="ti ti-eye"></i>
                                                        </button>
                                                        <button type="button" class="btn btn-warning btn-sm edit-medication"
                                                            data-bs-toggle="modal" data-bs-target="#editMedicationModal"
                                                            data-medication='<?= json_encode($medication) ?>'>
                                                            <i class="ti ti-edit"></i>
                                                        </button>
                                                        <button type="button"
                                                            class="btn btn-danger btn-sm delete-medication"
                                                            data-bs-toggle="modal" data-bs-target="#deleteMedicationModal"
                                                            data-id="<?= $medication['medication_id'] ?>">
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
                <?php include 'partials/obat-modals.php'; ?>
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

        // View medication details
        $(document).on('click', '.view-medication', function () {
            const medication = $(this).data('medication');
            $('#view_name').text(medication.name);
            $('#view_dosage_form').text(medication.dosage_form);
            $('#view_description').text(medication.description);
            $('#view_created_by').text(medication.created_by_name);
            $('#view_created_at').text(new Date(medication.created_at).toLocaleString('id-ID'));
            $('#viewMedicationModal').modal('show');
        });

        // Edit medication
        $(document).on('click', '.edit-medication', function () {
            const medication = $(this).data('medication');
            $('#edit_medication_id').val(medication.medication_id);
            $('#edit_name').val(medication.name);
            $('#edit_dosage_form').val(medication.dosage_form);
            $('#edit_description').val(medication.description);
            $('#editMedicationModal').modal('show');
        });

        // Delete medication
        $(document).on('click', '.delete-medication', function () {
            if (confirm('Apakah Anda yakin ingin menghapus obat ini?')) {
                const medicationId = $(this).data('id');
                const form = $('<form>', {
                    'method': 'POST',
                    'action': '../Controllers/ObatObatanController.php'
                });

                form.append($('<input>', {
                    'type': 'hidden',
                    'name': 'action',
                    'value': 'delete_medication'
                }));

                form.append($('<input>', {
                    'type': 'hidden',
                    'name': 'medication_id',
                    'value': medicationId
                }));

                $('body').append(form);
                form.submit();
            }
        });


        $(document).ready(function () {
            // Initialize DataTable
            var table = $('#medicationTable').DataTable({
                responsive: true,
                language: {
                    url: 'https://cdn.datatables.net/plug-ins/1.13.7/i18n/id.json'
                }
            });
        });
    </script>
    <?php if ($_SESSION['role'] === 'patient'): ?>
        <?php include 'partials/notification-script.php'; ?>
    <?php endif; ?>
</body>

</html>