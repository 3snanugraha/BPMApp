<!-- Add Reading Modal -->
<div class="modal fade" id="addReadingModal" tabindex="-1" role="dialog" aria-labelledby="addReadingModalLabel">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addReadingModalLabel">Tambah Data Tekanan Darah</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="../Controllers/RiwayatController.php" method="POST" id="addReadingForm">
                <input type="hidden" name="action" value="add_reading">
                <input type="hidden" name="patient_id" value="<?= $_SESSION['user_id'] ?>">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label" for="add_systolic">Systolic (mmHg)</label>
                                <input type="number" class="form-control" id="add_systolic" name="systolic" min="70"
                                    max="200" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label" for="add_diastolic">Diastolic (mmHg)</label>
                                <input type="number" class="form-control" id="add_diastolic" name="diastolic" min="40"
                                    max="130" required>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="add_pulse_rate">Detak Jantung (bpm)</label>
                        <input type="number" class="form-control" id="add_pulse_rate" name="pulse_rate" min="40"
                            max="200" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="add_notes">Catatan</label>
                        <textarea class="form-control" id="add_notes" name="notes" rows="3"></textarea>
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
<div class="modal fade" id="editReadingModal" tabindex="-1" role="dialog" aria-labelledby="editReadingModalLabel">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editReadingModalLabel">Edit Data Tekanan Darah</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="../Controllers/RiwayatController.php" method="POST" id="editReadingForm">
                <input type="hidden" name="action" value="edit_reading">
                <input type="hidden" name="reading_id" id="edit_reading_id">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label" for="edit_systolic">Systolic (mmHg)</label>
                                <input type="number" class="form-control" id="edit_systolic" name="systolic" min="70"
                                    max="200" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label" for="edit_diastolic">Diastolic (mmHg)</label>
                                <input type="number" class="form-control" id="edit_diastolic" name="diastolic" min="40"
                                    max="130" required>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="edit_pulse_rate">Detak Jantung (bpm)</label>
                        <input type="number" class="form-control" id="edit_pulse_rate" name="pulse_rate" min="40"
                            max="200" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="edit_notes">Catatan</label>
                        <textarea class="form-control" id="edit_notes" name="notes" rows="3"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Delete Reading Modal -->
<div class="modal fade" id="deleteReadingModal" tabindex="-1" role="dialog" aria-labelledby="deleteReadingModalLabel">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteReadingModalLabel">Hapus Data Tekanan Darah</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="../Controllers/RiwayatController.php" method="POST">
                <input type="hidden" name="action" value="delete_reading">
                <input type="hidden" name="reading_id" id="delete_reading_id">
                <div class="modal-body">
                    <p>Anda yakin ingin menghapus data tekanan darah ini?</p>
                    <p class="text-danger"><small>Tindakan ini tidak dapat dibatalkan</small></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-danger">Hapus</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- View Reading Modal -->
<div class="modal fade" id="viewReadingModal" tabindex="-1" role="dialog" aria-labelledby="viewReadingModalLabel">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="viewReadingModalLabel">Detail Tekanan Darah</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row mb-3">
                    <div class="col-sm-4 fw-bold">Nama Pasien</div>
                    <div class="col-sm-8" id="view_patient_name"></div>
                </div>
                <div class="row mb-3">
                    <div class="col-sm-4 fw-bold">Tekanan Darah</div>
                    <div class="col-sm-8">
                        <span id="view_systolic"></span>/<span id="view_diastolic"></span> mmHg
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-sm-4 fw-bold">Detak Jantung</div>
                    <div class="col-sm-8"><span id="view_pulse_rate"></span> bpm</div>
                </div>
                <div class="row mb-3">
                    <div class="col-sm-4 fw-bold">Catatan</div>
                    <div class="col-sm-8" id="view_notes"></div>
                </div>
                <div class="row mb-3">
                    <div class="col-sm-4 fw-bold">Waktu Pengukuran</div>
                    <div class="col-sm-8" id="view_reading_date"></div>
                </div>
                <div class="row mb-3">
                    <div class="col-sm-4 fw-bold">Rekomendasi</div>
                    <div class="col-sm-8">
                        <div id="view_recommendation_title" class="fw-bold"></div>
                        <div id="view_recommendation_description"></div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>