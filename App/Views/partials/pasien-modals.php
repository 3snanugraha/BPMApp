<!-- Add Patient Modal -->
<div class="modal fade" id="addPatientModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Pasien</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="../Controllers/PasienController.php" method="POST">
                <input type="hidden" name="action" value="add_patient">
                <div class="modal-body">
                    <!-- Account Information -->
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
                    <!-- Personal Information -->
                    <div class="mb-3">
                        <label class="form-label">Nama Lengkap</label>
                        <input type="text" class="form-control" name="full_name" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Tanggal Lahir</label>
                        <input type="date" class="form-control" name="date_of_birth" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Jenis Kelamin</label>
                        <select class="form-select" name="gender" required>
                            <option value="M">Laki-laki</option>
                            <option value="F">Perempuan</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Alamat</label>
                        <textarea class="form-control" name="address" rows="3" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Nomor Telepon</label>
                        <input type="text" class="form-control" name="phone_number" required>
                    </div>
                    <!-- Emergency Contact -->
                    <div class="mb-3">
                        <label class="form-label">Kontak Darurat</label>
                        <input type="text" class="form-control" name="emergency_contact" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Nomor Telepon Darurat</label>
                        <input type="text" class="form-control" name="emergency_phone" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Riwayat Medis</label>
                        <textarea class="form-control" name="medical_history" rows="3"></textarea>
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

<!-- Edit Patient Modal -->
<div class="modal fade" id="editPatientModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Pasien</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="../Controllers/PasienController.php" method="POST">
                <input type="hidden" name="action" value="edit_patient">
                <input type="hidden" name="patient_id" id="edit_patient_id">
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
                        <label class="form-label">Tanggal Lahir</label>
                        <input type="date" class="form-control" name="date_of_birth" id="edit_date_of_birth" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Jenis Kelamin</label>
                        <select class="form-select" name="gender" id="edit_gender" required>
                            <option value="M">Laki-laki</option>
                            <option value="F">Perempuan</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Alamat</label>
                        <textarea class="form-control" name="address" id="edit_address" rows="3" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Nomor Telepon</label>
                        <input type="text" class="form-control" name="phone_number" id="edit_phone_number" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Kontak Darurat</label>
                        <input type="text" class="form-control" name="emergency_contact" id="edit_emergency_contact"
                            required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Nomor Telepon Darurat</label>
                        <input type="text" class="form-control" name="emergency_phone" id="edit_emergency_phone"
                            required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Riwayat Medis</label>
                        <textarea class="form-control" name="medical_history" id="edit_medical_history"
                            rows="3"></textarea>
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

<!-- Delete Patient Modal -->
<div class="modal fade" id="deletePatientModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Hapus Pasien</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="../Controllers/PasienController.php" method="POST">
                <input type="hidden" name="action" value="delete_patient">
                <input type="hidden" name="patient_id" id="delete_patient_id">
                <div class="modal-body">
                    <p>Anda yakin ingin menghapus pasien ini?</p>
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

<!-- View Patient Modal -->
<div class="modal fade" id="viewPatientModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Detail Pasien</h5>
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
                    <div class="col-sm-4 fw-bold">Tanggal Lahir</div>
                    <div class="col-sm-8" id="view_date_of_birth"></div>
                </div>
                <div class="row mb-3">
                    <div class="col-sm-4 fw-bold">Jenis Kelamin</div>
                    <div class="col-sm-8" id="view_gender"></div>
                </div>
                <div class="row mb-3">
                    <div class="col-sm-4 fw-bold">Alamat</div>
                    <div class="col-sm-8" id="view_address"></div>
                </div>
                <div class="row mb-3">
                    <div class="col-sm-4 fw-bold">Nomor Telepon</div>
                    <div class="col-sm-8" id="view_phone_number"></div>
                </div>
                <div class="row mb-3">
                    <div class="col-sm-4 fw-bold">Kontak Darurat</div>
                    <div class="col-sm-8" id="view_emergency_contact"></div>
                </div>
                <div class="row mb-3">
                    <div class="col-sm-4 fw-bold">Nomor Darurat</div>
                    <div class="col-sm-8" id="view_emergency_phone"></div>
                </div>
                <div class="row mb-3">
                    <div class="col-sm-4 fw-bold">Riwayat Medis</div>
                    <div class="col-sm-8" id="view_medical_history"></div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>