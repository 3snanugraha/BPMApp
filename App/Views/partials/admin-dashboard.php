<div class="row">
    <!-- Statistics Cards -->
    <div class="col-lg-3">
        <div class="card">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <i class="ti ti-user-plus text-primary fs-7"></i>
                    <div class="ms-3">
                        <h3 class="mb-0 fw-semibold"><?= $totalPatients ?></h3>
                        <small class="mb-0">Total Pasien</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-3">
        <div class="card">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <i class="ti ti-stethoscope text-success fs-7"></i>
                    <div class="ms-3">
                        <h3 class="mb-0 fw-semibold"><?= $totalDoctors ?></h3>
                        <small class="mb-0">Total Dokter</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-3">
        <div class="card">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <i class="ti ti-heart-rate text-warning fs-7"></i>
                    <div class="ms-3">
                        <h3 class="mb-0 fw-semibold"><?= $todayReadings ?></h3>
                        <small class="mb-0">Pengukuran Hari Ini</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-3">
        <div class="card">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <i class="ti ti-alert-triangle text-danger fs-7"></i>
                    <div class="ms-3">
                        <h3 class="mb-0 fw-semibold"><?= $abnormalCases ?></h3>
                        <small class="mb-0">Kasus Hipertensi</small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Blood Pressure Trends -->
    <div class="col-lg-8">
        <div class="card">
            <div class="card-body">
                <div class="d-flex align-items-center justify-content-between mb-4">
                    <h5 class="card-title fw-semibold">Tren Tekanan Darah</h5>
                    <select class="form-select w-25" id="trendPeriod">
                        <option value="7">7 Hari Terakhir</option>
                        <option value="30">30 Hari Terakhir</option>
                        <option value="90">90 Hari Terakhir</option>
                    </select>
                </div>
                <div id="bpTrendChart" style="height: 350px;" data-trends='<?= json_encode($readingTrends) ?>'></div>
            </div>
        </div>
    </div>

    <!-- Recent Patients -->
    <div class="col-lg-4">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title fw-semibold mb-4">Pasien Terbaru</h5>
                <div class="recent-patients">
                    <?php foreach ($recentPatients as $patient):
                        $latestReading = $pencatatanController->getLatestReading($patient['patient_id']);
                        $status = '';
                        $statusClass = '';
                        if ($latestReading) {
                            if ($latestReading['systolic'] >= 140 || $latestReading['diastolic'] >= 90) {
                                $status = 'Tinggi';
                                $statusClass = 'danger';
                            } elseif ($latestReading['systolic'] >= 120 || $latestReading['diastolic'] >= 80) {
                                $status = 'Sedang';
                                $statusClass = 'warning';
                            } else {
                                $status = 'Normal';
                                $statusClass = 'success';
                            }
                        }
                        ?>
                        <div class="d-flex align-items-center mb-3 pb-3 border-bottom">
                            <img src="assets/images/profile/user-1.jpg" class="rounded-circle" width="40" height="40">
                            <div class="ms-3">
                                <h6 class="fw-semibold mb-1"><?= htmlspecialchars($patient['full_name']) ?></h6>
                                <span class="text-muted fs-3">
                                    Tekanan:
                                    <?= $latestReading ? $latestReading['systolic'] . '/' . $latestReading['diastolic'] . ' mmHg' : 'Belum ada data' ?>
                                </span>
                            </div>
                            <?php if ($latestReading): ?>
                                <span class="badge bg-<?= $statusClass ?> ms-auto"><?= $status ?></span>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Doctor Performance -->
    <div class="col-lg-6">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title fw-semibold mb-4">Kinerja Dokter</h5>
                <div class="table-responsive">
                    <table class="table text-nowrap mb-0 align-middle">
                        <thead>
                            <tr>
                                <th>Dokter</th>
                                <th>Total Pasien</th>
                                <th>Kasus Aktif</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($doctors as $doctor):
                                $patientCount = count($dokterController->getDoctorPatients($doctor['doctor_id']));
                                $activeCount = count($dokterController->getActiveCases($doctor['doctor_id']));
                                ?>
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <img src="assets/images/profile/user-2.jpg" class="rounded-circle" width="35">
                                            <div class="ms-3">
                                                <h6 class="fw-semibold mb-0"><?= htmlspecialchars($doctor['full_name']) ?>
                                                </h6>
                                                <span
                                                    class="text-muted"><?= htmlspecialchars($doctor['specialization']) ?></span>
                                            </div>
                                        </div>
                                    </td>
                                    <td><?= $patientCount ?></td>
                                    <td><?= $activeCount ?></td>
                                    <td>
                                        <span class="badge bg-<?= $activeCount > 0 ? 'warning' : 'success' ?>">
                                            <?= $activeCount > 0 ? 'Active' : 'Available' ?>
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

    <!-- System Health -->
    <div class="col-lg-6">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title fw-semibold mb-4">Statistik Sistem</h5>
                <div class="mb-4">
                    <h6 class="fw-semibold mb-2">Total Pengukuran</h6>
                    <div class="progress" style="height: 8px;">
                        <div class="progress-bar bg-primary" style="width: 100%">
                            <?= $pencatatanController->getTotalReadings() ?>
                        </div>
                    </div>
                </div>
                <div class="mb-4">
                    <h6 class="fw-semibold mb-2">Kasus Hipertensi</h6>
                    <div class="progress" style="height: 8px;">
                        <div class="progress-bar bg-danger" style="width: <?= ($abnormalCases / $totalPatients) * 100 ?>%">
                        </div>
                    </div>
                </div>
                <div class="alert alert-info mb-0">
                    <i class="ti ti-info-circle me-2"></i>
                    Last Update: <?= date('d/m/Y H:i:s') ?>
                </div>
            </div>
        </div>
    </div>
</div>