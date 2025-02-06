<?php echo $this->include('master_partial/landing/header'); ?>
<?php echo $this->include('master_partial/landing/navbar'); ?>
    <style>
        :root {
        --warna: <?php echo $cms->warna_bg ?>;
        }
    </style>  
<section class="ftco-section">
    <div class="container">
        <div class="alert alert-info alert-dismissible fade show" role="alert">
            <strong>Halo
                <?php $userName = \Config\Services::authentication()->user()->username; echo $userName;?></strong>
            <?php
            $userId = \Config\Services::authentication()->user()->id;
            $groups = model(GroupModel::class)->getGroupsForUser($userId);
            foreach ($groups as $group) {
                echo " Anda login sebagai ".$group['name']."";
            }
            ?>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    </div>
    <div class="container">
        <div class="text-center">
            <h2 class="page-section-heading text-secondary d-inline-block mb-0">Kumpulan Sistem Informasi</h2>
        </div>
        <div class="container py-5">
            <div class="row">
                <?php if(in_groups('mitra')) : ?>
                <?php else: ?>
                <div class="col-md-4 d-flex ftco-animate">
                    <div class="course align-self-stretch">
                        <a href="#" class="img"
                            style="background-image: url(../landing_assets/images/course-2.jpg)"></a>
                        <div class="text p-4">
                            <p class="category"><span>SIM TA</span></p>
                            <h3 class="mb-3"><a href="#">SIM TA</a></h3>
                            <p>SIMTA atau Sistem Informasi Tugas Akhir ini merupakan sistem yang digunakan 
                                untuk manajement tugas akhir bagi yang terlibat dalam pelaksanaan kegiatan tugas akhir ini.</p>
                            <p><a href="<?=base_url('simta') ?>" class="btn btn-primary">Selengkapnya</a></p>
                        </div>
                    </div>
                </div>
                <?php endif; ?>
                <div class="col-md-4 d-flex ftco-animate">
                    <div class="course align-self-stretch">
                        <a href="#" class="img"
                            style="background-image: url(../landing_assets/images/course-3.jpg)"></a>
                        <div class="text p-4">
                            <p class="category"><span>SIM KMM</span></p>
                            <h3 class="mb-3"><a href="<?= base_url('kmm') ?>" target="_blank">SIM KMM</a></h3>
                            <p>Sistem Informasi Manajemen Magang Mahasiswa</p>
                            <p><a href="<?=base_url('kmm') ?>" class="btn btn-primary" target="_blank">Selengkapnya</a>
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 d-flex ftco-animate">
                    <div class="course align-self-stretch">
                        <a href="#" class="img"
                            style="background-image: url(../landing_assets/images/course-1.jpg)"></a>
                        <div class="text p-4">
                            <p class="category"><span>SIM MBKM</span></p>
                            <h3 class="mb-3"><a href="">SIM MBKM</a></h3>
                            <p>Sistem Informasi Merdeka Belajar - Kampus Merdeka</p>
                            <p><a href="<?=base_url('mbkm') ?>" class="btn btn-primary">Selengkapnya</a></p>
                        </div>
                    </div>
                </div>
                <?php if(in_groups('mitra')) : ?>
                <?php else: ?>
                <div class="col-md-4 d-flex ftco-animate">
                    <div class="course align-self-stretch">
                        <?php if(in_groups('admin')) : ?>
                        <a href="<?= base_url('admin/dashboard') ?>" class="img"
                            style="background-image: url(../sipema_assets/img/logo-rectangle.png)"></a>
                        <?php elseif(in_groups('dosen') || in_groups('pimpinan') || in_groups('mahasiswa')): ?>
                        <a href="<?= base_url('sipema') ?>" class="img"
                            style="background-image: url(../sipema_assets/img/logo-rectangle.png)"></a>
                        <?php endif; ?>
                        <div class="text p-4">
                            <p class="category"><span>SIPEMA</span></p>
                            <?php if(in_groups('admin')) : ?>
                            <h3 class="mb-3"><a href="<?= base_url('admin/dashboard') ?>">SIPEMA</a></h3>
                            <?php elseif(in_groups('dosen') || in_groups('pimpinan') || in_groups('mahasiswa')): ?>
                            <h3 class="mb-3"><a href="<?= base_url('sipema') ?>">SIPEMA</a></h3>
                            <?php endif; ?>
                            <p>SiPEMA atau Sistem Informasi Pemetaan Keterampilan merupakan sebuah sistem yang dapat
                                membantu civitas akademika pada prodi D3 Teknik Informatika Kampus Madiun dalam
                                mengetahui minat bidang ataupun sub bidang tiap Mahasiswa Bedasarkan Nilai dan
                                Rekomendasi dari Dosen</p>
                            <?php if(in_groups('admin')) : ?>
                            <p><a href="<?= base_url('admin/dashboard') ?>" class="btn btn-primary">Akses Sistem</a></p>
                            <?php elseif(in_groups('dosen') || in_groups('pimpinan') || in_groups('mahasiswa')): ?>
                            <p><a href="<?= base_url('sipema') ?>" class="btn btn-primary">Akses Sistem</a></p>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 d-flex ftco-animate">
                    <div class="course align-self-stretch">
                        <a href="<?= base_url('simlab') ?>" class="img"
                            style="background-image: url(../landing_assets/images/course-3.jpg)"></a>
                        <div class="text p-4">
                            <p class="category"><span>SIMLAB</span></p>
                            <h3 class="mb-3"><a href="<?= base_url('simlab') ?>">SIMLAB</a></h3>
                            <p>SIMLAB merupakan Sistem Informasi Manajemen Laboratorium yang digunakan untuk melakukan
                                manajemen serta monitoring penggunaan alat dan ruang laboratorium Prodi D3 Teknik
                                Informatika PSDKU</p>
                            <p><a href="<?= base_url('simlab') ?>" class="btn btn-primary">Selengkapnya</a></p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 d-flex ftco-animate">
                    <div class="course align-self-stretch">
                        <a href="#" class="img"
                            style="background-image: url(../landing_assets/images/course-3.jpg)"></a>
                        <div class="text p-4">
                            <p class="category"><span>CHATBOT</span></p>
                            <h3 class="mb-3"><a href="bot">CHATBOT</a></h3>
                            <p>Pengelolaan Layanan Chatbot Prodi D3 Teknik Informatika PSDKU</p>
                            <p><a href="bot" class="btn btn-primary">Selengkapnya</a></p>
                        </div>
                    </div>
                </div>
                <?php endif; ?>
            </div>
            <div class="row mt-5">
                <div class="col text-center">
                    <div class="block-27">
                        <ul>
                            <li><a href="#">&lt;</a></li>
                            <li class="active"><span>1</span></li>
                            <li><a href="#">2</a></li>
                            <li><a href="#">3</a></li>
                            <li><a href="#">4</a></li>
                            <li><a href="#">5</a></li>
                            <li><a href="#">&gt;</a></li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="text-center mt-5">
                <h2 class="page-section-heading text-secondary d-inline-block mb-0">Tracer Study</h2>
            </div>
            <div class="container py-5">
                <div class="row">
                    <div class="col-md-4 d-flex ftco-animate">
                        <div class="course align-self-stretch">
                            <a href="#" class="img"
                                style="background-image: url(../landing_assets/images/course-3.jpg)"></a>
                            <div class="text p-4">
                                <p class="category"><span>Tracer Study</span></p>
                                <h3 class="mb-3"><a href="#">Tracer Study</a></h3>
                                <p>Even the all-powerful Pointing has no control about the blind texts it is an almost
                                    unorthographic
                                    life One day however a small line of blind text by the name</p>
                                <p><a href="<?= base_url('tracer') ?>" class="btn btn-primary">Selengkapnya</a></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<?php echo $this->include('master_partial/landing/footer'); ?>