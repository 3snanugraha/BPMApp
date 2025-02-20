<?php
require_once __DIR__ . '/../Controllers/AuthController.php';
session_start();

$auth = new AuthController();
$auth->checkLoggedIn();
?>
<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Sistem Monitoring Tekanan Darah</title>
  <link rel="shortcut icon" type="image/png" href="assets/images/logos/favicon.png" />
  <link rel="stylesheet" href="assets/css/styles.min.css" />
</head>

<body>
  <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full"
    data-sidebar-position="fixed" data-header-position="fixed">
    <div
      class="position-relative overflow-hidden radial-gradient min-vh-100 d-flex align-items-center justify-content-center">
      <div class="d-flex align-items-center justify-content-center w-100">
        <div class="row justify-content-center w-100">
          <div class="col-md-8 col-lg-6 col-xxl-3">
            <div class="card mb-0">
              <div class="card-body">
                <a href="./index.html" class="text-nowrap logo-img text-center d-block py-3 w-100">
                  <img src="assets/images/logos/bpm_logo.png" width="180" alt="">
                </a>
                <p class="text-center">Sistem Monitoring Tekanan Darah</p>
                <?php if (isset($_SESSION['error'])): ?>
                  <div class="alert alert-danger"><?= $_SESSION['error'];
                  unset($_SESSION['error']); ?></div>
                <?php endif; ?>
                <?php if (isset($_SESSION['success'])): ?>
                  <div class="alert alert-success"><?= $_SESSION['success'];
                  unset($_SESSION['success']); ?></div>
                <?php endif; ?>
                <form action="../Controllers/AuthController.php" method="POST">
                  <input type="hidden" name="action" value="login">
                  <div class="mb-3">
                    <label for="username" class="form-label">Username</label>
                    <input type="text" name="username" class="form-control" id="username" required>
                  </div>
                  <div class="mb-4">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" name="password" class="form-control" id="password" required>
                  </div>
                  <div class="d-flex align-items-center justify-content-between mb-4">
                    <div class="form-check">
                      <input class="form-check-input primary" type="checkbox" value="" id="remember" name="remember">
                      <label class="form-check-label text-dark" for="remember">
                        Ingat Saya
                      </label>
                    </div>
                    <a class="text-primary fw-bold" href="./forgot-password.php">Lupa Password?</a>
                  </div>
                  <button type="submit" class="btn btn-primary w-100 py-8 fs-4 mb-4 rounded-2">Masuk</button>
                  <div class="d-flex align-items-center justify-content-center">
                    <p class="fs-4 mb-0 fw-bold">Belum punya akun?</p>
                    <a class="text-primary fw-bold ms-2" href="./register.php">Daftar</a>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <script src="assets/libs/jquery/dist/jquery.min.js"></script>
  <script src="assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
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