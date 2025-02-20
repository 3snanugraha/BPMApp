<aside class="left-sidebar">
    <div>
        <div class="brand-logo d-flex align-items-center justify-content-between">
            <a href="./index.html" class="text-nowrap logo-img">
                <img src="assets/images/logos/bpm_logo.png" width="120" alt="" />
            </a>
            <div class="close-btn d-xl-none d-block sidebartoggler cursor-pointer" id="sidebarCollapse">
                <i class="ti ti-x fs-8"></i>
            </div>
        </div>
        <nav class="sidebar-nav scroll-sidebar" data-simplebar="">
            <ul id="sidebarnav">
                <li class="nav-small-cap">
                    <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
                    <span class="hide-menu">Menu Utama</span>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link" href="dashboard.php" aria-expanded="false">
                        <span><i class="ti ti-layout-dashboard"></i></span>
                        <span class="hide-menu">Dasbor</span>
                    </a>
                </li>

                <li class="nav-small-cap">
                    <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
                    <span class="hide-menu">Tekanan Darah</span>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link" href="pencatatan.php" aria-expanded="false">
                        <span><i class="ti ti-file"></i></span>
                        <span class="hide-menu">Pencatatan Tekanan</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link" href="riwayat.php" aria-expanded="false">
                        <span><i class="ti ti-chart-line"></i></span>
                        <span class="hide-menu">Riwayat Tekanan</span>
                    </a>
                </li>

                <li class="nav-small-cap">
                    <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
                    <span class="hide-menu">Medis</span>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link" href="obat.php" aria-expanded="false">
                        <span><i class="ti ti-pills"></i></span>
                        <span class="hide-menu">Obat-obatan</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link" href="rekomendasi.php" aria-expanded="false">
                        <span><i class="ti ti-list"></i></span>
                        <span class="hide-menu">Rekomendasi</span>
                    </a>
                </li>

                <li class="nav-small-cap">
                    <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
                    <span class="hide-menu">Pengguna</span>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link" href="dokter.php" aria-expanded="false">
                        <span><i class="ti ti-stethoscope"></i></span>
                        <span class="hide-menu">Dokter</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link" href="pasien.php" aria-expanded="false">
                        <span><i class="ti ti-users"></i></span>
                        <span class="hide-menu">Pasien</span>
                    </a>
                </li>

                <li class="nav-small-cap">
                    <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
                    <span class="hide-menu">Akun</span>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link" href="./profile" aria-expanded="false">
                        <span><i class="ti ti-user-circle"></i></span>
                        <span class="hide-menu">Profil</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <form action="../Controllers/AuthController.php" method="POST" id="logoutForm">
                        <input type="hidden" name="action" value="logout">
                        <a class="sidebar-link" href="javascript:void(0)"
                            onclick="document.getElementById('logoutForm').submit();" aria-expanded="false">
                            <span><i class="ti ti-logout"></i></span>
                            <span class="hide-menu">Keluar</span>
                        </a>
                    </form>
                </li>
            </ul>
            <div class="unlimited-access hide-menu bg-light-primary position-relative mb-7 mt-5 rounded">
                <div class="d-flex">
                    <div class="unlimited-access-title me-3">
                        <h6 class="fw-semibold fs-4 mb-6 text-dark w-85">Laporkan Bug</h6>
                        <a href="https://wa.me/62895339046899" target="_blank"
                            class="btn btn-primary fs-2 fw-semibold lh-sm">Laporkan</a>
                    </div>
                    <div class="unlimited-access-img">
                        <img src="assets/images/backgrounds/rocket.png" alt="" class="img-fluid">
                    </div>
                </div>
            </div>
        </nav>
    </div>
</aside>