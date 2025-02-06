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
                <a class="nav-link" href="<?=base_url('kmm')?>">
                    <i class="fe fe-home fe-16"></i>
                    <span class="ml-3 item-text">Dashboard</span>
                </a>
            </li>
        </ul>

        <?php if(has_permission('dosen') || has_permission('koor-kmm')) : ?>
        <p class="text-muted nav-heading mt-4 mb-1">
            <span>Pengelolaan</span>
        </p>
        <?php if(has_permission('koor-kmm')): ?>
        <ul class="navbar-nav flex-fill w-100 mb-2">
            <li class="nav-item w-100">
                <a class="nav-link" href="<?=base_url('kmm/berkas')?>"><i class="fe fe-file fe-16"></i><span
                        class="ml-1 item-text">Berkas KMM</span></a>
            </li>
        </ul>
        <?php endif; ?>
        <ul class="navbar-nav flex-fill w-100 mb-2">
            <li class="nav-item w-100">
                <a class="nav-link" href="<?= base_url('kmm/pertanyaan-penilaian') ?>">
                    <i class="fe fe-file fe-16"></i>
                    <span class="ml-1 item-text">Indikator Penilaian</span>
                </a>
            </li>
        </ul>
        <?php if(has_permission('koor-kmm')): ?>
        <ul class="navbar-nav flex-fill w-100 mb-2">
            <li class="nav-item w-100">
                <a class="nav-link" href="<?=base_url('kmm/bobot')?>"><i class="fe fe-file fe-16"></i><span
                        class="ml-1 item-text">Bobot Penilaian</span></a>
            </li>
        </ul>
        <?php endif; ?>
        <?php endif; ?>

        <p class="text-muted nav-heading mt-4 mb-1">
            <span>Menu</span>
        </p>

        <?php if(has_permission('mahasiswa') || has_permission('dosen')) : ?>
        <ul class="navbar-nav flex-fill w-100 mb-2">
            <li class="nav-item w-100">
                <a class="nav-link" href="<?= base_url('kmm/proposal') ?>">
                    <i class="fe fe-file fe-16"></i>
                    <span class="ml-1 item-text">Proposal KMM</span>
                </a>
            </li>
        </ul>
        <?php endif; ?>

        <ul class="navbar-nav flex-fill w-100 mb-2">
            <li class="nav-item w-100">
                <a class="nav-link" href="<?= base_url('kmm/kmm') ?>">
                    <i class="fe fe-file fe-16"></i>
                    <span class="ml-1 item-text">KMM</span>
                </a>
            </li>
        </ul>

        <ul class="navbar-nav flex-fill w-100 mb-2">
            <li class="nav-item w-100">
                <a class="nav-link" href="<?= base_url('kmm/lap-akhir') ?>">
                    <i class="fe fe-file fe-16"></i>
                    <span class="ml-1 item-text">Laporan Akhir KMM</span>
                </a>
            </li>
        </ul>

        <?php if(has_permission('mahasiswa') || has_permission('dosen') || has_permission('koor-kmm')) : ?>
        <ul class="navbar-nav flex-fill w-100 mb-2">
            <li class="nav-item w-100">
                <a class="nav-link" href="<?= base_url('kmm/seminar') ?>">
                    <i class="fe fe-file fe-16"></i>
                    <span class="ml-1 item-text">Seminar KMM</span>
                </a>
            </li>
        </ul>
        <?php endif; ?>

        <?php if(has_permission('dosen') || has_permission('mitra') || has_permission('koor-kmm')) : ?>
        <ul class="navbar-nav flex-fill w-100 mb-2">
            <li class="nav-item w-100">
                <a class="nav-link" href="<?= base_url('kmm/penilaian') ?>">
                    <i class="fe fe-clipboard fe-16"></i>
                    <span class="ml-1 item-text">Penilaian</span>
                </a>
            </li>
        </ul>
        <?php endif; ?>
    </nav>
</aside>