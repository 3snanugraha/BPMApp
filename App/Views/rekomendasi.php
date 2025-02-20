<?php
require_once __DIR__ . '/../Controllers/AuthController.php';
require_once __DIR__ . '/../Controllers/RekomendasiController.php';
session_start();

$auth = new AuthController();
$auth->checkAuth();

$rekomendasiController = new RekomendasiController();
$recommendations = $rekomendasiController->getAllRecommendations();
$totalRecommendations = count($recommendations);
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Data Rekomendasi - Sistem Monitoring Tekanan Darah</title>
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
                                        <img src="assets/images/data/data.png" alt="Recommendation Statistics"
                                            class="img-fluid">
                                    </div>
                                    <div class="col-lg-6">
                                        <h3 class="fw-semibold mb-3">Data Rekomendasi</h3>
                                        <p class="fs-4 mb-4">
                                            Kelola data rekomendasi kesehatan untuk pasien dalam sistem monitoring.
                                            <?php if (in_array($_SESSION['role'], ['admin', 'doctor'])): ?>
                                                Anda dapat menambah, mengubah, dan menghapus data rekomendasi.
                                            <?php endif; ?>
                                        </p>

                                        <div class="card bg-primary text-white mb-4">
                                            <div class="card-body d-flex align-items-center">
                                                <i class="ti ti-list fs-6 me-3"></i>
                                                <div>
                                                    <h2 class="text-white mb-0"><?= $totalRecommendations ?></h2>
                                                    <p class="mb-0">Total Rekomendasi Terdaftar</p>
                                                </div>
                                            </div>
                                        </div>

                                        <?php if (in_array($_SESSION['role'], ['admin', 'doctor'])): ?>
                                            <button class="btn btn-primary d-flex align-items-center" data-bs-toggle="modal"
                                                data-bs-target="#addRecommendationModal">
                                                <i class="ti ti-plus fs-5 me-2"></i>
                                                <span>Tambah Data Rekomendasi</span>
                                            </button>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Recommendations Table Section -->
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="recommendationTable"
                                        class="table table-striped dt-responsive nowrap w-100">
                                        <thead>
                                            <tr>
                                                <th>Judul</th>
                                                <th>Deskripsi</th>
                                                <th>Total Pasien</th>
                                                <th>Dibuat Oleh</th>
                                                <th>Tanggal Dibuat</th>
                                                <?php if (in_array($_SESSION['role'], ['admin', 'doctor'])): ?>
                                                    <th>Aksi</th>
                                                <?php endif; ?>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($recommendations as $recommendation): ?>
                                                <tr>
                                                    <td><?= htmlspecialchars($recommendation['title']) ?></td>
                                                    <td><?= htmlspecialchars(substr($recommendation['description'], 0, 50)) . '...' ?>
                                                    </td>
                                                    <td><?= $recommendation['total_patients'] ?> Pasien</td>
                                                    <td><?= htmlspecialchars($recommendation['created_by_name']) ?></td>
                                                    <td><?= date('d/m/Y H:i', strtotime($recommendation['created_at'])) ?>
                                                    </td>
                                                    <?php if (in_array($_SESSION['role'], ['admin', 'doctor'])): ?>
                                                        <td>
                                                            <button type="button"
                                                                class="btn btn-info btn-sm view-recommendation me-1"
                                                                data-recommendation='<?= htmlspecialchars(json_encode($recommendation), ENT_QUOTES, 'UTF-8') ?>'>
                                                                <i class="ti ti-eye"></i>
                                                            </button>
                                                            <button type="button"
                                                                class="btn btn-warning btn-sm edit-recommendation me-1"
                                                                data-recommendation='<?= htmlspecialchars(json_encode($recommendation), ENT_QUOTES, 'UTF-8') ?>'>
                                                                <i class="ti ti-edit"></i>
                                                            </button>
                                                            <button type="button"
                                                                class="btn btn-danger btn-sm delete-recommendation"
                                                                data-id="<?= $recommendation['recommendation_id'] ?>">
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

                <?php include 'partials/footer.php'; ?>
                <?php include 'partials/rekomendasi-modals.php'; ?>
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

    <script>
        $(document).ready(function () {
            var table = $('#recommendationTable').DataTable({
                responsive: true,
                language: {
                    url: '//cdn.datatables.net/plug-ins/1.13.7/i18n/id.json'
                }
            });

            $(document).on('click', '.view-recommendation', function () {
                var recommendation = JSON.parse($(this).attr('data-recommendation'));
                $('#view_title').text(recommendation.title);
                $('#view_description').text(recommendation.description);
                $('#view_created_by').text(recommendation.created_by_name);
                $('#view_created_at').text(new Date(recommendation.created_at).toLocaleString('id-ID'));
                $('#view_total_patients').text(recommendation.total_patients + ' Pasien');
                $('#viewRecommendationModal').modal('show');
            });

            $(document).on('click', '.edit-recommendation', function () {
                var recommendation = JSON.parse($(this).attr('data-recommendation'));
                $('#edit_recommendation_id').val(recommendation.recommendation_id);
                $('#edit_title').val(recommendation.title);
                $('#edit_description').val(recommendation.description);
                $('#editRecommendationModal').modal('show');
            });

            $(document).on('click', '.delete-recommendation', function () {
                if (confirm('Apakah Anda yakin ingin menghapus rekomendasi ini?')) {
                    var form = $('<form action="../Controllers/RekomendasiController.php" method="POST">' +
                        '<input type="hidden" name="action" value="delete_recommendation">' +
                        '<input type="hidden" name="recommendation_id" value="' + $(this).data('id') + '">' +
                        '</form>');
                    $('body').append(form);
                    form.submit();
                }
            });
        });
    </script>
</body>

</html>