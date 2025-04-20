<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
<script src="https://kit.fontawesome.com/45e74edd36.js" crossorigin="anonymous"></script>
<header class="navbar-expand-md">
    <div class="collapse navbar-collapse" id="navbar-menu">
        <div class="navbar">
            <div class="container-xl">
                <ul class="navbar-nav">
                    <?php if (!in_groups('head')) : ?>
                        <li class="nav-item <?= $title === 'Home' ? 'active' : '' ?>">
    <a class="nav-link <?= $title === 'Home' ? 'active' : '' ?>" href="<?= base_url() ?>">
        <span class="nav-link-icon d-md-none d-lg-inline-block">
        <i class="fa-solid fa-house-fire"></i> <!-- Font Awesome icon -->
        </span>
        <span class="nav-link-title">
            Home
        </span>
    </a>
</li>

                    <?php endif; ?>
                    <?php if (in_groups('admin') || in_groups('head')) : ?>
                        <li class="nav-item dropdown <?= ($title === 'Dashboard' || $title === 'Data Pegawai' || $title === 'Data Jabatan' || $title === 'Data Lokasi Presensi' || $title === 'Laporan Presensi Harian' || $title === 'Laporan Presensi Bulanan') ? 'active' : '' ?>">
                        <a class="nav-link dropdown-toggle" href="<?= base_url('/admin') ?>" data-bs-toggle="dropdown" data-bs-auto-close="outside" role="button" aria-expanded="false">
    <span class="nav-link-icon d-md-none d-lg-inline-block">
        <i class="fa-solid fa-users-gear"></i> <!-- Font Awesome icon -->
    </span>
    <span class="nav-link-title">
        Admin
    </span>
</a>

                            <div class="dropdown-menu">
                                <div class="dropdown-menu-columns">
                                    <div class="dropdown-menu-column">
                                        <a class="dropdown-item <?= $title === 'Dashboard' ? 'active' : '' ?>" href="<?= base_url('/admin') ?>">
                                            Dashboard
                                        </a>
                                        <div class="dropend">
                                            <a class="dropdown-item dropdown-toggle <?= $title === 'Data Jabatan' || $title === 'Data Lokasi Presensi' || $title === 'Data Pegawai' ? 'active' : '' ?>" href="<?= base_url('/data-pegawai') ?>" data-bs-toggle="dropdown" data-bs-auto-close="outside" role="button" aria-expanded="false">
                                                Master Data
                                            </a>
                                            <div class="dropdown-menu">
                                                <a href="<?= base_url('/data-pegawai') ?>" class="dropdown-item">
                                                    Data Pegawai
                                                </a>
                                                <a href="<?= base_url('/jabatan') ?>" class="dropdown-item">
                                                    Data Jabatan
                                                </a>
                                                <a href="<?= base_url('/lokasi-presensi') ?>" class="dropdown-item">
                                                    Data Lokasi Presensi
                                                </a>
                                                <a href="<?= base_url('/shift') ?>" class="dropdown-item">
                                                    Data Shift
                                                </a>
                                            </div>
                                        </div>
                                        <div class="dropend">
                                            <a class="dropdown-item dropdown-toggle <?= $title === 'Laporan Presensi Harian' || $title === 'Laporan Presensi Bulanan' ? 'active' : '' ?>" href="<?= base_url('/laporan-presensi-harian') ?>" data-bs-toggle="dropdown" data-bs-auto-close="outside" role="button" aria-expanded="false">
                                                Laporan Presensi
                                            </a>
                                            <div class="dropdown-menu">
                                                <a href="<?= base_url('/laporan-presensi-harian') ?>" class="dropdown-item">
                                                    Laporan Presensi Harian
                                                </a>
                                                <a href="<?= base_url('/laporan-presensi-bulanan') ?>" class="dropdown-item">
                                                    Laporan Presensi Bulanan
                                                </a>
                                            </div>
                                        </div>
                                        <a class="dropdown-item" href="<?= base_url('/shift/setting') ?>">
                                            Setting Shift
                                        </a>
                                    </div>
                                </div>
                        </li>
                    <?php endif; ?>
                    <?php if (!in_groups('head')) : ?>
    <li class="nav-item <?= $title === 'Rekap Presensi' ? 'active' : '' ?>">
        <a class="nav-link" href="<?= base_url('rekap-presensi') ?>">
            <span class="nav-link-icon d-md-none d-lg-inline-block">
                <i class="fa-solid fa-file-contract"></i> <!-- Font Awesome icon -->
            </span>
            <span class="nav-link-title">
                Rekap Presensi
            </span>
        </a>
    </li>
<?php endif; ?>

<li class="nav-item <?= $title === 'Ketidakhadiran' ? 'active' : '' ?>">
    <?php if (!in_groups('head')) : ?>
        <a class="nav-link" href="<?= base_url('/ketidakhadiran') ?>">
            <span class="nav-link-icon d-md-none d-lg-inline-block">
                <i class="fa-solid fa-user-xmark"></i> <!-- Font Awesome icon -->
            </span>
            <span class="nav-link-title">
                Ketidakhadiran
            </span>
        </a>
    <?php endif; ?>
</li>

                    </li>
                    <li class="nav-item <?= $title === 'Kelola Ketidakhadiran' ? 'active' : '' ?>">
                        <?php if (in_groups('head')) : ?>
                            <a class="nav-link" href="<?= base_url('/kelola-ketidakhadiran') ?>">
                                <span class="nav-link-icon d-md-none d-lg-inline-block"><!-- Download SVG icon from http://tabler-icons.io/i/checkbox -->
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-user-x" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <path d="M8 7a4 4 0 1 0 8 0a4 4 0 0 0 -8 0" />
                                        <path d="M6 21v-2a4 4 0 0 1 4 -4h3.5" />
                                        <path d="M22 22l-5 -5" />
                                        <path d="M17 22l5 -5" />
                                    </svg>
                                </span>
                                <span class="nav-link-title">
                                    Ketidakhadiran
                                </span>
                            </a>
                        <?php endif; ?>
                    </li>
                    <li class="nav-item">
    <a class="nav-link" href="<?= base_url('logout') ?>" data-bs-toggle="modal" data-bs-target="#logout-modal">
        <span class="nav-link-icon d-md-none d-lg-inline-block">
            <i class="fa-solid fa-right-from-bracket"></i> <!-- Font Awesome icon -->
        </span>
        <span class="nav-link-title">
            Logout
        </span>
    </a>
</li>

                </ul>
            </div>
        </div>
    </div>
</header>