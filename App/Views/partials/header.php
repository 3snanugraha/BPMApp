<header class="app-header">
    <nav class="navbar navbar-expand-lg navbar-light">
        <ul class="navbar-nav">
            <li class="nav-item d-block d-xl-none">
                <a class="nav-link sidebartoggler nav-icon-hover" id="headerCollapse" href="javascript:void(0)">
                    <i class="ti ti-menu-2"></i>
                </a>
            </li>
            <?php if ($_SESSION['role'] === 'patient'): ?>
                <li class="nav-item dropdown position-static">
                    <a class="nav-link nav-icon-hover" href="javascript:void(0)" id="notificationDropdown"
                        data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="ti ti-bell-ringing"></i>
                        <div class="notification bg-primary rounded-circle"></div>
                    </a>
                    <?php include 'notification.php'; ?>
                </li>
            <?php endif; ?>
        </ul>
        <div class="navbar-collapse justify-content-end px-0" id="navbarNav">
            <ul class="navbar-nav flex-row ms-auto align-items-center justify-content-end">
                <li class="nav-item dropdown">
                    <a class="nav-link nav-icon-hover" href="javascript:void(0)" id="profileDropdown"
                        data-bs-toggle="dropdown" aria-expanded="false">
                        <img src="assets/images/profile/user-1.jpg" alt="" width="35" height="35"
                            class="rounded-circle">
                    </a>
                    <div class="dropdown-menu dropdown-menu-end dropdown-menu-animate-up"
                        aria-labelledby="profileDropdown">
                        <div class="message-body">
                            <a href="profil.php" class="d-flex align-items-center gap-2 dropdown-item">
                                <i class="ti ti-user fs-6"></i>
                                <p class="mb-0 fs-3">Profil Saya</p>
                            </a>
                            <a href="#" class="d-flex align-items-center gap-2 dropdown-item">
                                <i class="ti ti-heart fs-6"></i>
                                <p class="mb-0 fs-3">Rekam Medis</p>
                            </a>
                            <a href="pencatatan.php" class="d-flex align-items-center gap-2 dropdown-item">
                                <i class="ti ti-heart fs-6"></i>
                                <p class="mb-0 fs-3">Data Tekanan Darah</p>
                            </a>
                            <form action="../Controllers/AuthController.php" method="POST">
                                <input type="hidden" name="action" value="logout">
                                <button type="submit"
                                    class="btn btn-outline-primary mx-3 mt-2 d-block w-100">Keluar</button>
                            </form>
                        </div>
                    </div>
                </li>
            </ul>
        </div>
    </nav>
</header>