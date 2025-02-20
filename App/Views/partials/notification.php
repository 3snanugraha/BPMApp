<!-- Notification For Patient -->
<?php if ($_SESSION['role'] === 'patient'): ?>
    <div class="dropdown-menu dropdown-menu-end dropdown-menu-animate-up">
        <div class="message-body">
            <!-- Latest Recommendations -->
            <div class="notification-header bg-primary text-white p-2 mb-2">
                <h6 class="mb-0">Rekomendasi Terbaru</h6>
            </div>
            <div id="latest_recommendations"></div>

            <!-- Latest Prescriptions -->
            <div class="notification-header bg-primary text-white p-2 mb-2">
                <h6 class="mb-0">Pengobatan Terbaru</h6>
            </div>
            <div id="latest_prescriptions"></div>
        </div>
    </div>
<?php endif; ?>