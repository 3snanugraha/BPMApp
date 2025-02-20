<!-- Add Recommendation Modal -->
<div class="modal fade" id="addRecommendationModal" tabindex="-1" role="dialog"
    aria-labelledby="addRecommendationModalLabel">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addRecommendationModalLabel">Tambah Rekomendasi</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="../Controllers/RekomendasiController.php" method="POST" id="addRecommendationForm">
                <input type="hidden" name="action" value="add_recommendation">
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label" for="add_title">Judul Rekomendasi</label>
                        <input type="text" class="form-control" id="add_title" name="title" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="add_description">Deskripsi</label>
                        <textarea class="form-control" id="add_description" name="description" rows="3"
                            required></textarea>
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

<!-- Edit Recommendation Modal -->
<div class="modal fade" id="editRecommendationModal" tabindex="-1" role="dialog"
    aria-labelledby="editRecommendationModalLabel">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editRecommendationModalLabel">Edit Rekomendasi</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="../Controllers/RekomendasiController.php" method="POST" id="editRecommendationForm">
                <input type="hidden" name="action" value="edit_recommendation">
                <input type="hidden" name="recommendation_id" id="edit_recommendation_id">
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label" for="edit_title">Judul Rekomendasi</label>
                        <input type="text" class="form-control" id="edit_title" name="title" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="edit_description">Deskripsi</label>
                        <textarea class="form-control" id="edit_description" name="description" rows="3"
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

<!-- Assign Recommendation Modal -->
<div class="modal fade" id="assignRecommendationModal" tabindex="-1" role="dialog"
    aria-labelledby="assignRecommendationModalLabel">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="assignRecommendationModalLabel">Berikan Rekomendasi ke Pasien</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="../Controllers/RekomendasiController.php" method="POST">
                <input type="hidden" name="action" value="assign_recommendation">
                <input type="hidden" name="patient_id" id="assign_patient_id">
                <input type="hidden" name="reading_id" id="assign_reading_id">
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label" for="assign_recommendation_id">Pilih Rekomendasi</label>
                        <select class="form-select" id="assign_recommendation_id" name="recommendation_id" required>
                            <option value="">Pilih Rekomendasi...</option>
                            <?php foreach ($recommendations as $rec): ?>
                                <option value="<?= $rec['recommendation_id'] ?>"><?= htmlspecialchars($rec['title']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div id="recommendation_preview" class="mb-3 d-none">
                        <label class="form-label">Deskripsi Rekomendasi:</label>
                        <p id="preview_description" class="form-text"></p>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Berikan Rekomendasi</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- View Recommendation Modal -->
<div class="modal fade" id="viewRecommendationModal" tabindex="-1" role="dialog"
    aria-labelledby="viewRecommendationModalLabel">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="viewRecommendationModalLabel">Detail Rekomendasi</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row mb-3">
                    <div class="col-sm-4 fw-bold">Judul</div>
                    <div class="col-sm-8" id="view_title"></div>
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
                <div class="row mb-3">
                    <div class="col-sm-4 fw-bold">Total Pasien</div>
                    <div class="col-sm-8" id="view_total_patients"></div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>