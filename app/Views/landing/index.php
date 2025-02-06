<?php echo $this->include('master_partial/landing/header');?>
<?php echo $this->include('master_partial/landing/navbar');?> 
    <style>
        :root {
        --warna: <?php echo $cms->warna_bg ?>;
        }
    </style>  
    <div class="hero-wrap" style="background-image: url('../landing_assets/images/bg-atas.jpg'); background-attachment:fixed;">
      <div class="overlay"></div>
      <div class="container">
        <div class="row no-gutters slider-text align-items-center justify-content-center" data-scrollax-parent="true">
          <div class="col-md-8 ftco-animate text-center">
            <h1 class="mb-4">Layanan Informasi Universitas Sebelas Maret Kampus PSDKU</h1>
            <p><a href="#" class="btn btn-secondary px-4 py-3">Isi Kuesioner</a></p>
          </div>
        </div>
      </div>
    </div>

    <section class="ftco-section">
    	<div class="container">
        <div class="row justify-content-center mb-5 pb-3">
          <div class="col-md-7 heading-section ftco-animate text-center">
            <h2 class="mb-4">Layanan Sistem</h2>
          </div>
        </div>
    		<div class="row">
          <div class="col-md-3 d-flex align-self-stretch ftco-animate">
            <div class="media block-6 services p-3 py-4 d-block text-center">
              <div class="icon d-flex justify-content-center align-items-center mb-3"><span class="flaticon-exam"></span></div>
              <div class="media-body px-3">
                <h3 class="heading">Tracer Study</h3>
                <p><?= word_limiter('Aplikasi tracer study adalah sebuah sistem online yang digunakan sebagai alat pelacakan jejak atau aktivitas alumni perguruan tinggi. Aplikasi tracer study merupakan salah satu instrumen kelengkapan dalam akreditasi perguruan tinggi. Berdasarkan standar Dikti, pelacakan ini biasa dilakukan hingga 2 tahun setelah masa kelulusan. ', 10)?></p>
                <p><a href="<?= base_url('tracer_info') ?>">Selengkapnya <i class="ion-ios-arrow-forward"></i></a></p>
              </div>
            </div>      
          </div>
          <div class="col-md-3 d-flex align-self-stretch ftco-animate">
            <div class="media block-6 services p-3 py-4 d-block text-center">
              <div class="icon d-flex justify-content-center align-items-center mb-3"><span class="flaticon-blackboard"></span></div>
              <div class="media-body px-3">
                <h3 class="heading">SIM TA</h3>
                <p>SIMTA atau Sistem Informasi Tugas Akhir ini merupakan sistem yang digunakan untuk manajement tugas akhir bagi yang terlibat dalam pelaksanaan kegiatan tugas akhir ini.</p>
              </div>
            </div>      
          </div>
          <div class="col-md-3 d-flex align-self-stretch ftco-animate">
            <div class="media block-6 services p-3 py-4 d-block text-center">
              <div class="icon d-flex justify-content-center align-items-center mb-3"><span class="flaticon-books"></span></div>
              <div class="media-body px-3">
                <h3 class="heading">SIM KMM</h3>
                <p>Even the all-powerful Pointing has no control about the blind texts it is an almost unorthographic.</p>
              </div>
            </div>    
          </div>
          <div class="col-md-3 d-flex align-self-stretch ftco-animate">
            <div class="media block-6 services p-3 py-4 d-block text-center">
              <div class="icon d-flex justify-content-center align-items-center mb-3"><span class="flaticon-books"></span></div>
              <div class="media-body px-3">
                <h3 class="heading">SIM MBKM</h3>
                <p>Even the all-powerful Pointing has no control about the blind texts it is an almost unorthographic.</p>
              </div>
            </div>    
          </div>
          <div class="col-md-3 d-flex align-self-stretch ftco-animate">
            <div class="media block-6 services p-3 py-4 d-block text-center">
            <a href="<?= base_url('sipema_info') ?>"><div class="icon d-flex justify-content-center align-items-center mb-3"><img src="<?= base_url('../sipema_assets/img/logo.png') ?>" width="90px" height="90px" class="navbar-brand-img brand-xl" id="logo"></div></a>
              <div class="media-body px-3">
                <a href="<?= base_url('sipema_info') ?>"><h3 class="heading">SIPEMA</h3></a>
                <p align="justify"><?= word_limiter('SiPEMA atau Sistem Informasi Pemetaan Keterampilan merupakan sebuah sistem yang dapat membantu civitas akademika pada prodi D3 Teknik Informatika Kampus Madiun dalam mengetahui minat bidang ataupun sub bidang tiap Mahasiswa Bedasarkan Nilai dan Rekomendasi dari Dosen.', 10) ?></p>
                <p><a href="<?= base_url('sipema_info') ?>">Selengkapnya <i class="ion-ios-arrow-forward"></i></a></p>
              </div>
            </div>    
          </div>
          <div class="col-md-3 d-flex align-self-stretch ftco-animate">
            <div class="media block-6 services p-3 py-4 d-block text-center">
              <div class="icon d-flex justify-content-center align-items-center mb-3"><span class="flaticon-books"></span></div>
              <div class="media-body px-3">
                <h3 class="heading">LAB</h3>
                <p>Even the all-powerful Pointing has no control about the blind texts it is an almost unorthographic.</p>
              </div>
            </div>    
          </div>
          <div class="col-md-3 d-flex align-self-stretch ftco-animate">
            <div class="media block-6 services p-3 py-4 d-block text-center">
              <div class="icon d-flex justify-content-center align-items-center mb-3"><span class="flaticon-books"></span></div>
              <div class="media-body px-3">
                <h3 class="heading">BOT</h3>
                <p>Even the all-powerful Pointing has no control about the blind texts it is an almost unorthographic.</p>
              </div>
            </div>    
          </div>
          <div class="col-md-3 d-flex align-self-stretch ftco-animate">
            <div class="media block-6 services p-3 py-4 d-block text-center">
              <div class="icon d-flex justify-content-center align-items-center mb-3"><span class="flaticon-books"></span></div>
              <div class="media-body px-3">
                <h3 class="heading">PBL</h3>
                <p>Even the all-powerful Pointing has no control about the blind texts it is an almost unorthographic.</p>
              </div>
            </div>    
          </div>
        </div>
    	</div>
    </section>


    <section class="ftco-section-3 img" style="background-image: url(../landing_assets/images/bg_3.jpg);">
    	<div class="overlay"></div>
    	<div class="container">
    		<div class="row d-md-flex justify-content-center">
    			<div class="col-md-9 about-video text-center">
    				<h2 class="ftco-animate">Informasi Lowongan & Tips Karir</h2>
    			</div>
    		</div>
    	</div>
    </section>
    <div class="col-md-12" style="background-color: var(--warna);">
      <div class="container">
        <ul class="nav nav-pills nav-justified" id="pills-tab" role="tablist">
          <li class="nav-item">
            <a class="nav-link active text-light" id="pills-home-tab" data-toggle="pill" href="#pills-home" role="tab" aria-controls="pills-home" aria-selected="true">Lowongan Kerja</a>
          </li>
          <li class="nav-item">
            <a class="nav-link text-light" id="pills-profile-tab" data-toggle="pill" href="#pills-profile" role="tab" aria-controls="pills-profile" aria-selected="false">Informasi Magang</a>
          </li>
          <li class="nav-item">
            <a class="nav-link text-light" id="pills-contact-tab" data-toggle="pill" href="#pills-contact" role="tab" aria-controls="pills-contact" aria-selected="false">Tips Karir</a>
          </li>
        </ul>
      </div>
    </div>
    <section class="ftco-counter bg-light" id="section-counter">
    	<div class="container">
    		<div class="row justify-content-center">
          <div class="tab-content" id="pills-tabContent">
            <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
              <h2 class="mb-4 text-center">Lowongan Kerja</h2>
              <div class="row">
                <div class="col-md-4 d-flex ftco-animate">
                  <div class="course align-self-stretch">
                    <a href="#" class="img" style="background-image: url(../landing_assets/images/course-1.jpg)"></a>
                    <div class="text p-4">
                      <p class="category"><span>PT. Arkatama Multi Solusindo</span></p>
                      <h3 class="mb-3"><a href="#">Programmer</a></h3>
                      <p>Even the all-powerful Pointing has no control about the blind texts it is an almost unorthographic life One day however a small line of blind text by the name</p>
                      <p><a href="#" class="btn btn-primary">Selengkapnya</a></p>
                    </div>
                  </div>
                </div>
                <div class="col-md-4 d-flex ftco-animate">
                  <div class="course align-self-stretch">
                    <a href="#" class="img" style="background-image: url(../landing_assets/images/course-2.jpg)"></a>
                    <div class="text p-4">
                      <p class="category"><span>PT. Mandiri Asta Kencana</span></p>
                      <h3 class="mb-3"><a href="#">UI UX Desain</a></h3>
                      <p>Even the all-powerful Pointing has no control about the blind texts it is an almost unorthographic life One day however a small line of blind text by the name</p>
                      <p><a href="#" class="btn btn-primary">Selengkapnya</a></p>
                    </div>
                  </div>
                </div>
                <div class="col-md-4 d-flex ftco-animate">
                  <div class="course align-self-stretch">
                    <a href="#" class="img" style="background-image: url(../landing_assets/images/course-3.jpg)"></a>
                    <div class="text p-4">
                      <p class="category"><span>PT. Astra Motor Part</span></p>
                      <h3 class="mb-3"><a href="#">Mekanik Engineering</a></h3>
                      <p>Even the all-powerful Pointing has no control about the blind texts it is an almost unorthographic life One day however a small line of blind text by the name</p>
                      <p><a href="#" class="btn btn-primary">Selengkapnya</a></p>
                    </div>
                  </div>
                </div>
                <div class="col-md-12 text-right">
                  <div class="ftco-animate">
                    <p><span>Lihat lowongan lainnya?</span><a href="<?=base_url('lowongan_kerja')?>"> Lihat Semua</a></p>
                  </div>
                </div>
              </div>
            </div>
            <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">
              <h2 class="mb-4 text-center">Informasi Magang</h2>
              <div class="row">
                <div class="col-md-4 d-flex ftco-animate">
                  <div class="course align-self-stretch">
                    <a href="#" class="img" style="background-image: url(../landing_assets/images/course-1.jpg)"></a>
                    <div class="text p-4">
                      <p class="category"><span>PT. Arkatama Multi Solusindo</span></p>
                      <h3 class="mb-3"><a href="#">Programmer</a></h3>
                      <p>Even the all-powerful Pointing has no control about the blind texts it is an almost unorthographic life One day however a small line of blind text by the name</p>
                      <p><a href="#" class="btn btn-primary">Selengkapnya</a></p>
                    </div>
                  </div>
                </div>
                <div class="col-md-4 d-flex ftco-animate">
                  <div class="course align-self-stretch">
                    <a href="#" class="img" style="background-image: url(../landing_assets/images/course-2.jpg)"></a>
                    <div class="text p-4">
                      <p class="category"><span>PT. Mandiri Asta Kencana</span></p>
                      <h3 class="mb-3"><a href="#">UI UX Desain</a></h3>
                      <p>Even the all-powerful Pointing has no control about the blind texts it is an almost unorthographic life One day however a small line of blind text by the name</p>
                      <p><a href="#" class="btn btn-primary">Selengkapnya</a></p>
                    </div>
                  </div>
                </div>
                <div class="col-md-4 d-flex ftco-animate">
                  <div class="course align-self-stretch">
                    <a href="#" class="img" style="background-image: url(../landing_assets/images/course-3.jpg)"></a>
                    <div class="text p-4">
                      <p class="category"><span>PT. Astra Motor Part</span></p>
                      <h3 class="mb-3"><a href="#">Mekanik Engineering</a></h3>
                      <p>Even the all-powerful Pointing has no control about the blind texts it is an almost unorthographic life One day however a small line of blind text by the name</p>
                      <p><a href="#" class="btn btn-primary">Selengkapnya</a></p>
                    </div>
                  </div>
                </div>
                <div class="col-md-12 text-right">
                  <div class="ftco-animate">
                    <p><span>Lihat lowongan lainnya?</span><a href="<?=base_url('informasi_magang')?>"> Lihat Semua</a></p>
                  </div>
                </div>
              </div>
            </div>
            <div class="tab-pane fade" id="pills-contact" role="tabpanel" aria-labelledby="pills-contact-tab">
              <h2 class="mb-4 text-center">Tips Karir</h2>
              <div class="row">
                <div class="col-lg-4 mb-sm-4 ftco-animate">
                  <div class="staff">
                    <div class="d-flex mb-4">
                      <div class="img" style="background-image: url(../landing_assets/images/person_1.jpg);"></div>
                      <div class="info ml-4">
                        <h3><a href="teacher-single.html">Ivan Jacobson</a></h3>
                        <span class="position">CSE Teacher</span>
                        <p class="ftco-social d-flex">
                          <a href="#" class="d-flex justify-content-center align-items-center"><span class="icon-twitter"></span></a>
                          <a href="#" class="d-flex justify-content-center align-items-center"><span class="icon-facebook"></span></a>
                          <a href="#" class="d-flex justify-content-center align-items-center"><span class="icon-instagram"></span></a>
                        </p>
                      </div>
                    </div>
                    <div class="text">
                      <p>Even the all-powerful Pointing has no control about the blind texts it is an almost unorthographic life One day however a small line of blind text by the name</p>
                    </div>
                  </div>
                </div>
                <div class="col-lg-4 mb-sm-4 ftco-animate">
                  <div class="staff">
                    <div class="d-flex mb-4">
                      <div class="img" style="background-image: url(../landing_assets/images/person_2.jpg);"></div>
                      <div class="info ml-4">
                        <h3><a href="teacher-single.html">Ivan Jacobson</a></h3>
                        <span class="position">CSE Teacher</span>
                        <p class="ftco-social d-flex">
                          <a href="#" class="d-flex justify-content-center align-items-center"><span class="icon-twitter"></span></a>
                          <a href="#" class="d-flex justify-content-center align-items-center"><span class="icon-facebook"></span></a>
                          <a href="#" class="d-flex justify-content-center align-items-center"><span class="icon-instagram"></span></a>
                        </p>
                      </div>
                    </div>
                    <div class="text">
                      <p>Even the all-powerful Pointing has no control about the blind texts it is an almost unorthographic life One day however a small line of blind text by the name</p>
                    </div>
                  </div>
                </div>
                <div class="col-lg-4 mb-sm-4 ftco-animate">
                  <div class="staff">
                    <div class="d-flex mb-4">
                      <div class="img" style="background-image: url(../landing_assets/images/person_3.jpg);"></div>
                      <div class="info ml-4">
                        <h3><a href="teacher-single.html">Ivan Jacobson</a></h3>
                        <span class="position">CSE Teacher</span>
                        <p class="ftco-social d-flex">
                          <a href="#" class="d-flex justify-content-center align-items-center"><span class="icon-twitter"></span></a>
                          <a href="#" class="d-flex justify-content-center align-items-center"><span class="icon-facebook"></span></a>
                          <a href="#" class="d-flex justify-content-center align-items-center"><span class="icon-instagram"></span></a>
                        </p>
                      </div>
                    </div>
                    <div class="text">
                      <p>Even the all-powerful Pointing has no control about the blind texts it is an almost unorthographic life One day however a small line of blind text by the name</p>
                    </div>
                  </div>
                </div>
                <div class="col-md-12 text-right">
                  <div class="ftco-animate">
                    <p><span>Lihat Informasi lainnya?</span><a href="<?=base_url('tips_karir')?>"> Lihat Semua</a></p>
                  </div>
                </div>
              </div>
              
            </div>
          </div>
        </div>
    	</div>
    </section>

    <section class="ftco-section testimony-section">
      <div class="container">
      	<div class="row justify-content-center mb-5 pb-3">
          <div class="col-md-7 heading-section ftco-animate text-center">
            <h2 class="mb-4">Alumni Berprestasi</h2>
          </div>
        </div>
        <div class="row">
        	<div class="col-md-12 ftco-animate">
            <div class="carousel-testimony owl-carousel">
              <?php foreach ($alumni_berprestasi as $ab): ?>
              <div class="item">
                <div class="testimony-wrap text-center">
                  <div class="user-img mb-5">
                    <img src="<?= base_url("../tracer_assets/prestasi/$ab->foto") ?>" style="border-radius: 50%; object-fit: cover; width:100%; height:100%;">
                    <span class="quote d-flex align-items-center justify-content-center">
                      <i class="icon-quote-left"></i>
                    </span>
                  </div>
                  <div class="text">
                    <p class="mb-5"><?=$ab->prestasi ?></p>
                    <p class="name"><?=$ab->nama_mahasiswa ?></p>
                    <span class="position"><?=$ab->program_study ?></span>
                  </div>
                </div>
              </div>
              <?php endforeach ?>
            </div>
          </div>
        </div>
      </div>
    </section>

    <section class="ftco-section-parallax">
      <div class="parallax-img d-flex align-items-center">
        <div class="container">
          <div class="row d-flex justify-content-center">
            <div class="col-md-12 text-center heading-section heading-section-white ftco-animate">
              <h2>FAQ</h2>
              <p>Frequently Asked Questions</p>
              <div class="row d-flex justify-content-center">
                <div class="col-md-12 ftco-animate text-center">
                  <?php foreach ($faq as $f): ?>
                  <div class="dropdown">
                    <button class="btn btn-secondary dropdown-toggle btn-block" type="button" id="dropdownMenu2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <?= $f->pertanyaan ?>
                    </button>
                    <div class="dropdown-menu pull-right" aria-labelledby="dropdownMenu2">
                      <button class="dropdown-item" type="button"><?= $f->jawaban ?></button>
                    </div>
                  </div>
                  <br>
                  <?php endforeach ?>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
    <?php echo $this->include('master_partial/landing/footer');?>
