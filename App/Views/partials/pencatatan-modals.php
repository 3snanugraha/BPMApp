<!-- Add Reading Modal -->
<div class="modal fade" id="addReadingModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Pencatatan Tekanan Darah</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="../Controllers/PencatatanController.php" method="POST">
                <div class="modal-body">
                    <input type="hidden" name="action" value="add_reading">
                    <?php if ($_SESSION['role'] !== 'patient'): ?>
                        <div class="mb-3">
                            <label class="form-label">Pasien</label>
                            <select name="patient_id" class="form-select" required>
                                <option value="">Pilih Pasien</option>
                                <?php
                                $patientsList = $pencatatanController->getPatientsList();
                                foreach ($patientsList as $patient):
                                    ?>
                                    <option value="<?= $patient['patient_id'] ?>"><?= $patient['full_name'] ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    <?php endif; ?>
                    <div class="mb-3">
                        <label class="form-label">Systolic (mmHg)</label>
                        <input type="number" class="form-control" name="systolic" required min="0" max="300">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Diastolic (mmHg)</label>
                        <input type="number" class="form-control" name="diastolic" required min="0" max="200">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Detak Jantung (bpm)</label>
                        <input type="number" class="form-control" name="pulse_rate" required min="0" max="200">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Catatan</label>
                        <textarea class="form-control" name="notes" rows="3"></textarea>
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

<!-- Edit Reading Modal -->
<div class="modal fade" id="editReadingModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Pencatatan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="../Controllers/PencatatanController.php" method="POST">
                <div class="modal-body">
                    <input type="hidden" name="action" value="edit_reading">
                    <input type="hidden" name="reading_id" id="edit_reading_id">
                    <div class="mb-3">
                        <label class="form-label">Systolic (mmHg)</label>
                        <input type="number" class="form-control" name="systolic" id="edit_systolic" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Diastolic (mmHg)</label>
                        <input type="number" class="form-control" name="diastolic" id="edit_diastolic" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Detak Jantung (bpm)</label>
                        <input type="number" class="form-control" name="pulse_rate" id="edit_pulse_rate" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Catatan</label>
                        <textarea class="form-control" name="notes" id="edit_notes" rows="3"></textarea>
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

<!-- View Reading Modal -->
<div class="modal fade" id="viewReadingModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Detail Pencatatan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <?php if ($_SESSION['role'] !== 'patient'): ?>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Pasien:</label>
                        <p id="view_patient_name"></p>
                    </div>
                <?php endif; ?>
                <div class="mb-3">
                    <label class="form-label fw-bold">Tekanan Darah:</label>
                    <p id="view_blood_pressure"></p>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-bold">Detak Jantung:</label>
                    <p id="view_pulse_rate"></p>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-bold">Tanggal:</label>
                    <p id="view_reading_date"></p>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-bold">Catatan:</label>
                    <p id="view_notes"></p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Delete Reading Modal -->
<div class="modal fade" id="deleteReadingModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Hapus Pencatatan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="../Controllers/PencatatanController.php" method="POST">
                <div class="modal-body">
                    <input type="hidden" name="action" value="delete_reading">
                    <input type="hidden" name="reading_id" id="delete_reading_id">
                    <p>Anda yakin ingin menghapus pencatatan ini?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-danger">Hapus</button>
                </div>
            </form>
        </div>
    </div>
</div>