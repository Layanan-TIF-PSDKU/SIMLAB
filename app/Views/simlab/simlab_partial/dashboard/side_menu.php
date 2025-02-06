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
        <?php if(has_permission('laboran') || has_permission('dosen') || has_permission('mahasiswa')) : ?>
        <ul class="navbar-nav flex-fill w-100 mb-1">
            <li class="nav-item w-100 ">
                <a class="nav-link" href="<?=base_url('simlab')?>">
                    <i class="fe fe-home fe-16"></i>
                    <span class="ml-1 item-text">Dashboard</span>
                </a>
            </li>
        </ul>
        <?php else : ?>
        <?php endif; ?>
        <!-- <p class="text-muted nav-heading mb-2">
            <span>Pengelolaan Data</span>
        </p> -->
        <!-- Data Barang per Ruang -->
        <?php if(has_permission('laboran')) : ?>
        <ul class="navbar-nav flex-fill w-100 mb-1">
            <li class="nav-item dropdown">
                <a data-toggle="collapse" aria-expanded="false" class="dropdown-toggle nav-link"
                    href="#pengelolaan-data">
                    <i class="fe fe-grid fe-16"></i>
                    <span class="ml-1 item-text">Data Master</span>
                </a>
                <ul class="collapse list-unstyled pl-4 w-100" id="pengelolaan-data">

                    <!-- Data Kategori -->
                    <li class="nav-item">
                        <a class="nav-link pl-1" href="<?=base_url('simlab/kategori')?>"><span
                                class="ml-1 item-text">Data Kategori</span></a>
                    </li>
                    <!-- Data Ruang Laboratorium -->
                    <li class="nav-item">
                        <a class="nav-link pl-1" href="<?=base_url('simlab/ruang-laboratorium')?>"><span
                                class="ml-1 item-text">Data Ruang Laboratorium</span></a>
                    </li>
                    <?php else : ?>
                    <?php endif; ?>

                    <!-- Data Alat Laboratorium -->
                    <!-- <li class="nav-item">
                  <a class="nav-link pl-1" href="<?=base_url('simlab/alat-laboratorium')?>"><span class="ml-1 item-text">Data Alat Laboratorium</span></a>
                </li> -->
                </ul>
            </li>
        </ul>

        <?php if(has_permission('laboran')) : ?>
        <p class="text-muted nav-heading mb-2">
            <span>Pencatatan</span>
        </p>
        <?php endif; ?>

        <!--Data Alat Lab  -->
        <?php if(has_permission('laboran') || has_permission('dosen') || has_permission('mahasiswa')) : ?>
        <ul class="navbar-nav flex-fill w-100 mb-1">
            <li class="nav-item w-100">
                <a class="nav-link" href="<?=base_url('simlab/alat-laboratorium')?>">
                    <i class="fe fe-package fe-16"></i>
                    <span class="ml-1 item-text">Alat Laboratorium</span>
                </a>
            </li>
        </ul>
        <?php else : ?>
        <?php endif; ?>
        <?php if(has_permission('laboran')) : ?>
        <ul class="navbar-nav flex-fill w-100 mb-1">
            <li class="nav-item w-100">
                <a class="nav-link" href="<?=base_url('simlab/alat-laboratorium/alat-rusak')?>">
                    <i class="fe fe-log-out fe-16"></i>
                    <span class="ml-1 item-text">Alat Laboratorium Rusak</span>
                </a>
            </li>
        </ul>
        <!--Stok/Barang Keluar  -->
        <ul class="navbar-nav flex-fill w-100 mb-1">
            <li class="nav-item w-100">
                <a class="nav-link" href="<?=base_url('simlab/penghapusan-aset')?>">
                    <i class="fe fe-file-minus fe-16"></i>
                    <span class="ml-1 item-text">Penghapusan Aset</span>
                </a>
            </li>
        </ul>

        <!-- Perawatan Alat Laboratorium -->
        <ul class="navbar-nav flex-fill w-100 mb-1">
            <li class="nav-item w-100">
                <a class="nav-link" href="<?=base_url('simlab/perawatan-alat')?>">
                    <i class="fe fe-layers fe-16"></i>
                    <span class="ml-1 item-text">Perawatan Alat Lab</span>
                </a>
            </li>
        </ul>
        <?php else : ?>
        <?php endif; ?>

        <!-- Jadwal Ruang Laboratorium -->
        <?php if(has_permission('laboran') || has_permission('dosen') || has_permission('mahasiswa')) : ?>
        <ul class="navbar-nav flex-fill w-100 mb-1">
            <li class="nav-item w-100">
                <a class="nav-link" href="<?=base_url('simlab/penggunaan-ruang-laboratorium/pilih-kondisi')?>">
                    <i class="fe fe-calendar fe-16"></i>
                    <span class="ml-1 item-text">Jadwal Ruang Lab</span>
                </a>
            </li>
        </ul>
        <?php else : ?>
        <?php endif; ?>
        <?php if(has_permission('laboran')) : ?>
        <p class="text-muted nav-heading mb-2">
            <span>Peminjaman</span>
        </p>
        <ul class="navbar-nav flex-fill w-100 mb-1">
            <li class="nav-item w-100">
                <a class="nav-link" href="<?=base_url('simlab/transaksi/')?>">
                    <i class="fe fe-shopping-cart fe-16"></i>
                    <span class="ml-1 item-text">Data Peminjaman</span>
                </a>
            </li>
        </ul>

        <p class="text-muted nav-heading mb-2">
            <span>Laporan</span>
        </p>
        <!-- Data Barang per Ruang -->
        <ul class="navbar-nav flex-fill w-100 mb-1">
            <li class="nav-item w-100">
                <a class="nav-link" href="<?=base_url('simlab/laporan')?>">
                    <i class="fe fe-file-text fe-16"></i>
                    <span class="ml-1 item-text">Data Laporan</span>
                </a>
            </li>
        </ul>
        <?php else : ?>
        <?php endif; ?>


        <!-- Dashboard -->
        <?php if(has_permission('laboran') || has_permission('dosen') || has_permission('mahasiswa')) : ?>

        <p class="text-muted nav-heading mb-2">
            <span>Status & Riwayat Peminjaman (Peminjam)</span>
        </p>
        <ul class="navbar-nav flex-fill w-100 mb-1">
            <li class="nav-item w-100">
                <a class="nav-link" href="<?=base_url('simlab/peminjaman/')?>">
                    <i class="fe fe-sidebar fe-16"></i>
                    <span class="ml-1 item-text">Data Peminjaman</span>
                </a>
            </li>
        </ul>


        <?php endif; ?>
        <?php if(has_permission('laboran')) : ?>
        <p class="text-muted nav-heading mb-2">
            <span>Akses Chatbot</span>
        </p>
        <ul class="navbar-nav flex-fill w-100 mb-1">
            <li class="nav-item w-100">
                <a class="nav-link" href="<?=base_url('bot/register_chatbot')?>">
                    <i class="fe fe-message-circle fe-16"></i>
                    <span class="ml-1 item-text">Chatbot D3TI</span>
                </a>
            </li>
        </ul>
        <?php endif; ?>
    </nav>
</aside>