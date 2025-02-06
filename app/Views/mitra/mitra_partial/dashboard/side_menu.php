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
                <a class="nav-link" href="<?= base_url('')?>">
                    <i class="fe fe-home fe-16"></i>
                    <span class="ml-3 item-text">Dashboard</span>
                </a>
            </li>
        </ul>

        <!-- MBKM -->
        <p class="text-muted nav-heading mt-4 mb-1">
            <span>Menu MBKM</span>
        </p>
        <ul class="navbar-nav flex-fill w-100 mb-1">
            <li class="nav-item dropdown">
                <a class="nav-link" href=" <?= base_url('mbkm/penilaian')?>">
                    <i class="fe fe-book fe-16"></i>
                    <span class="ml-3 item-text">Penilaian MBKM</span>
                </a>
            </li>
        </ul>

        <!-- KMM -->
        <p class="text-muted nav-heading mt-4 mb-1">
            <span>KMM</span>
        </p>
        <ul class="navbar-nav flex-fill w-100 mb-2">
            <li class="nav-item w-100">
                <a class="nav-link" href=" <?= base_url('kmm/lap-akhir')?>">
                    <i class="fe fe-book fe-16"></i>
                    <span class="ml-3 item-text">Laporan Akhir</span>
                </a>
            </li>
        </ul>
        <ul class="navbar-nav flex-fill w-100 mb-2">
            <li class="nav-item w-100">
                <a class="nav-link" href=" <?= base_url('kmm/penilaian')?>">
                    <i class="fe fe-clipboard fe-16"></i>
                    <span class="ml-3 item-text">Penilaian KMM</span>
                </a>
            </li>
        </ul>
    </nav>
</aside>