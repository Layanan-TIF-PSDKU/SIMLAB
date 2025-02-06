<aside class="sidebar-left border-right bg-white shadow" id="leftSidebar" data-simplebar>
    <a href="#" class="btn collapseSidebar toggle-btn d-lg-none text-muted ml-2 mt-3" data-toggle="toggle">
        <i class="fe fe-x"><span class="sr-only"></span></i>
    </a>
    <nav class="vertnav navbar navbar-light">
        <!-- nav bar -->
        <div class="w-100 mb-4 d-flex">
            <a class="navbar-brand mx-auto mt-2 flex-fill text-center" href="<?= base_url('sipema') ?>">
                <img src="<?= base_url('../sipema_assets/img/logo.png') ?>" width="50px" height="50px" class="navbar-brand-img brand-xl" id="logo">
            </a>
        </div>
        <?php if(has_permission('mahasiswa') || has_permission('pimpinan') || has_permission('dosen')) : ?>
        <ul class="navbar-nav flex-fill w-100 mb-2">
            <li class="nav-item w-100 ">
                <a class="nav-link" href="<?= base_url('sipema')?>">
                    <i class="fe fe-home fe-16"></i>
                    <span class="ml-3 item-text">Dashboard</span>
                </a>
            </li>
        </ul>
        <?php endif; ?>
        <?php if(has_permission('pimpinan')|| has_permission('admin')) : ?>
        <p class="text-muted nav-heading mt-4 mb-1">
            <span>Data Master</span>
        </p>
        <ul class="navbar-nav flex-fill w-100 mb-2">
            <li class="nav-item w-100">
                <a class="nav-link" href="<?=base_url('staf')?>">
                    <i class="fe fe-users fe-16"></i>
                    <span class="ml-3 item-text">Staf</span>
                </a>
            </li>
        </ul>
        <ul class="navbar-nav flex-fill w-100 mb-2">
            <li class="nav-item w-100">
                <a class="nav-link" href="<?=base_url('mahasiswa')?>">
                    <i class="fe fe-users fe-16"></i>
                    <span class="ml-3 item-text">Mahasiswa</span>
                </a>
            </li>
        </ul>
        <ul class="navbar-nav flex-fill w-100 mb-2">
            <li class="nav-item w-100">
                <a class="nav-link" href="<?=base_url('mata-kuliah')?>">
                    <i class="fe fe-book fe-16"></i>
                    <span class="ml-3 item-text">Mata Kuliah</span>
                </a>
            </li>
        </ul>
        <?php endif; ?>
        <?php if(has_permission('dosen') || has_permission('pimpinan') || has_permission('admin')) : ?>
        <p class="text-muted nav-heading mt-4 mb-1">
            <span>Pengelolaan Data</span>
        </p>
        <!-- <ul class="navbar-nav flex-fill w-100 mb-2" id="navbar-nav">  -->
          <!-- <li class="nav-item dropdown"> -->
              <!-- <a href="#dashboard" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle nav-link">
                <i class="fe fe-aperture fe-16"></i>
                <span class="ml-3 item-text">Pemetaan Keterampilan</span>
                <span class="sr-only">(current)</span>
              </a> -->
              <!-- <ul class="collapse list-unstyled pl-3 w-100" id="dashboard" data-parent="#navbar-nav"> -->
                <ul class="navbar-nav flex-fill w-100 mb-2">
                <li class="nav-item w-100">
                  <a class="nav-link" href="<?= base_url('sipema/bidang')?>">
                    <i class="fe fe-grid fe-16"></i>
                    <span class="ml-1 item-text">Data Bidang</span>
                  </a>
                </li>
                </ul>
                <ul class="navbar-nav flex-fill w-100 mb-2">
                <li class="nav-item w-100">
                  <a class="nav-link" href="<?= base_url('sipema/sub-bidang')?>">
                    <i class="fe fe-grid fe-16"></i>
                    <span class="ml-1 item-text">Data Sub Bidang</span>
                </a>
                </li>
                </ul>
                <ul class="navbar-nav flex-fill w-100 mb-2">
                <li class="nav-item w-100">
                  <a class="nav-link" href="<?= base_url('sipema/bobot')?>">
                    <i class="fe fe-grid fe-16"></i>
                    <span class="ml-1 item-text">Data Bobot</span>
                  </a>
                </li>
                </ul>
                <ul class="navbar-nav flex-fill w-100 mb-2">
                <li class="nav-item w-100">
                  <a class="nav-link" href="<?= base_url('sipema/pemetaan_mata_kuliah')?>">
                    <i class="fe fe-book fe-16"></i>
                    <span class="ml-1 item-text">Pemetaan Mata Kuliah</span>
                  </a>
                </li>
                </ul>
                <ul class="navbar-nav flex-fill w-100 mb-2">
                <li class="nav-item w-100">
                  <a class="nav-link" href="<?= base_url('sipema/nilai')?>">
                    <i class="fe fe-database fe-16"></i>
                    <span class="ml-1 item-text">Data Nilai</span>
                  </a>
                </li>
                </ul>
                <p class="text-muted nav-heading mt-2 mb-2">
                    <span>Pengelolaan Hasil</span>
                </p>
                <ul class="navbar-nav flex-fill w-100 mb-2">
                <li class="nav-item w-100">
                  <a class="nav-link" href="<?= base_url('sipema/rekomendasi')?>">
                    <i class="fe fe-users fe-16"></i>
                    <span class="ml-1 item-text">Rekomendasi Mahasiswa</span>
                  </a>
                </li>
                </ul>
                <ul class="navbar-nav flex-fill w-100 mb-2">
                <li class="nav-item w-100">
                  <a class="nav-link" href="<?= base_url('sipema/hasil_pemetaan_keterampilan')?>">
                    <i class="fe fe-users fe-16"></i>
                    <span class="ml-1 item-text">Hasil Pemetaan</span>
                  </a>
                </li>
              </ul>
              <?php if(has_permission('pimpinan') || has_permission('admin')) : ?>
              <p class="text-muted nav-heading mt-4 mb-1">
                  <span>Manajemen Akun</span>
              </p>
              <ul class="navbar-nav flex-fill w-100 mb-2">
                  <li class="nav-item w-100">
                      <a class="nav-link" href="<?=base_url('group')?>">
                          <i class="fe fe-users fe-16"></i>
                          <span class="ml-3 item-text">Role</span>
                      </a>
                  </li>
              </ul>
              <ul class="navbar-nav flex-fill w-100 mb-2">
                  <li class="nav-item w-100">
                      <a class="nav-link" href="<?=base_url('users')?>">
                          <i class="fe fe-users fe-16"></i>
                          <span class="ml-3 item-text">User</span>
                      </a>
                  </li>
              </ul>
            <?php endif; ?>
            <?php else : ?>
            <?php endif; ?>
            <!-- </ul> -->
          <!-- </li> -->
        </ul>
    </nav>
</aside>