<!-- Patient Dashboard -->
<?php
// Get patient name
$patientName = explode(' ', $patientProfile['full_name'])[0];

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
                        <img src="assets/images/data/data-dashboard.png" alt="Patient Profile"
                            class="img-fluid rounded-circle" style="max-width: 200px;">
                    </div>
                    <div class="col-lg-6">
                        <h3 class="fw-semibold mb-3">Hi, Selamat <?= $greeting ?> <?= htmlspecialchars($patientName) ?>
                        </h3>
                        <p class="fs-4 mb-4">
                            Selamat datang di dashboard monitoring tekanan darah Anda.
                            Mari pantau kesehatan Anda secara teratur.
                        </p>

                        <div class="card bg-primary text-white mb-4">
                            <div class="card-body d-flex align-items-center">
                                <i class="ti ti-heart-rate-monitor fs-6 me-3"></i>
                                <div>
                                    <h2 class="text-white mb-0"><?= $totalReadings ?></h2>
                                    <p class="mb-0">Total Pengukuran Tekanan Darah</p>
                                </div>
                            </div>
                        </div>

                        <button class="btn btn-primary d-flex align-items-center"
                            onclick="window.location.href='pencatatan.php'">
                            <i class="ti ti-plus fs-5 me-2"></i>
                            <span>Tambah Pencatatan Baru</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="row">
    <!-- Blood Pressure Stats Card -->
    <div class="col-lg-4">
        <div class="card hover-shadow">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <i class="ti ti-heart text-primary fs-7 me-3 pulse-animation"></i>
                    <div>
                        <h5 class="card-title mb-1">Tekanan Darah Terakhir</h5>
                        <h3 class="mb-0 text-primary">
                            <?= isset($latestReading['systolic']) ? $latestReading['systolic'] . '/' . $latestReading['diastolic'] : '-/-' ?>
                        </h3>
                        <small class="text-muted">
                            <?= isset($latestReading['reading_date']) ? date('d/m/Y H:i', strtotime($latestReading['reading_date'])) : '-' ?>
                        </small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Total Readings Card -->
    <div class="col-lg-4">
        <div class="card hover-shadow">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <i class="ti ti-notes text-success fs-7 me-3 bounce-animation"></i>
                    <div>
                        <h5 class="card-title mb-1">Total Pencatatan</h5>
                        <h3 class="mb-0 text-success"><?= $totalReadings ?></h3>
                        <small class="text-muted">Catatan Tekanan Darah</small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Active Medications Card -->
    <div class="col-lg-4">
        <div class="card hover-shadow">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <i class="ti ti-medicine text-warning fs-7 me-3 shake-animation"></i>
                    <div>
                        <h5 class="card-title mb-1">Pengobatan Aktif</h5>
                        <h3 class="mb-0 text-warning"><?= count($activeMedications) ?></h3>
                        <small class="text-muted">Obat yang Sedang Dikonsumsi</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Latest Records -->
<div class="row">
    <!-- Latest Readings -->
    <div class="col-lg-6">
        <div class="card hover-shadow">
            <div class="card-body">
                <h5 class="card-title"><i class="ti ti-chart-line me-2"></i>Pencatatan Terbaru</h5>
                <div class="table-responsive">
                    <table class="table text-nowrap mb-0 align-middle">
                        <thead>
                            <tr>
                                <th>Tanggal</th>
                                <th>Systolic/Diastolic</th>
                                <th>Detak Jantung</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach (array_slice($recentReadings, 0, 5) as $reading): ?>
                                <tr>
                                    <td><?= date('d/m/Y H:i', strtotime($reading['reading_date'])) ?></td>
                                    <td><?= $reading['systolic'] ?>/<?= $reading['diastolic'] ?></td>
                                    <td><?= $reading['pulse_rate'] ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Latest Recommendations -->
    <div class="col-lg-6">
        <div class="card hover-shadow">
            <div class="card-body">
                <h5 class="card-title"><i class="ti ti-bulb me-2"></i>Rekomendasi Terbaru</h5>
                <?php if (!empty($recommendations)): ?>
                    <?php foreach (array_slice($recommendations, 0, 3) as $rec): ?>
                        <div class="alert alert-info mb-3 fade-in">
                            <h6 class="mb-1"><?= htmlspecialchars($rec['title']) ?></h6>
                            <p class="mb-0"><?= htmlspecialchars($rec['description']) ?></p>
                            <small class="text-muted">
                                <?= date('d/m/Y', strtotime($rec['created_at'])) ?>
                                oleh <?= htmlspecialchars($rec['created_by_name']) ?>
                            </small>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="alert alert-info">
                        Belum ada rekomendasi terbaru
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<!-- Active Medications -->
<div class="row">
    <div class="col-12">
        <div class="card hover-shadow">
            <div class="card-body">
                <h5 class="card-title"><i class="ti ti-pill me-2"></i>Pengobatan Aktif</h5>
                <div class="table-responsive">
                    <table class="table text-nowrap mb-0 align-middle">
                        <thead>
                            <tr>
                                <th>Obat</th>
                                <th>Dosis</th>
                                <th>Frekuensi</th>
                                <th>Mulai</th>
                                <th>Selesai</th>
                                <th>Dokter</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($activeMedications as $med): ?>
                                <tr>
                                    <td><?= htmlspecialchars($med['medication_name']) ?></td>
                                    <td><?= htmlspecialchars($med['dosage']) ?></td>
                                    <td><?= htmlspecialchars($med['frequency']) ?></td>
                                    <td><?= date('d/m/Y', strtotime($med['start_date'])) ?></td>
                                    <td><?= date('d/m/Y', strtotime($med['end_date'])) ?></td>
                                    <td><?= htmlspecialchars($med['doctor_name']) ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>