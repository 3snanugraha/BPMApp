<?php
require_once __DIR__ . '/../Controllers/AuthController.php';
require_once __DIR__ . '/../Controllers/PasienController.php';
require_once __DIR__ . '/../Controllers/DokterController.php';
require_once __DIR__ . '/../Controllers/PencatatanController.php';

session_start();

$auth = new AuthController();
$auth->checkAuth(); // Redirect to login if not authenticated

$userRole = $_SESSION['role'];
?>

<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Modernize Free</title>
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
  <script src="assets/libs/apexcharts/dist/apexcharts.min.js"></script>
  <script src="assets/libs/simplebar/dist/simplebar.js"></script>
  <script src="assets/js/dashboard.js"></script>

<?php if ($_SESSION['role'] === 'patient'): ?>
<script>
$(document).ready(function() {
    function loadPatientNotifications() {
        $.ajax({
            url: '../Controllers/ajax/NotifikasiPasienAjax.php',
            type: 'POST',
            data: {
                action: 'getLatestNotifications',
                user_id: '<?= $_SESSION['user_id'] ?>'
            },
            success: function(response) {
                const data = JSON.parse(response);
                
                // Render recommendations
                const recHtml = data.recommendations.map(rec => `
                    <a href="rekomendasi.php" class="message-item d-flex align-items-center border-bottom px-3 py-2">
                        <span class="btn btn-light-info text-info btn-circle">
                            <i class="ti ti-heart-rate-monitor fs-5"></i>
                        </span>
                        <div class="w-75 d-inline-block v-middle ps-3">
                            <h6 class="mb-1 fw-semibold">${rec.title}</h6>
                            <span class="fs-2 text-muted d-block">
                                <i class="ti ti-user me-1"></i>${rec.doctor_name}
                            </span>
                            <span class="fs-2 text-muted">
                                <i class="ti ti-calendar me-1"></i>${new Date(rec.created_at).toLocaleDateString('id-ID')}
                            </span>
                        </div>
                    </a>
                `).join('');
                $('#latest_recommendations').html(recHtml || '<p class="text-center p-3">Tidak ada rekomendasi baru</p>');

                // Render prescriptions
                const presHtml = data.prescriptions.map(pres => `
                    <a href="pengobatan.php" class="message-item d-flex align-items-center border-bottom px-3 py-2">
                        <span class="btn btn-light-warning text-warning btn-circle">
                            <i class="ti ti-medicine fs-5"></i>
                        </span>
                        <div class="w-75 d-inline-block v-middle ps-3">
                            <h6 class="mb-1 fw-semibold">${pres.medication_name}</h6>
                            <span class="fs-2 text-muted d-block">
                                <i class="ti ti-user me-1"></i>${pres.doctor_name}
                            </span>
                            <span class="fs-2 text-muted">
                                <i class="ti ti-calendar me-1"></i>${new Date(pres.created_at).toLocaleDateString('id-ID')}
                            </span>
                        </div>
                    </a>
                `).join('');
                $('#latest_prescriptions').html(presHtml || '<p class="text-center p-3">Tidak ada pengobatan baru</p>');
            }
        });
    }

    // Initial load and auto refresh
    loadPatientNotifications();
    setInterval(loadPatientNotifications, 30000);
});
</script>
<?php endif; ?>
</body>

</html>