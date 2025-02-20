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
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label" for="add_systolic_min">Systolic Min</label>
                                <input type="number" class="form-control" id="add_systolic_min" name="systolic_min"
                                    min="0" max="300" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label" for="add_systolic_max">Systolic Max</label>
                                <input type="number" class="form-control" id="add_systolic_max" name="systolic_max"
                                    min="0" max="300" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label" for="add_diastolic_min">Diastolic Min</label>
                                <input type="number" class="form-control" id="add_diastolic_min" name="diastolic_min"
                                    min="0" max="200" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label" for="add_diastolic_max">Diastolic Max</label>
                                <input type="number" class="form-control" id="add_diastolic_max" name="diastolic_max"
                                    min="0" max="200" required>
                            </div>
                        </div>
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
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label" for="edit_systolic_min">Systolic Min</label>
                                <input type="number" class="form-control" id="edit_systolic_min" name="systolic_min"
                                    min="0" max="300" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label" for="edit_systolic_max">Systolic Max</label>
                                <input type="number" class="form-control" id="edit_systolic_max" name="systolic_max"
                                    min="0" max="300" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label" for="edit_diastolic_min">Diastolic Min</label>
                                <input type="number" class="form-control" id="edit_diastolic_min" name="diastolic_min"
                                    min="0" max="200" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label" for="edit_diastolic_max">Diastolic Max</label>
                                <input type="number" class="form-control" id="edit_diastolic_max" name="diastolic_max"
                                    min="0" max="200" required>
                            </div>
                        </div>
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

<!-- Delete Recommendation Modal -->
<div class="modal fade" id="deleteRecommendationModal" tabindex="-1" role="dialog"
    aria-labelledby="deleteRecommendationModalLabel">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteRecommendationModalLabel">Hapus Rekomendasi</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="../Controllers/RekomendasiController.php" method="POST">
                <input type="hidden" name="action" value="delete_recommendation">
                <input type="hidden" name="recommendation_id" id="delete_recommendation_id">
                <div class="modal-body">
                    <p>Anda yakin ingin menghapus rekomendasi ini?</p>
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
                    <div class="col-sm-4 fw-bold">Range Systolic</div>
                    <div class="col-sm-8">
                        <span id="view_systolic_min"></span> - <span id="view_systolic_max"></span> mmHg
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-sm-4 fw-bold">Range Diastolic</div>
                    <div class="col-sm-8">
                        <span id="view_diastolic_min"></span> - <span id="view_diastolic_max"></span> mmHg
                    </div>
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