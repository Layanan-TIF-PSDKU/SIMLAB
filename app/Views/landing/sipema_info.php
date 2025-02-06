<?php echo $this->include('master_partial/landing/header');?>
<?php echo $this->include('master_partial/landing/navbar');?>  
    <style>
        :root {
        --warna: <?php echo $cms->warna_bg ?>;
        }
    </style>  
<section class="ftco-section">
    <div class="container">
        <div class="row d-flex">
            <div class="col-md-6 d-flex ftco-animate">
                <div class="img img-about align-self-stretch" style="width: 100%;">
                    <div class="circle-img" style="background-image: url(../sipema_assets/img/logo.png);"></div>
                </div>
            </div>
            <div class="col-md-6 pl-md-5 ftco-animate">
                <h2 class="mb-4">Sistem Informasi Pemetaan Keterampilan</h2>
                <p align="justify">SiPEMA atau Sistem Informasi Pemetaan Keterampilan merupakan sebuah sistem yang dapat membantu civitas akademika pada prodi D3 TI dalam mengetahui minat bidang ataupun sub bidang tiap Mahasiswa Bedasarkan Nilai dan Rekomendasi dari Dosen.</p>
                <div class="accordion w-100" id="accordion1">
                    <div class="card shadow">
                        <div class="card-header" id="heading1">
                            <a role="button" href="#collapse1" data-toggle="collapse" data-target="#collapse1" aria-expanded="false" aria-controls="collapse1">
                                <strong>Panduan Pemakaian</strong>
                            </a>
                        </div>
                        <div id="collapse1" class="collapse" aria-labelledby="heading1" data-parent="#accordion1">
                            <div class="card-body">
                                <p>SiPEMA memiliki antarmuka yang intuitif dan mudah digunakan. Untuk memulai, Anda perlu melakukan login menggunakan akun yang telah terdaftar. Setelah login, Anda akan diarahkan ke halaman utama yang menampilkan berbagai fitur yang tersedia.</p>
                                <p>Untuk mencari minat bidang atau sub bidang tertentu, Anda dapat menggunakan fitur pencarian yang terdapat pada halaman utama. Masukkan kata kunci yang relevan dan sistem akan menampilkan hasil yang sesuai.</p>
                                <p>Anda juga dapat melihat rekomendasi sub bidang dari dosen . Hal ini akan membantu Anda dalam menentukan minat sub bidang yang sesuai dengan potensi Anda.</p>
                            </div>
                        </div>
                    </div>
                    <div class="card shadow">
                        <div class="card-header" id="heading2">
                            <a role="button" href="#collapse2" data-toggle="collapse" data-target="#collapse2" aria-expanded="false" aria-controls="collapse2">
                                <strong>Fitur Utama</strong>
                            </a>
                        </div>
                        <div id="collapse2" class="collapse" aria-labelledby="heading2" data-parent="#accordion1">
                            <div class="card-body">
                                <p>SiPEMA memiliki berbagai fitur utama yang dapat membantu Anda dalam pemetaan keterampilan. Berikut adalah beberapa fitur yang tersedia:</p>
                                <ul>
                                    <li>Pencarian Minat Bidang dan Sub Bidang: Anda dapat mencari minat bidang atau sub bidang tertentu berdasarkan kata kunci yang relevan. Sistem akan menampilkan hasil pencarian data sub bidang dan bidang yang sesuai dengan pencarian Anda.</li>
                                    <li>Rekomendasi Dosen: Dosen yang sesuai dengan sub bidangnya dapat memberikan rekomendasi sub bidang kepada mahasiswa. Rekomendasi ini akan membantu Anda dalam menentukan minat bidang atau sub bidang yang sesuai dengan potensi Anda.</li>
                                </ul>
                                <p>Dengan fitur-fitur ini, SiPEMA akan membantu Anda dalam memahami minat bidang dan sub bidang serta mengembangkan keterampilan yang sesuai dengan potensi Anda.</p>
                            </div>
                        </div>
                    </div>
                    <div class="card shadow">
                        <div class="card-header" id="heading3">
                            <a role="button" href="#collapse3" data-toggle="collapse" data-target="#collapse3" aria-expanded="false" aria-controls="collapse3">
                                <strong>Pertanyaan Umum</strong>
                            </a>
                        </div>
                        <div id="collapse3" class="collapse" aria-labelledby="heading3" data-parent="#accordion1">
                            <div class="card-body">
                                <p>Di sini akan dijelaskan pertanyaan-pertanyaan umum yang sering diajukan tentang Sistem Informasi Pemetaan Keterampilan (SiPEMA). Anda dapat menemukan jawaban untuk pertanyaan-pertanyaan umum yang mungkin Anda miliki seputar penggunaan sistem ini.</p>
                                <ul>
                                    <li><strong>Pertanyaan 1:</strong> Bagaimana cara melakukan pencarian minat bidang atau sub bidang?</li>
                                    <p><strong>Jawaban:</strong> Anda dapat menggunakan fitur pencarian yang terdapat pada halaman utama. Masukkan kata kunci yang relevan dan sistem akan menampilkan hasil yang sesuai dengan pencarian Anda.</p>
                                    <li><strong>Pertanyaan 2:</strong> Bagaimana saya dapat melihat rekomendasi dari dosen?</li>
                                    <p><strong>Jawaban:</strong> Dosen akan memberikan rekomendasi sub bidang kepada Mahasiswa yang dianggap ahli atau kompeten pada sub bidang tersebut. Anda dapat melihat rekomendasi ini pada halaman dashboard Anda.</p>
                                </ul>
                                <p></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="mt-5">
            <a href="<?= base_url('/') ?>" class="btn btn-warning">Kembali</a>
        </div>
    </div>
</section>
<?php echo $this->include('master_partial/landing/footer');?>