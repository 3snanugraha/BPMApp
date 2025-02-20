<!-- Add Doctor Modal -->
<div class="modal fade" id="addDoctorModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Dokter</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="../Controllers/DokterController.php" method="POST">
                <input type="hidden" name="action" value="add_doctor">
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Username</label>
                        <input type="text" class="form-control" name="username" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Password</label>
                        <input type="password" class="form-control" name="password" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" class="form-control" name="email" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Nama Lengkap</label>
                        <input type="text" class="form-control" name="full_name" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Spesialisasi</label>
                        <input type="text" class="form-control" name="specialization" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Nomor Lisensi</label>
                        <input type="text" class="form-control" name="license_number" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Nomor Telepon</label>
                        <input type="text" class="form-control" name="phone_number" required>
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

<!-- Edit Doctor Modal -->
<div class="modal fade" id="editDoctorModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Dokter</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="../Controllers/DokterController.php" method="POST">
                <input type="hidden" name="action" value="edit_doctor">
                <input type="hidden" name="doctor_id" id="edit_doctor_id">
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" class="form-control" name="email" id="edit_email" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Nama Lengkap</label>
                        <input type="text" class="form-control" name="full_name" id="edit_full_name" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Spesialisasi</label>
                        <input type="text" class="form-control" name="specialization" id="edit_specialization" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Nomor Lisensi</label>
                        <input type="text" class="form-control" name="license_number" id="edit_license_number" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Nomor Telepon</label>
                        <input type="text" class="form-control" name="phone_number" id="edit_phone_number" required>
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


<!-- Delete Doctor Modal -->
<div class="modal fade" id="deleteDoctorModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Hapus Dokter</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="../Controllers/DokterController.php" method="POST">
                <input type="hidden" name="action" value="delete_doctor">
                <input type="hidden" name="doctor_id" id="delete_doctor_id">
                <div class="modal-body">
                    <p>Anda yakin ingin menghapus dokter ini?</p>
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

<!-- View Doctor Modal -->
<div class="modal fade" id="viewDoctorModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Detail Dokter</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row mb-3">
                    <div class="col-sm-4 fw-bold">Nama Lengkap</div>
                    <div class="col-sm-8" id="view_full_name"></div>
                </div>
                <div class="row mb-3">
                    <div class="col-sm-4 fw-bold">Username</div>
                    <div class="col-sm-8" id="view_username"></div>
                </div>
                <div class="row mb-3">
                    <div class="col-sm-4 fw-bold">Email</div>
                    <div class="col-sm-8" id="view_email"></div>
                </div>
                <div class="row mb-3">
                    <div class="col-sm-4 fw-bold">Spesialisasi</div>
                    <div class="col-sm-8" id="view_specialization"></div>
                </div>
                <div class="row mb-3">
                    <div class="col-sm-4 fw-bold">Nomor Lisensi</div>
                    <div class="col-sm-8" id="view_license_number"></div>
                </div>
                <div class="row mb-3">
                    <div class="col-sm-4 fw-bold">Nomor Telepon</div>
                    <div class="col-sm-8" id="view_phone_number"></div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>