<!-- Add Recommendation Modal -->
<div class="modal fade" id="addRecommendationModal" tabindex="-1" role="dialog"
    aria-labelledby="addRecommendationModalLabel">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addRecommendationModalLabel">Tambah Rekomendasi</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Patient Selection -->
                <div class="mb-4">
                    <label class="form-label">Pilih Pasien</label>
                    <select class="form-select select2" id="patient_selector" style="width: 100%">
                        <option value="">Pilih pasien...</option>
                    </select>
                </div>

                <!-- Blood Pressure Readings Table -->
                <div id="readings_section" style="display: none;">
                    <h6 class="mb-3">Riwayat Pengukuran Tekanan Darah</h6>
                    <div class="table-responsive mb-4">
                        <table class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th width="5%">Pilih</th>
                                    <th>Tanggal</th>
                                    <th>Systolic</th>
                                    <th>Diastolic</th>
                                    <th>Pulse Rate</th>
                                    <th>Catatan</th>
                                </tr>
                            </thead>
                            <tbody id="readings_table_body">
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Recommendation Form -->
                <form action="../Controllers/RekomendasiController.php" method="POST" id="addRecommendationForm"
                    style="display: none;">
                    <input type="hidden" name="action" value="add_recommendation">
                    <input type="hidden" name="patient_id" id="selected_patient_id">
                    <input type="hidden" name="reading_id" id="selected_reading_id">

                    <div class="mb-3">
                        <label class="form-label">Data Pengukuran Terpilih</label>
                        <div class="alert alert-info" id="selected_reading_info"></div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label" for="add_title">Judul Rekomendasi</label>
                        <input type="text" class="form-control" id="add_title" name="title" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label" for="add_description">Deskripsi Rekomendasi</label>
                        <textarea class="form-control" id="add_description" name="description" rows="4"
                            required></textarea>
                    </div>

                    <div class="modal-footer px-0 pb-0">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan Rekomendasi</button>
                    </div>
                </form>
            </div>
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
            <form action="../Controllers/RekomendasiController.php" method="POST">
                <input type="hidden" name="action" value="edit_recommendation">
                <input type="hidden" name="recommendation_id" id="edit_recommendation_id">
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Data Pengukuran</label>
                        <div class="alert alert-info">
                            Systolic: <span id="edit_reading_systolic"></span> mmHg<br>
                            Diastolic: <span id="edit_reading_diastolic"></span> mmHg<br>
                            Tanggal: <span id="edit_reading_date"></span>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="edit_title">Judul Rekomendasi</label>
                        <input type="text" class="form-control" id="edit_title" name="title" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="edit_description">Deskripsi Rekomendasi</label>
                        <textarea class="form-control" id="edit_description" name="description" rows="4"
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
                <div class="mb-3">
                    <label class="form-label">Data Pengukuran</label>
                    <div class="alert alert-info">
                        Systolic: <span id="view_reading_systolic"></span> mmHg<br>
                        Diastolic: <span id="view_reading_diastolic"></span> mmHg<br>
                        Tanggal: <span id="view_reading_date"></span>
                    </div>
                </div>
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
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>