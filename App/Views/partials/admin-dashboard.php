<?php
// Get admin stats
$totalDoctors = $adminController->getTotalDoctors();
$totalPatients = $adminController->getTotalPatients();
$totalReadings = $adminController->getTotalReadings();
$recentActivities = $adminController->getRecentActivities();
?>

<!-- Greeting Section -->
<div class="row">
    <div class="col-12">
        <div class="card w-100">
            <div class="card-body bg-light-primary">
                <div class="row align-items-center">
                    <div class="col-lg-4">
                        <img src="assets/images/data/data-dashboard.png" alt="Admin Dashboard" class="img-fluid">
                    </div>
                    <div class="col-lg-6">
                        <h3 class="fw-semibold mb-3">Dashboard Administrator</h3>
                        <p class="fs-4 mb-4">
                            Kelola sistem monitoring tekanan darah.
                            Pantau aktivitas dokter dan pasien.
                        </p>

                        <div class="card bg-primary text-white mb-4">
                            <div class="card-body d-flex align-items-center">
                                <i class="ti ti-users fs-6 me-3"></i>
                                <div>
                                    <h2 class="text-white mb-0"><?= $totalUsers ?></h2>
                                    <p class="mb-0">Total Pengguna Sistem</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Statistics Cards -->
<div class="row">
    <div class="col-lg-3">
        <div class="card">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <i class="ti ti-user-star text-primary fs-7 me-3"></i>
                    <div>
                        <h5 class="mb-0">Total Dokter</h5>
                        <h2 class="mt-2 mb-0"><?= $totalDoctors ?></h2>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-3">
        <div class="card">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <i class="ti ti-users text-success fs-7 me-3"></i>
                    <div>
                        <h5 class="mb-0">Total Pasien</h5>
                        <h2 class="mt-2 mb-0"><?= $totalPatients ?></h2>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-3">
        <div class="card">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <i class="ti ti-heart-rate-monitor text-warning fs-7 me-3"></i>
                    <div>
                        <h5 class="mb-0">Pengukuran</h5>
                        <h2 class="mt-2 mb-0"><?= $totalReadings ?></h2>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-3">
        <div class="card">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <i class="ti ti-medicine text-danger fs-7 me-3"></i>
                    <div>
                        <h5 class="mb-0">Pengobatan</h5>
                        <h2 class="mt-2 mb-0"><?= $totalMedications ?></h2>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Recent Activities -->
<div class="row mt-4">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Aktivitas Terbaru</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Waktu</th>
                                <th>Pengguna</th>
                                <th>Tipe</th>
                                <th>Aktivitas</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($recentActivities as $activity): ?>
                                <tr>
                                    <td><?= date('d/m/Y H:i', strtotime($activity['created_at']) + (7 * 3600)) ?></td>
                                    <td><?= htmlspecialchars($activity['user_name']) ?></td>
                                    <td><?= htmlspecialchars($activity['type']) ?></td>
                                    <td><?= htmlspecialchars($activity['description'] ?? 'Aktivitas sistem') ?></td>

                                    <td>
                                        <span class="badge bg-<?= $activity['status_color'] ?>">
                                            <?= htmlspecialchars($activity['status']) ?>
                                        </span>
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