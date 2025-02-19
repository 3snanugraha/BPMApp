<header class="app-header">
    <nav class="navbar navbar-expand-lg navbar-light">
        <ul class="navbar-nav">
            <li class="nav-item d-block d-xl-none">
                <a class="nav-link sidebartoggler nav-icon-hover" id="headerCollapse" href="javascript:void(0)">
                    <i class="ti ti-menu-2"></i>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link nav-icon-hover" href="./notifications">
                    <i class="ti ti-bell-ringing"></i>
                    <div class="notification bg-primary rounded-circle"></div>
                </a>
            </li>
        </ul>
        <div class="navbar-collapse justify-content-end px-0" id="navbarNav">
            <ul class="navbar-nav flex-row ms-auto align-items-center justify-content-end">
                <li class="nav-item dropdown">
                    <a class="nav-link nav-icon-hover" href="javascript:void(0)" id="drop2" data-bs-toggle="dropdown"
                        aria-expanded="false">
                        <img src="assets/images/profile/user-1.jpg" alt="" width="35" height="35"
                            class="rounded-circle">
                    </a>
                    <div class="dropdown-menu dropdown-menu-end dropdown-menu-animate-up" aria-labelledby="drop2">
                        <div class="message-body">
                            <a href="./profile" class="d-flex align-items-center gap-2 dropdown-item">
                                <i class="ti ti-user fs-6"></i>
                                <p class="mb-0 fs-3">Profil Saya</p>
                            </a>
                            <a href="./medical-records" class="d-flex align-items-center gap-2 dropdown-item">
                                <i class="ti ti-file-medical fs-6"></i>
                                <p class="mb-0 fs-3">Rekam Medis</p>
                            </a>
                            <a href="./bp-readings" class="d-flex align-items-center gap-2 dropdown-item">
                                <i class="ti ti-heart-rate fs-6"></i>
                                <p class="mb-0 fs-3">Data Tekanan Darah</p>
                            </a>
                            <a href="./logout" class="btn btn-outline-primary mx-3 mt-2 d-block">Keluar</a>
                        </div>
                    </div>
                </li>
            </ul>
        </div>
    </nav>
</header>
