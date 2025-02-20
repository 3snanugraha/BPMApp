<!-- Add Medication Modal -->
<div class="modal fade" id="addMedicationModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Obat</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="../Controllers/ObatObatanController.php" method="POST">
                <input type="hidden" name="action" value="add_medication">
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Nama Obat</label>
                        <input type="text" class="form-control" name="name" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Dosis</label>
                        <input type="text" class="form-control" name="dosage_form" placeholder="Contoh: Tablet 5mg"
                            required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Deskripsi</label>
                        <textarea class="form-control" name="description" rows="3" required></textarea>
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

<!-- Edit Medication Modal -->
<div class="modal fade" id="editMedicationModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Obat</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="../Controllers/ObatObatanController.php" method="POST">
                <input type="hidden" name="action" value="edit_medication">
                <input type="hidden" name="medication_id" id="edit_medication_id">
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Nama Obat</label>
                        <input type="text" class="form-control" name="name" id="edit_name" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Dosis</label>
                        <input type="text" class="form-control" name="dosage_form" id="edit_dosage_form"
                            placeholder="Contoh: Tablet 5mg" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Deskripsi</label>
                        <textarea class="form-control" name="description" id="edit_description" rows="3"
                            required></textarea>
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

<!-- Delete Medication Modal -->
<div class="modal fade" id="deleteMedicationModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Hapus Obat</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="../Controllers/ObatObatanController.php" method="POST">
                <input type="hidden" name="action" value="delete_medication">
                <input type="hidden" name="medication_id" id="delete_medication_id">
                <div class="modal-body">
                    <p>Anda yakin ingin menghapus obat ini?</p>
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

<!-- View Medication Modal -->
<div class="modal fade" id="viewMedicationModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Detail Obat</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row mb-3">
                    <div class="col-sm-4 fw-bold">Nama Obat</div>
                    <div class="col-sm-8" id="view_name"></div>
                </div>
                <div class="row mb-3">
                    <div class="col-sm-4 fw-bold">Dosis</div>
                    <div class="col-sm-8" id="view_dosage_form"></div>
                </div>
                <div class="row mb-3">
                    <div class="col-sm-4 fw-bold">Deskripsi</div>
                    <div class="col-sm-8" id="view_description"></div>
                </div>
                <div class="row mb-3">
                    <div class="col-sm-4 fw-bold">Dibuat Oleh</div>
                    <div class="col-sm-8" id="view_created_by"></div>
                </div>
                <div class="row mb-3">
                    <div class="col-sm-4 fw-bold">Tanggal Dibuat</div>
                    <div class="col-sm-8" id="view_created_at"></div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>