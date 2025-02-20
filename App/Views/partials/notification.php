<!-- Notification For Patient -->
<?php if ($_SESSION['role'] === 'patient'): ?>
    <div class="dropdown-menu dropdown-menu-end dropdown-menu-animate-up" aria-labelledby="notificationDropdown"
        style="width: 350px; right: auto; left: 0; margin-top: 0;">
        <div class="message-body" style="max-height: 400px; overflow-y: auto;">
            <!-- Latest Recommendations -->
            <div class="notification-header bg-light-info p-2 mb-2">
                <h6 class="mb-0 text-info">Rekomendasi Terbaru</h6>
            </div>
            <div id="latest_recommendations">
                <div class="text-center p-3">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </div>
            </div>

            <!-- Latest Prescriptions -->
            <div class="notification-header bg-light-warning p-2 mb-2">
                <h6 class="mb-0 text-warning">Pengobatan Terbaru</h6>
            </div>
            <div id="latest_prescriptions">
                <div class="text-center p-3">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>