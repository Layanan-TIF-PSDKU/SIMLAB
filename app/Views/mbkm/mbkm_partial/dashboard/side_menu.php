<aside class="sidebar-left border-right bg-white shadow" id="leftSidebar" data-simplebar>
    <a href="#" class="btn collapseSidebar toggle-btn d-lg-none text-muted ml-2 mt-3" data-toggle="toggle">
        <i class="fe fe-x"><span class="sr-only"></span></i>
    </a>
    <nav class="vertnav navbar navbar-light">
        <!-- nav bar -->
        <div class="w-100 mb-4 d-flex">
            <a class="navbar-brand mx-auto mt-2 flex-fill text-center" href="<?= base_url('') ?>">
                <img src="<?= base_url('../assets/assets/images/logouns.png') ?>" alt="" width="60" height="60">
            </a>
        </div>
        <ul class="navbar-nav flex-fill w-100 mb-2">
            <li class="nav-item w-100 ">
                <a class="nav-link" href="<?= base_url('mbkm')?>">
                    <i class="fe fe-home fe-16"></i>
                    <span class="ml-3 item-text">Dashboard</span>
                </a>
            </li>
        </ul>


        <!-- MBKM -->
        <?php if (has_permission('mahasiswa')) : ?>
        <p class="text-muted nav-heading mt-4 mb-1">
            <span>Pendaftaran MBKM</span>
        </p>
        <ul class="navbar-nav flex-fill w-100 mb-1">
            <li class="nav-item dropdown">
                <a data-toggle="collapse" aria-expanded="false" class="dropdown-toggle nav-link" href="#mbkm">
                    <i class="fe fe-book fe-16"></i>
                    <span class="ml-3 item-text">MBKM</span>
                </a>
                <ul class="collapse list-unstyled pl-4 w-100" id="mbkm">
                    <li class="nav-item">
                        <a class="nav-link pl-3" href="<?=base_url('mbkm/msib')?>"><span
                                class="ml-1 item-text">Pendaftaran MSIB
                                MSIB</span></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link pl-3" href="<?=base_url('mbkm/mbkmProdi')?>"><span class="ml-1 item-text">
                                Pendaftaran MBKM Prodi</span></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link pl-3" href="<?=base_url('mbkm/hibah')?>"><span
                                class="ml-1 item-text">Pendaftaran
                                Hibah UNS</span></a>
                    </li>

                </ul>
            </li>
        </ul>
        <?php elseif (has_permission('dosen') || has_permission('koor-mbkm')): ?>
        <p class="text-muted nav-heading mt-4 mb-1">
            <span>Data Pendaftar MBKM</span>
        </p>
        <ul class="navbar-nav flex-fill w-100 mb-1">
            <li class="nav-item dropdown">
                <a data-toggle="collapse" aria-expanded="false" class="dropdown-toggle nav-link" href="#mbkm">
                    <i class="fe fe-book fe-16"></i>
                    <span class="ml-3 item-text">MBKM</span>
                </a>
                <ul class="collapse list-unstyled pl-4 w-100" id="mbkm">
                    <li class="nav-item">
                        <a class="nav-link pl-3" href="<?=base_url('mbkm/msib')?>"><span class="ml-1 item-text">MBKM
                                MSIB </span></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link pl-3" href="<?=base_url('mbkm/mbkmProdi')?>"><span class="ml-1 item-text">
                                MBKM Prodi</span></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link pl-3" href="<?=base_url('mbkm/hibah')?>"><span class="ml-1 item-text"> MBKM
                                Hibah UNS</span></a>
                    </li>

                </ul>
            </li>
        </ul>
        <?php endif;?>


        <p class="text-muted nav-heading mt-4 mb-1">
            <span>Kegiatan Berlangsung</span>
        </p>
        <ul class="navbar-nav flex-fill w-100 mb-2">
            <li class="nav-item w-100">
                <a class="nav-link" href=" <?= base_url('mbkm/mbkmFix')?>">
                    <i class="fe fe-users fe-16"></i>
                    <span class="ml-3 item-text">MBKM Aktif</span>
                </a>
            </li>
        </ul>
        <ul class="navbar-nav flex-fill w-100 mb-2">
            <li class="nav-item w-100 ">
                <a class="nav-link" href="<?= base_url('mbkm/monitoring')?>">
                    <i class="fe fe-clock fe-16"></i>
                    <span class="ml-3 item-text">Monitoring</span>
                </a>
            </li>
        </ul>

        <?php if (has_permission('dosen') || has_permission('koor-mbkm')) : ?>
        <p class="text-muted nav-heading mt-4 mb-1">
            <span>Menu Dosen</span>
        </p>
        <ul class="navbar-nav flex-fill w-100 mb-2">
            <li class="nav-item w-100">
                <a class="nav-link" href=" <?= base_url('mbkm/berkas')?>">
                    <i class="fe fe-file-text fe-16"></i>
                    <span class="ml-3 item-text">Berkas MBKM</span>
                </a>
            </li>
        </ul>
        <ul class="navbar-nav flex-fill w-100 mb-2">
            <li class="nav-item w-100">
                <a class="nav-link" href=" <?= base_url('mbkm/pertanyaan')?>">
                    <i class="fe fe-folder fe-16"></i>
                    <span class="ml-3 item-text">Indikator Penilaian</span>
                </a>
            </li>
        </ul>

        <ul class="navbar-nav flex-fill w-100 mb-2">
            <li class="nav-item w-100 ">
                <a class="nav-link" href="<?= base_url('mbkm/penilaian')?>">
                    <i class="fe fe-clipboard fe-16"></i>
                    <span class="ml-3 item-text">Penilaian UTS dan UAS</span>
                </a>
            </li>
        </ul>
        <?php endif; ?>
    </nav>
</aside>