<?php
date_default_timezone_set('Asia/Jakarta');
require_once __DIR__ . '/../Controllers/AuthController.php';
require_once __DIR__ . '/../Controllers/PasienController.php';
require_once __DIR__ . '/../Controllers/DokterController.php';
require_once __DIR__ . '/../Controllers/PencatatanController.php';
require_once __DIR__ . '/../Controllers/PengobatanController.php';
require_once __DIR__ . '/../Controllers/RekomendasiController.php';
require_once __DIR__ . '/../Controllers/AdminController.php';

session_start();

$auth = new AuthController();
$auth->checkAuth(); // Redirect to login if not authenticated

$userRole = $_SESSION['role'];

// Initialize controllers based on role
if ($userRole === 'patient') {
    $pasienController = new PasienController();
    $pengobatanController = new PengobatanController();
    $rekomendasiController = new RekomendasiController();

    // Get patient data
    $patientId = $pasienController->getPatientIdByUserId($_SESSION['user_id']);
    $patientProfile = $pasienController->getPatientById($patientId);
    $latestReading = $pasienController->getLatestReading($patientId);
    $totalReadings = $pasienController->getTotalReadings($patientId);
    $recentReadings = $pasienController->getPatientBloodPressureReadings($patientId);

    // Dashboard-specific data retrieval
    $activeMedications = $pengobatanController->getDashboardMedications($patientId);
    $recommendations = $rekomendasiController->getDashboardRecommendations($patientId);
} elseif ($userRole === 'doctor') {
    $dokterController = new DokterController();
    $doctorProfile = $dokterController->getDoctorProfile($_SESSION['user_id']);
    $doctorId = $doctorProfile['doctor_id'];

    // Get statistics
    $totalPatients = $dokterController->getTotalPatients($doctorId);
    $activeCases = $dokterController->getActiveCases($doctorId);
    $activemedications = $dokterController->getActiveMedications($doctorId);
    $totalRecommendations = $dokterController->getTotalRecommendations($doctorId);

    // Get recent data
    $recentPatients = $dokterController->getRecentPatients($doctorId);
    $recentRecommendations = $dokterController->getRecentRecommendations($doctorId);
} elseif ($userRole === 'admin') {
    $adminController = new AdminController();

    // Get statistics
    $totalUsers = $adminController->getTotalUsers();
    $totalDoctors = $adminController->getTotalDoctors();
    $totalPatients = $adminController->getTotalPatients();
    $totalReadings = $adminController->getTotalReadings();
    $totalMedications = $adminController->getTotalMedications();

    // Get recent activities
    $recentActivities = $adminController->getRecentActivities();
}

?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dashboard - Sistem Monitoring Tekanan Darah</title>
    <link rel="shortcut icon" type="image/png" href="assets/images/logos/favicon.png" />
    <link rel="stylesheet" href="assets/css/styles.min.css" />
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
                <!-- Konten Dinamis -->
                <?php
                // Load appropriate dashboard based on role
                switch ($userRole) {
                    case 'admin':
                        include 'partials/admin-dashboard.php';
                        break;
                    case 'doctor':
                        include 'partials/dokter-dashboard.php';
                        break;
                    case 'patient':
                        include 'partials/pasien-dashboard.php';
                        break;
                }
                ?>
                <!-- Footer -->
                <?php include 'partials/footer.php'; ?>
                <!-- /Footer -->
            </div>
        </div>
    </div>
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