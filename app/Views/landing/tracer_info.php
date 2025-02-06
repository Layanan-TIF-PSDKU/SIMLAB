<?php echo $this->include('master_partial/landing/header');?>
<?php echo $this->include('master_partial/landing/navbar');?> 
    <style>
        :root {
        --warna: <?php echo $cms->warna_bg ?>;
        }
    </style>  
<div class="hero-wrap hero-wrap-2" style="background-image: url('../landing_assets/images/bg_2.jpg'); background-attachment:fixed;">
      <div class="overlay"></div>
      <div class="container">
        <div class="row no-gutters slider-text align-items-center justify-content-center" data-scrollax-parent="true">
          <div class="col-md-8 ftco-animate text-center">
            <p class="breadcrumbs"><span class="mr-2"><a href="<?=base_url('/')?>">Home</a></span> <span>Tracer Study</span></p>
            <h1 class="mb-3 bread">TRACER STUDY</h1>
          </div>
        </div>
      </div>
</div> 
<section class="ftco-section">
    <div class="container">
        <div class="row d-flex">
            <div class="col-md-6 pl-md-5 ftco-animate">
                <h2 class="mb-12">Apa itu Tracer Study?</h2>
                <p align="justify">Aplikasi tracer study adalah sebuah sistem online yang digunakan sebagai alat pelacakan jejak atau aktivitas alumni perguruan tinggi. Aplikasi tracer study merupakan salah satu instrumen kelengkapan dalam akreditasi perguruan tinggi. Berdasarkan standar Dikti, pelacakan ini biasa dilakukan hingga 2 tahun setelah masa kelulusan.</p>
                <h2 class="mb-12">Tujuan Tracer Study</h2>
                <p align="justify">Aplikasi tracer study dikembangkan dengan tujuan untuk mengetahui outcome perguruan tinggi dalam bentuk transisi dari dunia perguruan tinggi ke dunia kerja, situasi kerja, dan  kompetensi di dunia kerja. Selain itu, aplikasi tracer study juga bertujuan untuk sarana evaluasi pembelajaran selama di perguruan tinggi.</p>
            </div>
            <div class="col-md-6 pl-md-5 ftco-animate">
                <h2 class="mb-12">Tentang Tracer Study.</h2>
                <div class="accordion w-100" id="accordion1">
                    <div class="card shadow">
                        <div class="card-header" id="heading1">
                            <a role="button" href="#collapse1" data-toggle="collapse" data-target="#collapse1" aria-expanded="false" aria-controls="collapse1">
                                <strong>Panduan Pemakaian</strong>
                            </a>
                        </div>
                        <div id="collapse1" class="collapse" aria-labelledby="heading1" data-parent="#accordion1">
                            <div class="card-body">
                                <p>Untuk melakukan pengisian tracer, pertama tama alumni masuk kehalaman login terlebih dahulu. Masuk sesuai dengan username yang dimiliki oleh alumni.</p>
                                <p>Setelah login alumni akan menuju ke halaman sistem informasi, kemudian pilih menu tracer. Setelah itu akan masuk ke halaman dashboard tracer.</p>
                                <p>Di dalam halaman dashboard tracer terdapat informasi jadwal kuesioner sesuai tahun lulusan alumni. Kemudian pilih menu isi kuesioner setelah itu terdapat tabel jadwal kuesioner. Klik isi kuesioner sesuai jadwal, setelah itu alumni sudah bisa untuk mengisi kuesioner.</p>
                                <p>Jika semua kuesioner sudah diisi klik tombol simpan, setelah itu muncul notifikasi anda sudah mengisi kuesioner, di dalam notifikasi anda dapat mencetak hasil bukti telah mengisi kuesioner.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<?php echo $this->include('master_partial/landing/footer');?>  