<?php
require_once __DIR__ . '/../Controllers/AuthController.php';
require_once __DIR__ . '/../Controllers/ProfileController.php';

session_start();

$auth = new AuthController();
$auth->checkAuth();

$profileController = new ProfileController();
$profileData = $profileController->getProfileData();
$profileStats = $profileController->getProfileStats();
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Profil - Sistem Monitoring Tekanan Darah</title>
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
                <!-- Profile Header -->
                <div class="row">
                    <div class="col-12">
                        <div class="card w-100">
                            <div class="card-body bg-light-primary">
                                <div class="row align-items-center">
                                    <div class="col-lg-4 text-center">
                                        <img src="assets/images/profile/user-1.jpg" alt="Profile" class="rounded-circle"
                                            width="150">
                                    </div>
                                    <div class="col-lg-8">
                                        <h3 class="fw-semibold mb-3">
                                            <?= htmlspecialchars($profileData['full_name'] ?? $profileData['username']) ?>
                                        </h3>
                                        <p class="fs-4 mb-4">
                                            <?php if ($_SESSION['role'] === 'doctor'): ?>
                                                <?= htmlspecialchars($profileData['specialization']) ?>
                                            <?php elseif ($_SESSION['role'] === 'patient'): ?>
                                                Pasien
                                            <?php else: ?>
                                                Administrator
                                            <?php endif; ?>
                                        </p>

                                        <!-- Role-specific Stats -->
                                        <div class="row">
                                            <?php if ($_SESSION['role'] === 'doctor'): ?>
                                                <div class="col-md-6">
                                                    <div class="card bg-primary text-white mb-3">
                                                        <div class="card-body">
                                                            <h5>Total Pasien</h5>
                                                            <h3><?= $profileStats['total_patients'] ?></h3>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="card bg-success text-white mb-3">
                                                        <div class="card-body">
                                                            <h5>Total Rekomendasi</h5>
                                                            <h3><?= $profileStats['total_recommendations'] ?></h3>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php elseif ($_SESSION['role'] === 'patient'): ?>
                                                <div class="col-md-6">
                                                    <div class="card bg-primary text-white mb-3">
                                                        <div class="card-body">
                                                            <h5>Total Pencatatan</h5>
                                                            <h3><?= $profileStats['total_readings'] ?></h3>
                                                        </div>
                                                    </div>
                                                </div>
                                                <?php if (isset($profileStats['latest_reading']) && $profileStats['latest_reading']): ?>
                                                    <div class="col-md-6">
                                                        <div class="card bg-info text-white mb-3">
                                                            <div class="card-body">
                                                                <h5>Tekanan Darah Terakhir</h5>
                                                                <h3>
                                                                    <?= $profileStats['latest_reading']['systolic'] ?? '-' ?>/<?= $profileStats['latest_reading']['diastolic'] ?? '-' ?>
                                                                </h3>
                                                                <small>
                                                                    <?= isset($profileStats['latest_reading']['reading_date']) ?
                                                                        date('d/m/Y H:i', strtotime($profileStats['latest_reading']['reading_date'])) :
                                                                        '-'
                                                                        ?>
                                                                </small>
                                                            </div>
                                                        </div>
                                                    </div>
                                                <?php endif; ?>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Profile Details -->
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title fw-semibold mb-4">Informasi Profil</h5>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label fw-semibold">Email:</label>
                                            <p><?= htmlspecialchars($profileData['email']) ?></p>
                                        </div>
                                        <?php if ($_SESSION['role'] === 'doctor'): ?>
                                            <div class="mb-3">
                                                <label class="form-label fw-semibold">Nomor Lisensi:</label>
                                                <p><?= htmlspecialchars($profileData['license_number']) ?></p>
                                            </div>
                                        <?php endif; ?>
                                        <?php if ($_SESSION['role'] === 'patient'): ?>
                                            <div class="mb-3">
                                                <label class="form-label fw-semibold">Tanggal Lahir:</label>
                                                <p><?= date('d/m/Y', strtotime($profileData['date_of_birth'])) ?></p>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label fw-semibold">Jenis Kelamin:</label>
                                                <p><?= $profileData['gender'] === 'M' ? 'Laki-laki' : 'Perempuan' ?></p>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                    <div class="col-md-6">
                                        <?php if (in_array($_SESSION['role'], ['doctor', 'patient'])): ?>
                                            <div class="mb-3">
                                                <label class="form-label fw-semibold">Nomor Telepon:</label>
                                                <p><?= htmlspecialchars($profileData['phone_number']) ?></p>
                                            </div>
                                        <?php endif; ?>
                                        <?php if ($_SESSION['role'] === 'patient'): ?>
                                            <div class="mb-3">
                                                <label class="form-label fw-semibold">Alamat:</label>
                                                <p><?= htmlspecialchars($profileData['address']) ?></p>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label fw-semibold">Kontak Darurat:</label>
                                                <p><?= htmlspecialchars($profileData['emergency_contact']) ?>
                                                    (<?= htmlspecialchars($profileData['emergency_phone']) ?>)</p>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>

                                <div class="mt-4">
                                    <button type="button" class="btn btn-primary me-2" data-bs-toggle="modal"
                                        data-bs-target="#editProfileModal">
                                        <i class="ti ti-edit me-1"></i> Edit Profil
                                    </button>
                                    <button type="button" class="btn btn-warning" data-bs-toggle="modal"
                                        data-bs-target="#changePasswordModal">
                                        <i class="ti ti-key me-1"></i> Ubah Password
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <?php include 'partials/footer.php'; ?>
            </div>
        </div>
    </div>

    <!-- Include Modals -->
    <?php include 'partials/profile-modals.php'; ?>

    <!-- Scripts -->
    <script src="assets/libs/jquery/dist/jquery.min.js"></script>
    <script src="assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/sidebarmenu.js"></script>
    <script src="assets/js/app.min.js"></script>
    <script src="assets/libs/simplebar/dist/simplebar.js"></script>

    <?php if ($_SESSION['role'] === 'patient'): ?>
        <?php include 'partials/notification-script.php'; ?>
    <?php endif; ?>
</body>

</html>