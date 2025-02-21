<?php
require_once __DIR__ . '/../../Controllers/PasienController.php';
require_once __DIR__ . '/../../Controllers/PengobatanController.php';
require_once __DIR__ . '/../../Controllers/RekomendasiController.php';

$pasienController = new PasienController();
$pengobatanController = new PengobatanController();
$rekomendasiController = new RekomendasiController();

// Get patient data
$patientId = $pasienController->getPatientIdByUserId($_SESSION['user_id']);
$latestReading = $pasienController->getLatestReading($patientId);
$totalReadings = $pasienController->getTotalReadings($patientId);
$recentReadings = $pasienController->getPatientBloodPressureReadings($patientId);
$activeMedications = $pengobatanController->getPatientPrescriptions($patientId);
$recommendations = $rekomendasiController->getPatientRecommendations($patientId);
?>

<!-- Patient Dashboard -->
<div class="row">
    <!-- Blood Pressure Stats Card -->
    <div class="col-lg-4">
        <div class="card">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <i class="ti ti-heart text-primary fs-7 me-3"></i>
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
        <div class="card">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <i class="ti ti-notes text-success fs-7 me-3"></i>
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
        <div class="card">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <i class="ti ti-medicine text-warning fs-7 me-3"></i>
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
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Pencatatan Terbaru</h5>
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
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Rekomendasi Terbaru</h5>
                <?php if (!empty($recommendations)): ?>
                    <?php foreach (array_slice($recommendations, 0, 3) as $rec): ?>
                        <div class="alert alert-info mb-3">
                            <h6 class="mb-1"><?= htmlspecialchars($rec['title']) ?></h6>
                            <p class="mb-0"><?= htmlspecialchars($rec['description']) ?></p>
                            <small class="text-muted">
                                <?= date('d/m/Y', strtotime($rec['created_at'])) ?>
                                oleh Dr. <?= htmlspecialchars($rec['created_by_name']) ?>
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
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Pengobatan Aktif</h5>
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