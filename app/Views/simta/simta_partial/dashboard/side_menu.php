<aside class="sidebar-left border-right bg-white shadow" id="leftSidebar" data-simplebar>
    <a href="#" class="btn collapseSidebar toggle-btn d-lg-none text-muted ml-2 mt-3" data-toggle="toggle">
        <i class="fe fe-x"><span class="sr-only"></span></i>
    </a>
    <nav class="vertnav navbar navbar-light">
        <!-- nav bar -->
        <div class="w-100 mb-4 d-flex">
            <a class="navbar-brand mx-auto mt-2 flex-fill text-center" href="./index.html">
                <svg version="1.1" id="logo" class="navbar-brand-img brand-sm" xmlns="http://www.w3.org/2000/svg"
                    xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 120 120"
                    xml:space="preserve">
                    <g>
                        <polygon class="st0" points="78,105 15,105 24,87 87,87 	" />
                        <polygon class="st0" points="96,69 33,69 42,51 105,51 	" />
                        <polygon class="st0" points="78,33 15,33 24,15 87,15 	" />
                    </g>
                </svg>
            </a>
        </div>
        <ul class="navbar-nav flex-fill w-100 mb-2">
            <li class="nav-item w-100 ">
                <a class="nav-link" href="<?=base_url('simta')?>">
                    <i class="fe fe-home fe-16"></i>
                    <span class="ml-3 item-text">Dashboard</span>
                </a>
            </li>
        </ul>
        <p class="text-muted nav-heading mt-4 mb-1">
            <span>Menu</span>
        </p>
        <?php if(has_permission('mahasiswa')) : ?>
        <ul class="navbar-nav flex-fill w-100 mb-2">
            <li class="nav-item w-100">
                <a class="nav-link" href="<?= base_url('simta/timeline') ?>">
                    <i class="fe fe-grid fe-16"></i>
                    <span class="ml-1 item-text">Timeline</span>
                </a>
            </li>
        </ul>
        <ul class="navbar-nav flex-fill w-100 mb-2">
            <li class="nav-item w-100">
                <a class="nav-link" href="<?= base_url('simta/taterdahulu') ?>">
                    <i class="fe fe-grid fe-16"></i>
                    <span class="ml-1 item-text">Tugas Akhir Terdahulu</span>
                </a>
            </li>
        </ul>
        <ul class="navbar-nav flex-fill w-100 mb-2">
            <li class="nav-item w-100">
                <a class="nav-link" href="<?= base_url('simta/pengajuanjudul') ?>">
                    <i class="fe fe-grid fe-16"></i>
                    <span class="ml-1 item-text">Pengajuan Judul</span>
                </a>
            </li>
        </ul>
        <ul class="navbar-nav flex-fill w-100 mb-2">
            <li class="nav-item w-100">
                <a class="nav-link" href="<?= base_url('simta/pengajuanbimbingan') ?>">
                    <i class="fe fe-grid fe-16"></i>
                    <span class="ml-1 item-text">Pengajuan Bimbingan</span>
                </a>
            </li>
        </ul>
        <ul class="navbar-nav flex-fill w-100 mb-2">
            <li class="nav-item w-100">
                <a class="nav-link" href="<?= base_url('simta/ujianproposal') ?>">
                    <i class="fe fe-grid fe-16"></i>
                    <span class="ml-1 item-text">Ujian Proposal</span>
                </a>
            </li>
        </ul>
        <ul class="navbar-nav flex-fill w-100 mb-2">
            <li class="nav-item w-100">
                <a class="nav-link" href="<?= base_url('simta/seminarhasil') ?>">
                    <i class="fe fe-grid fe-16"></i>
                    <span class="ml-1 item-text">Seminar Hasil</span>
                </a>
            </li>
        </ul>
        <ul class="navbar-nav flex-fill w-100 mb-2">
            <li class="nav-item w-100">
                <a class="nav-link" href="<?= base_url('simta/ujianta') ?>">
                    <i class="fe fe-grid fe-16"></i>
                    <span class="ml-1 item-text">Ujian Tugas Akhir</span>
                </a>
            </li>
        </ul>
        <?php endif; ?>
        <?php if(has_permission('dosen')) : ?>  
            <ul class="navbar-nav flex-fill w-100 mb-2">
            <li class="nav-item w-100">
                <a class="nav-link" href="<?= base_url('simta/timeline') ?>">
                    <i class="fe fe-grid fe-16"></i>
                    <span class="ml-1 item-text">Timeline</span>
                </a>
            </li>
        </ul>  
        <ul class="navbar-nav flex-fill w-100 mb-2">
            <li class="nav-item w-100">
                <a class="nav-link" href="<?= base_url('simta/pengajuanjudul') ?>">
                    <i class="fe fe-grid fe-16"></i>
                    <span class="ml-1 item-text">Pengajuan Judul</span>
                </a>
            </li>
        </ul>
        <ul class="navbar-nav flex-fill w-100 mb-2">
            <li class="nav-item w-100">
                <a class="nav-link" href="<?= base_url('simta/pengajuanbimbingan') ?>">
                    <i class="fe fe-grid fe-16"></i>
                    <span class="ml-1 item-text">Pengajuan Bimbingan</span>
                </a>
            </li>
        </ul>
        <ul class="navbar-nav flex-fill w-100 mb-2">
            <li class="nav-item w-100">
                <a class="nav-link" href="<?= base_url('simta/ujianproposal') ?>">
                    <i class="fe fe-grid fe-16"></i>
                    <span class="ml-1 item-text">Ujian Proposal</span>
                </a>
            </li>
        </ul>
        <ul class="navbar-nav flex-fill w-100 mb-2">
            <li class="nav-item w-100">
                <a class="nav-link" href="<?= base_url('simta/seminarhasil') ?>">
                    <i class="fe fe-grid fe-16"></i>
                    <span class="ml-1 item-text">Seminar Hasil</span>
                </a>
            </li>
        </ul>
        <ul class="navbar-nav flex-fill w-100 mb-2">
            <li class="nav-item w-100">
                <a class="nav-link" href="<?= base_url('simta/ujianta') ?>">
                    <i class="fe fe-grid fe-16"></i>
                    <span class="ml-1 item-text">Ujian Tugas Akhir</span>
                </a>
            </li>
        </ul>
        <?php endif; ?>
        <?php if(has_permission('koor-simta')) : ?>
            <ul class="navbar-nav flex-fill w-100 mb-2">
            <li class="nav-item w-100">
                <a class="nav-link" href="<?= base_url('simta/timeline') ?>">
                    <i class="fe fe-grid fe-16"></i>
                    <span class="ml-1 item-text">Timeline</span>
                </a>
            </li>
        </ul>
        <ul class="navbar-nav flex-fill w-100 mb-2">
            <li class="nav-item w-100">
                <a class="nav-link" href="<?= base_url('simta/berkas') ?>">
                    <i class="fe fe-grid fe-16"></i>
                    <span class="ml-1 item-text">Berkas</span>
                </a>
            </li>
        </ul>
        <ul class="navbar-nav flex-fill w-100 mb-2">
            <li class="nav-item w-100">
                <a class="nav-link" href="<?= base_url('simta/taterdahulu') ?>">
                    <i class="fe fe-grid fe-16"></i>
                    <span class="ml-1 item-text">Tugas Akhir Terdahulu</span>
                </a>
            </li>
        </ul>
        <ul class="navbar-nav flex-fill w-100 mb-2">
            <li class="nav-item w-100">
                <a class="nav-link" href="<?= base_url('simta/pengajuanjudul') ?>">
                    <i class="fe fe-grid fe-16"></i>
                    <span class="ml-1 item-text">Pengajuan Judul</span>
                </a>
            </li>
        </ul>
        <ul class="navbar-nav flex-fill w-100 mb-2">
            <li class="nav-item w-100">
                <a class="nav-link" href="<?= base_url('simta/pengajuanbimbingan') ?>">
                    <i class="fe fe-grid fe-16"></i>
                    <span class="ml-1 item-text">Pengajuan Bimbingan</span>
                </a>
            </li>
        </ul>
        <ul class="navbar-nav flex-fill w-100 mb-2">
            <li class="nav-item w-100">
                <a class="nav-link" href="<?= base_url('simta/ujianproposal') ?>">
                    <i class="fe fe-grid fe-16"></i>
                    <span class="ml-1 item-text">Ujian Proposal</span>
                </a>
            </li>
        </ul>
        <ul class="navbar-nav flex-fill w-100 mb-2">
            <li class="nav-item w-100">
                <a class="nav-link" href="<?= base_url('simta/seminarhasil') ?>">
                    <i class="fe fe-grid fe-16"></i>
                    <span class="ml-1 item-text">Seminar Hasil</span>
                </a>
            </li>
        </ul>
        <ul class="navbar-nav flex-fill w-100 mb-2">
            <li class="nav-item w-100">
                <a class="nav-link" href="<?= base_url('simta/ujianta') ?>">
                    <i class="fe fe-grid fe-16"></i>
                    <span class="ml-1 item-text">Ujian Tugas Akhir</span>
                </a>
            </li>
        </ul>
        <ul class="navbar-nav flex-fill w-100 mb-2">
            <li class="nav-item w-100">
                <a class="nav-link" href="<?= base_url('simta/bobotpenilaian') ?>">
                    <i class="fe fe-grid fe-16"></i>
                    <span class="ml-1 item-text">Bobot Penilaian</span>
                </a>
            </li>
        </ul>
        <ul class="navbar-nav flex-fill w-100 mb-2">
            <li class="nav-item w-100">
                <a class="nav-link" href="<?= base_url('simta/penilaianakhir') ?>">
                    <i class="fe fe-grid fe-16"></i>
                    <span class="ml-1 item-text">Penilaian Akhir</span>
                </a>
            </li>
        </ul>
        <?php endif; ?>
    </nav>
</aside>