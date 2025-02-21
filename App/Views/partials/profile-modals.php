<!-- Edit Profile Modal -->
<div class="modal fade" id="editProfileModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Profil</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="../Controllers/ProfileController.php" method="POST">
                <div class="modal-body">
                    <input type="hidden" name="action" value="update_profile">

                    <?php if ($_SESSION['role'] === 'admin'): ?>
                        <div class="mb-3">
                            <label class="form-label">Username</label>
                            <input type="text" class="form-control" name="username"
                                value="<?= htmlspecialchars($profileData['username']) ?>" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" class="form-control" name="email"
                                value="<?= htmlspecialchars($profileData['email']) ?>" required>
                        </div>

                    <?php elseif ($_SESSION['role'] === 'doctor'): ?>
                        <div class="mb-3">
                            <label class="form-label">Nama Lengkap</label>
                            <input type="text" class="form-control" name="full_name"
                                value="<?= htmlspecialchars($profileData['full_name']) ?>" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" class="form-control" name="email"
                                value="<?= htmlspecialchars($profileData['email']) ?>" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Spesialisasi</label>
                            <input type="text" class="form-control" name="specialization"
                                value="<?= htmlspecialchars($profileData['specialization']) ?>" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Nomor Telepon</label>
                            <input type="text" class="form-control" name="phone_number"
                                value="<?= htmlspecialchars($profileData['phone_number']) ?>" required>
                        </div>

                    <?php elseif ($_SESSION['role'] === 'patient'): ?>
                        <div class="mb-3">
                            <label class="form-label">Nama Lengkap</label>
                            <input type="text" class="form-control" name="full_name"
                                value="<?= htmlspecialchars($profileData['full_name']) ?>" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" class="form-control" name="email"
                                value="<?= htmlspecialchars($profileData['email']) ?>" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Tanggal Lahir</label>
                            <input type="date" class="form-control" name="date_of_birth"
                                value="<?= $profileData['date_of_birth'] ?>" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Jenis Kelamin</label>
                            <select class="form-select" name="gender" required>
                                <option value="M" <?= $profileData['gender'] === 'M' ? 'selected' : '' ?>>Laki-laki</option>
                                <option value="F" <?= $profileData['gender'] === 'F' ? 'selected' : '' ?>>Perempuan</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Alamat</label>
                            <textarea class="form-control" name="address" rows="3"
                                required><?= htmlspecialchars($profileData['address']) ?></textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Nomor Telepon</label>
                            <input type="text" class="form-control" name="phone_number"
                                value="<?= htmlspecialchars($profileData['phone_number']) ?>" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Kontak Darurat</label>
                            <input type="text" class="form-control" name="emergency_contact"
                                value="<?= htmlspecialchars($profileData['emergency_contact']) ?>" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Nomor Telepon Darurat</label>
                            <input type="text" class="form-control" name="emergency_phone"
                                value="<?= htmlspecialchars($profileData['emergency_phone']) ?>" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Riwayat Medis</label>
                            <textarea class="form-control" name="medical_history"
                                rows="3"><?= htmlspecialchars($profileData['medical_history']) ?></textarea>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Change Password Modal -->
<div class="modal fade" id="changePasswordModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Ubah Password</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="../Controllers/ProfileController.php" method="POST">
                <div class="modal-body">
                    <input type="hidden" name="action" value="update_password">
                    <div class="mb-3">
                        <label class="form-label">Password Saat Ini</label>
                        <input type="password" class="form-control" name="current_password" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Password Baru</label>
                        <input type="password" class="form-control" name="new_password" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Konfirmasi Password Baru</label>
                        <input type="password" class="form-control" name="confirm_password" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Ubah Password</button>
                </div>
            </form>
        </div>
    </div>
</div>