<?php echo $this->include('bot/bot_partial/dashboard/header'); ?>
<?php echo $this->include('bot/bot_partial/dashboard/top_menu'); ?>
<?php echo $this->include('bot/bot_partial/dashboard/side_menu'); ?>
<script src="https://unpkg.com/@lottiefiles/lottie-player@latest/dist/lottie-player.js"></script>
<main role="main" class="main-content">
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-12">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h2 class="page-title">Aktivasi Chatbot</h2>
                    </div>
                </div>
                <div class="card shadow mb-4">
                    <div class="card-body">
                      <div class="row align-items-center">
                        <div class="col-4 col-md-2 text-center">
                          <a href="profile-posts.html" class="avatar avatar-md">
                          <lottie-player src="https://assets1.lottiefiles.com/private_files/lf30_cwe7aish.json" background="transparent"  speed="1"  style="width: 100px; height: 100px;" loop autoplay></lottie-player>
                          </a>
                        </div>
                        <div class="col">
                        <?php foreach ($pesan_aktivasi as $s) : ?>
                        <p class="small text-muted mb-1">Satu langkah Lagi!! Copy Pesan Dibawah Ini Untuk Aktivasi Chatbot:</p>
                          <h5 class="text-aktivasi" id="text-aktivasi"><strong><?=$s->pesan_aktivasi?></strong></h5>
                        </div>
                        <div class="col-4 col-md-auto offset-4 offset-md-0 my-2">
                          <a id="copyButton" class="btn btn-primary-light">Copy Pesan</a>
                          <a href="https://t.me/d3timadiun_bot" target="_blank" class="btn btn-lg bg-primary-light text-white">Buka Chatbot<i class="fe fe-arrow-right fe-12 ml-2"></i></a>
                        </div>
                        <?php endforeach; ?>
                      </div>
                    </div> <!-- / .card-body -->
                  </div> <!-- / .card -->
        <!-- .row -->
    </div>
</main>
<script>
  document.getElementById('copyButton').addEventListener('click', function() {
    var textToCopy = document.querySelector('#text-aktivasi').innerText;
    navigator.clipboard.writeText(textToCopy)
      .then(function() {
        alert('Teks berhasil disalin!');
      })
      .catch(function() {
        alert('Gagal menyalin teks.');
      });
  });
</script>
<?php echo $this->include('bot/bot_partial/dashboard/footer'); ?>