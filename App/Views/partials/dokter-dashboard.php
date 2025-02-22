<?php
// Get doctor name
$doctorName = explode(' ', $doctorProfile['full_name'])[0];

// Get greeting based on time
$hour = date('H');
$greeting = '';
if ($hour >= 5 && $hour < 12) {
    $greeting = 'Pagi';
} elseif ($hour >= 12 && $hour < 15) {
    $greeting = 'Siang';
} elseif ($hour >= 15 && $hour < 18) {
    $greeting = 'Sore';
} else {
    $greeting = 'Malam';
}
?>

<!-- Greeting Section -->
<div class="row">
    <div class="col-12">
        <div class="card w-100">
            <div class="card-body bg-light-primary">
                <div class="row align-items-center">
                    <div class="col-lg-4">
                        <img src="assets/images/data/data-dashboard.png" alt="Doctor Profile" class="img-fluid rounded-circle" style="max-width: 200px;">
                    </div>
                    <div class="col-lg-6">
                        <h3 class="fw-semibold mb-3">Hi, Selamat <?= $greeting ?> <?= htmlspecialchars($doctorName) ?></h3>
                        <p class="fs-4 mb-4">
                            Selamat datang di dashboard monitoring tekanan darah.
                            Mari pantau kesehatan pasien Anda.
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

                        <button class="btn btn-primary d-flex align-items-center" onclick="window.location.href='pengobatan.php'">
                            <i class="ti ti-plus fs-5 me-2"></i>
                            <span>Tambah Pengobatan Baru</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Statistics Cards -->
<div class="row">
    <div class="col-lg-4">
        <div class="card">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <i class="ti ti-heart-rate-monitor text-primary fs-7 me-3"></i>
                    <div>
                        <h5 class="mb-0">Kasus Hipertensi</h5>
                        <h2 class="mt-2 mb-0"><?= $activeCases ?></h2>
                        <small class="text-muted">Pasien dengan tekanan darah tinggi</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="card">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <i class="ti ti-medicine text-success fs-7 me-3"></i>
                    <div>
                        <h5 class="mb-0">Pengobatan Aktif</h5>
                        <h2 class="mt-2 mb-0"><?= $activemedications ?></h2>
                        <small class="text-muted">Resep obat berjalan</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="card">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <i class="ti ti-notes-medical text-warning fs-7 me-3"></i>
                    <div>
                        <h5 class="mb-0">Rekomendasi</h5>
                        <h2 class="mt-2 mb-0"><?= $totalRecommendations ?></h2>
                        <small class="text-muted">Total rekomendasi diberikan</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Recent Patients -->
<div class="row mt-4">
    <div class="col-lg-6">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Pasien Terbaru</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Nama</th>
                                <th>Tekanan Darah</th>
                                <th>Tanggal</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($recentPatients as $patient): ?>
                                <tr>
                                    <td><?= htmlspecialchars($patient['full_name']) ?></td>
                                    <td><?= $patient['systolic'] ?>/<?= $patient['diastolic'] ?></td>
                                    <td><?= date('d/m/Y H:i', strtotime($patient['reading_date']) + (7 * 3600)) ?></td>
                                    <td>
                                        <?php
                                        $status = '';
                                        $class = '';
                                        if ($patient['systolic'] >= 140 || $patient['diastolic'] >= 90) {
                                            $status = 'Hipertensi';
                                            $class = 'bg-danger';
                                        } elseif ($patient['systolic'] >= 120 || $patient['diastolic'] >= 80) {
                                            $status = 'Prehipertensi';
                                            $class = 'bg-warning';
                                        } else {
                                            $status = 'Normal';
                                            $class = 'bg-success';
                                        }
                                        ?>
                                        <span class="badge <?= $class ?>"><?= $status ?></span>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Recommendations -->
    <div class="col-lg-6">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Rekomendasi Terbaru</h5>
            </div>
            <div class="card-body">
                <?php if (!empty($recentRecommendations)): ?>
                    <?php foreach ($recentRecommendations as $rec): ?>
                        <div class="d-flex align-items-center mb-3 pb-3 border-bottom">
                            <i class="ti ti-message-dots text-primary fs-6 me-3"></i>
                            <div>
                                <h6 class="mb-1"><?= htmlspecialchars($rec['title']) ?></h6>
                                <p class="mb-1"><?= htmlspecialchars($rec['description']) ?></p>
                                <small class="text-muted">
                                    Untuk: <?= htmlspecialchars($rec['patient_name']) ?> - 
                                    <?= date('d/m/Y', strtotime($rec['created_at']) + (7 * 3600)) ?>
                                </small>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p class="text-muted mb-0">Belum ada rekomendasi terbaru</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
