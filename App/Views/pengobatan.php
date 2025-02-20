<?php
require_once __DIR__ . '/../Controllers/AuthController.php';
require_once __DIR__ . '/../Controllers/PengobatanController.php';
session_start();

$auth = new AuthController();
$auth->checkAuth();

$pengobatanController = new PengobatanController();
$prescriptions = $pengobatanController->getAllPrescriptions();
$totalPrescriptions = count($prescriptions);
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Data Pengobatan - Sistem Monitoring Tekanan Darah</title>
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
                                        <img src="assets/images/data/data.png" alt="Prescription Statistics"
                                            class="img-fluid">
                                    </div>
                                    <div class="col-lg-6">
                                        <h3 class="fw-semibold mb-3">Pengobatan Pasien</h3>
                                        <p class="fs-4 mb-4">
                                            Riwayat pengobatan berdasarkan hasil pengukuran tekanan darah pasien.
                                            <?php if (in_array($_SESSION['role'], ['admin', 'doctor'])): ?>
                                                Anda dapat memberikan pengobatan untuk setiap hasil pengukuran.
                                            <?php endif; ?>
                                        </p>

                                        <div class="card bg-primary text-white mb-4">
                                            <div class="card-body d-flex align-items-center">
                                                <i class="ti ti-medicine fs-6 me-3"></i>
                                                <div>
                                                    <h2 class="text-white mb-0"><?= $totalPrescriptions ?></h2>
                                                    <p class="mb-0">Total Pengobatan Diberikan</p>
                                                </div>
                                            </div>
                                        </div>

                                        <?php if (in_array($_SESSION['role'], ['admin', 'doctor'])): ?>
                                            <button type="button" class="btn btn-primary d-flex align-items-center"
                                                data-bs-toggle="modal" data-bs-target="#addPrescriptionModal"
                                                style="width: fit-content;">
                                                <i class="ti ti-plus fs-5 me-2"></i>
                                                <span>Berikan Pengobatan</span>
                                            </button>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Prescriptions Table Section -->
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="prescriptionTable"
                                        class="table table-striped dt-responsive nowrap w-100">
                                        <thead>
                                            <tr>
                                                <th>Pasien</th>
                                                <th>Obat</th>
                                                <th>Dosis</th>
                                                <th>Frekuensi</th>
                                                <th>Periode</th>
                                                <th>Catatan</th>
                                                <th>Dokter</th>
                                                <?php if (in_array($_SESSION['role'], ['admin', 'doctor'])): ?>
                                                    <th>Aksi</th>
                                                <?php endif; ?>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($prescriptions as $prescription): ?>
                                                <tr>
                                                    <td><?= htmlspecialchars($prescription['patient_name']) ?></td>
                                                    <td><?= htmlspecialchars($prescription['medication_name']) ?></td>
                                                    <td><?= htmlspecialchars($prescription['dosage']) ?></td>
                                                    <td><?= htmlspecialchars($prescription['frequency']) ?></td>
                                                    <td>
                                                        <?= date('d/m/Y', strtotime($prescription['start_date'])) ?>
                                                        s/d
                                                        <?= date('d/m/Y', strtotime($prescription['end_date'])) ?>
                                                    </td>
                                                    <td><?= htmlspecialchars($prescription['notes']) ?></td>
                                                    <td><?= htmlspecialchars($prescription['doctor_name']) ?></td>
                                                    <?php if (in_array($_SESSION['role'], ['admin', 'doctor'])): ?>
                                                        <td>
                                                            <button type="button"
                                                                class="btn btn-info btn-sm view-prescription me-1"
                                                                data-prescription='<?= htmlspecialchars(json_encode($prescription), ENT_QUOTES, 'UTF-8') ?>'>
                                                                <i class="ti ti-eye"></i>
                                                            </button>
                                                            <button type="button"
                                                                class="btn btn-warning btn-sm edit-prescription me-1"
                                                                data-prescription='<?= htmlspecialchars(json_encode($prescription), ENT_QUOTES, 'UTF-8') ?>'>
                                                                <i class="ti ti-edit"></i>
                                                            </button>
                                                            <button type="button"
                                                                class="btn btn-danger btn-sm delete-prescription"
                                                                data-id="<?= $prescription['patient_medication_id'] ?>">
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
                <!-- End Table -->
                <?php include 'partials/footer.php'; ?>
                <?php include 'partials/pengobatan-modals.php'; ?>
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
        $(document).ready(function () {
            // Initialize DataTable
            var table = $('#prescriptionTable').DataTable({
                responsive: true,
                language: {
                    url: 'https://cdn.datatables.net/plug-ins/1.13.7/i18n/id.json'
                }
            });

            // Initialize Select2 for Patient Selection
            $('#patient_selector').on('change', function () {
                const patientId = $(this).val();
                if (patientId) {
                    $.ajax({
                        url: '../Controllers/ajax/PengobatanAjax.php',
                        type: 'POST',
                        data: {
                            action: 'getPatientReadings',
                            patient_id: patientId
                        },
                        success: function (response) {
                            const readings = JSON.parse(response);
                            displayReadings(readings);
                            $('#readings_section').show();
                            $('#addPrescriptionForm').show(); // Show form immediately
                        }
                    });
                } else {
                    $('#readings_section, #addPrescriptionForm').hide();
                }
            });

            // Initialize Select2 for Medication Selection
            $('#medication_selector').select2({
                theme: 'bootstrap-5',
                dropdownParent: $('#addPrescriptionModal'),
                ajax: {
                    url: '../Controllers/ajax/PengobatanAjax.php',
                    type: 'POST',
                    dataType: 'json',
                    delay: 250,
                    data: function (params) {
                        return {
                            action: 'getMedications',
                            search: params.term
                        };
                    },
                    processResults: function (data) {
                        return {
                            results: data.map(function (item) {
                                return {
                                    id: item.medication_id,
                                    text: item.name + ' (' + item.dosage_form + ')'
                                };
                            })
                        };
                    },
                    cache: true
                },
                placeholder: 'Pilih obat...',
                allowClear: true
            });

            // Handle patient selection
            $('#patient_selector').select2({
                theme: 'bootstrap-5',
                dropdownParent: $('#addPrescriptionModal'),
                ajax: {
                    url: '../Controllers/ajax/PengobatanAjax.php',
                    type: 'POST',
                    dataType: 'json',
                    delay: 250,
                    data: function (params) {
                        return {
                            action: 'getPatients',
                            search: params.term || ''
                        };
                    },
                    processResults: function (data) {
                        return {
                            results: data.map(item => ({
                                id: item.patient_id,
                                text: item.full_name
                            }))
                        };
                    },
                    cache: true
                },
                placeholder: 'Pilih pasien...',
                allowClear: true,
                width: '100%'
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
                $('#addPrescriptionForm').show();
            });

            function displayReadings(readings) {
                let html = '';
                readings.forEach(reading => {
                    html += `
                <tr>
                    <td>${new Date(reading.reading_date).toLocaleString('id-ID')}</td>
                    <td>${reading.systolic}</td>
                    <td>${reading.diastolic}</td>
                    <td>${reading.pulse_rate}</td>
                </tr>
            `;
                });
                $('#readings_table_body').html(html);
            }


            // Handle View Prescription
            $(document).on('click', '.view-prescription', function () {
                const prescription = $(this).data('prescription');
                $('#view_patient_name').text(prescription.patient_name);
                $('#view_medication_name').text(prescription.medication_name);
                $('#view_dosage').text(prescription.dosage);
                $('#view_frequency').text(prescription.frequency);
                $('#view_start_date').text(new Date(prescription.start_date).toLocaleDateString('id-ID'));
                $('#view_end_date').text(new Date(prescription.end_date).toLocaleDateString('id-ID'));
                $('#view_notes').text(prescription.notes);
                $('#view_doctor_name').text(prescription.doctor_name);
                $('#viewPrescriptionModal').modal('show');
            });

            // Handle Edit Prescription
            $(document).on('click', '.edit-prescription', function () {
                const prescription = $(this).data('prescription');
                $('#edit_prescription_id').val(prescription.patient_medication_id);
                $('#edit_dosage').val(prescription.dosage);
                $('#edit_frequency').val(prescription.frequency);
                $('#edit_start_date').val(prescription.start_date.split(' ')[0]);
                $('#edit_end_date').val(prescription.end_date.split(' ')[0]);
                $('#edit_notes').val(prescription.notes);
                $('#editPrescriptionModal').modal('show');
            });

            // Handle Delete Prescription
            $(document).on('click', '.delete-prescription', function () {
                if (confirm('Apakah Anda yakin ingin menghapus pengobatan ini?')) {
                    const prescriptionId = $(this).data('id');
                    const form = $('<form>', {
                        'method': 'POST',
                        'action': '../Controllers/PengobatanController.php'
                    });

                    form.append($('<input>', {
                        'type': 'hidden',
                        'name': 'action',
                        'value': 'delete_prescription'
                    }));

                    form.append($('<input>', {
                        'type': 'hidden',
                        'name': 'prescription_id',
                        'value': prescriptionId
                    }));

                    $('body').append(form);
                    form.submit();
                }
            });

            // Reset form when modal is closed
            $('#addPrescriptionModal').on('hidden.bs.modal', function () {
                $('#patient_selector').val(null).trigger('change');
                $('#medication_selector').val(null).trigger('change');
                $('#readings_section, #addPrescriptionForm').hide();
                $('#addPrescriptionForm')[0].reset();
            });
        });
    </script>

    <?php if ($_SESSION['role'] === 'patient'): ?>
        <?php include 'partials/notification-script.php'; ?>
    <?php endif; ?>
</body>

</html>