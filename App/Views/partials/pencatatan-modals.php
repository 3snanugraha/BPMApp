<!-- Add Reading Modal -->
<div class="modal fade" id="addReadingModal" tabindex="-1" role="dialog" aria-labelledby="addReadingModalLabel">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addReadingModalLabel">Catat Tekanan Darah</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="../Controllers/PencatatanController.php" method="POST" id="addReadingForm">
                <input type="hidden" name="action" value="add_reading">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label" for="add_systolic">Systolic (mmHg)</label>
                                <input type="number" class="form-control" id="add_systolic" name="systolic" min="70"
                                    max="200" required>
                                <div class="form-text">Normal: 90-120 mmHg</div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label" for="add_diastolic">Diastolic (mmHg)</label>
                                <input type="number" class="form-control" id="add_diastolic" name="diastolic" min="40"
                                    max="130" required>
                                <div class="form-text">Normal: 60-80 mmHg</div>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="add_pulse_rate">Detak Jantung (bpm)</label>
                        <input type="number" class="form-control" id="add_pulse_rate" name="pulse_rate" min="40"
                            max="200" required>
                        <div class="form-text">Normal: 60-100 bpm</div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="add_notes">Catatan</label>
                        <textarea class="form-control" id="add_notes" name="notes" rows="3"
                            placeholder="Contoh: Setelah olahraga, Sebelum makan, dll"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Result Modal -->
<div class="modal fade" id="resultModal" tabindex="-1" role="dialog" aria-labelledby="resultModalLabel">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="resultModalLabel">Hasil Pengukuran</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="text-center mb-4">
                    <div id="resultIcon" class="display-1 mb-2"></div>
                    <h4 id="resultTitle" class="mb-3"></h4>
                </div>
                <div class="row mb-3">
                    <div class="col-sm-6">
                        <div class="card bg-light">
                            <div class="card-body text-center">
                                <h6 class="card-title">Systolic</h6>
                                <p id="resultSystolic" class="display-6 mb-0"></p>
                                <small>mmHg</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="card bg-light">
                            <div class="card-body text-center">
                                <h6 class="card-title">Diastolic</h6>
                                <p id="resultDiastolic" class="display-6 mb-0"></p>
                                <small>mmHg</small>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card mb-3">
                    <div class="card-body">
                        <h6 class="card-title">Detak Jantung</h6>
                        <p id="resultPulseRate" class="mb-0"></p>
                    </div>
                </div>
                <div class="card mb-3">
                    <div class="card-body">
                        <h6 class="card-title">Rekomendasi</h6>
                        <p id="resultRecommendation" class="mb-0"></p>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body">
                        <h6 class="card-title">Catatan</h6>
                        <p id="resultNotes" class="mb-0"></p>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

<!-- Chart Modal -->
<div class="modal fade" id="chartModal" tabindex="-1" role="dialog" aria-labelledby="chartModalLabel">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="chartModalLabel">Grafik Tekanan Darah</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="btn-group mb-3" role="group" aria-label="Chart period">
                    <button type="button" class="btn btn-outline-primary" data-period="7">7 Hari</button>
                    <button type="button" class="btn btn-outline-primary" data-period="14">14 Hari</button>
                    <button type="button" class="btn btn-outline-primary" data-period="30">30 Hari</button>
                </div>
                <canvas id="bpTrendChart"></canvas>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>