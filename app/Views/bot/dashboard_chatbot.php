<?php echo $this->include('bot/bot_partial/dashboard/header'); ?>
<?php echo $this->include('bot/bot_partial/dashboard/top_menu'); ?>
<?php if(has_permission('admin')) : ?>
<?php echo $this->include('master_partial/dashboard/side_menu') ?>
<?php else : ?>
<?php echo $this->include('bot/bot_partial/dashboard/side_menu'); ?>
<script src="https://unpkg.com/@lottiefiles/lottie-player@latest/dist/lottie-player.js"></script>
<?php endif; ?><main role="main" class="main-content">
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-12">
                <div class="row align-items-center mb-2">
                    <div class="col mb-4 mt-2">
                        <h2 class="h5 page-title">Selamat Datang di Pengelolaan Chatbot D3TI PSDKU,
                            <?= user()->username; ?> &#128522 </h2>
                        <div class="file-container border-top">
                            <div class="mt-3">
                            <div class="col-md-12 mb-4">
                  <div class="card profile shadow">
                    <div class="card-body my-4">
                      <div class="row align-items-center">
                        <div class="col-md-4 text-center mb-5">
                          <a href="#!" class="avatar avatar-xl">
                          <lottie-player src="https://assets10.lottiefiles.com/packages/lf20_NtbVtxMyCa.json" background="transparent"  speed="1"  style="width: 220px; height: 220px;" loop autoplay></lottie-player>
                          </a>
                        </div>
                        <div class="col">
                          <div class="row align-items-center">
                            <div class="col-md-7">
                              <h4 class="mb-1">Chatbot</h4>
                            </div>
                            <div class="col">
                            </div>
                          </div>
                          <div class="row mb-4">
                            <div class="col-md-9">
                              <p class="text-muted">Chatbot adalah fitur untuk mencari informasi tentang kegiatan prodi dan informasi lain terkait dengan perkuliahan dengan cara interaksi secara langsung dengan bot Telegram, selain itu aplikasi juga dapat menerima notifikasi multiplatform yang digunakan oleh prodi untuk memberikan informasi</p>
                            </div>
                          </div>
                          <div class="row align-items-center">
                            <div class="col mb-2">
                              <a href="<?=base_url("bot/register_chatbot")?>" class="btn btn-lg bg-primary-light text-white">Mulai<i class="fe fe-arrow-right fe-16 ml-2"></i></a>
                            </div>
                          </div>
                        </div>
                      </div> <!-- / .row- -->
                    </div> <!-- / .card-body - -->
                  </div> <!-- / .card- -->
                </div> <!-- / .col- -->
              </div> <!-- end section -->
                                    </div> <!-- .col -->
                                </div> <!-- .col -->
                            </div> <!-- .col -->
                        </div> <!-- .col -->
                    </div>
                </div>
                <!-- .card-body -->
            </div>
            <!-- .card -->
        </div>
        <!-- .card -->
    </div>
    <!-- .col -->
    </div>
    <div class="">
        <h2 class=""> Manual Book</h2>
    </div>



    <i class=" fe fe-book-open fa-2x">
    </i>




    </div>
    <!-- / .card-body -->
    </div>
    </div>
    <!-- / .card -->

    <!-- Striped rows -->
    </div>
    <!-- .row-->
    </div>
    <!-- .col-12 -->
    </div>
    <!-- .row -->
    </div>
    <!-- .container-fluid -->


</main>
<?php echo $this->include('bot/bot_partial/dashboard/footer'); ?>