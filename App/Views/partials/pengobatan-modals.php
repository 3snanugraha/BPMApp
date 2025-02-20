<!-- Add Prescription Modal -->
<div class="modal fade" id="addPrescriptionModal" tabindex="-1" role="dialog"
    aria-labelledby="addPrescriptionModalLabel">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addPrescriptionModalLabel">Tambah Pengobatan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="../Controllers/PengobatanController.php" method="POST" id="addPrescriptionForm">
                    <input type="hidden" name="action" value="add_prescription">

                    <!-- Patient Selection -->
                    <div class="mb-3">
                        <label class="form-label">Pilih Pasien</label>
                        <select class="form-select" id="patient_selector" name="patient_id" required>
                            <option value="">Pilih pasien...</option>
                        </select>
                    </div>

                    <!-- Blood Pressure History (Reference Only) -->
                    <div id="readings_section" class="mb-3" style="display: none;">
                        <label class="form-label">Riwayat Tekanan Darah Terakhir</label>
                        <div class="table-responsive">
                            <table class="table table-bordered table-sm">
                                <thead>
                                    <tr>
                                        <th>Tanggal</th>
                                        <th>Systolic</th>
                                        <th>Diastolic</th>
                                        <th>Pulse Rate</th>
                                    </tr>
                                </thead>
                                <tbody id="readings_table_body">
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Medication Selection -->
                    <div class="mb-3">
                        <label class="form-label">Pilih Obat</label>
                        <select class="form-select select2" name="medication_id" id="medication_selector" required>
                            <option value="">Pilih obat...</option>
                        </select>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Dosis</label>
                            <input type="text" class="form-control" name="dosage" placeholder="Contoh: 1 tablet"
                                required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Frekuensi</label>
                            <input type="text" class="form-control" name="frequency" placeholder="Contoh: 3x sehari"
                                required>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Tanggal Mulai</label>
                            <input type="date" class="form-control" name="start_date" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Tanggal Selesai</label>
                            <input type="date" class="form-control" name="end_date" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Catatan</label>
                        <textarea class="form-control" name="notes" rows="3"></textarea>
                    </div>

                    <div class="modal-footer px-0 pb-0">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan Pengobatan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Edit Prescription Modal -->
<div class="modal fade" id="editPrescriptionModal" tabindex="-1" role="dialog"
    aria-labelledby="editPrescriptionModalLabel">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editPrescriptionModalLabel">Edit Pengobatan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="../Controllers/PengobatanController.php" method="POST">
                <input type="hidden" name="action" value="edit_prescription">
                <input type="hidden" name="prescription_id" id="edit_prescription_id">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Dosis</label>
                            <input type="text" class="form-control" name="dosage" id="edit_dosage" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Frekuensi</label>
                            <input type="text" class="form-control" name="frequency" id="edit_frequency" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Tanggal Mulai</label>
                            <input type="date" class="form-control" name="start_date" id="edit_start_date" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Tanggal Selesai</label>
                            <input type="date" class="form-control" name="end_date" id="edit_end_date" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Catatan</label>
                        <textarea class="form-control" name="notes" id="edit_notes" rows="3"></textarea>
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

<!-- View Prescription Modal -->
<div class="modal fade" id="viewPrescriptionModal" tabindex="-1" role="dialog"
    aria-labelledby="viewPrescriptionModalLabel">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="viewPrescriptionModalLabel">Detail Pengobatan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row mb-3">
                    <div class="col-sm-4 fw-bold">Pasien</div>
                    <div class="col-sm-8" id="view_patient_name"></div>
                </div>
                <div class="row mb-3">
                    <div class="col-sm-4 fw-bold">Obat</div>
                    <div class="col-sm-8" id="view_medication_name"></div>
                </div>
                <div class="row mb-3">
                    <div class="col-sm-4 fw-bold">Dosis</div>
                    <div class="col-sm-8" id="view_dosage"></div>
                </div>
                <div class="row mb-3">
                    <div class="col-sm-4 fw-bold">Frekuensi</div>
                    <div class="col-sm-8" id="view_frequency"></div>
                </div>
                <div class="row mb-3">
                    <div class="col-sm-4 fw-bold">Periode</div>
                    <div class="col-sm-8">
                        <span id="view_start_date"></span> s/d <span id="view_end_date"></span>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-sm-4 fw-bold">Catatan</div>
                    <div class="col-sm-8" id="view_notes"></div>
                </div>
                <div class="row mb-3">
                    <div class="col-sm-4 fw-bold">Dokter</div>
                    <div class="col-sm-8" id="view_doctor_name"></div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>