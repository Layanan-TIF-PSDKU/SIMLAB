<nav class="navbar navbar-expand-lg navbar-dark ftco_navbar bg-dark ftco-navbar-light" id="ftco-navbar">
    <div class="container">
    <div class="row">
    <a class="navbar-brand" href="index.html"><img class="images" style="height: 60px;" src="<?=base_url('../landing_assets/images/logo-uns-biru.png')?>"></a>
    </div>
      <div class="col">
        <a class="navbar-brand" href="index.html">
          D3 Teknik Informatika
        </a>
        <a class="navbar-brand"><small>Universitas Sebelas Maret</small></a>
      </div>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#ftco-nav" aria-controls="ftco-nav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="oi oi-menu"></span> Menu
      </button>
      <div class="collapse navbar-collapse" id="ftco-nav">
        <ul class="navbar-nav ml-auto">
          <li <?php if ($page == "Home") echo "class='nav-item active'"; ?> class="nav-item"><a href="<?=base_url('/')?>" class="nav-link">Home</a></li>
          <?php if (\Config\Services::authentication()->check() === true): ?>
            <li <?php if ($page == "Sistem Informasi") echo "class='nav-item active'"; ?> class="nav-item"><a href="<?=base_url('sistem_informasi')?>" class="nav-link">Sistem Informasi</a></li>
          <?php endif; ?>
          <li <?php if ($page == "Lowongan Kerja") echo "class='nav-item active'"; ?> class="nav-item"><a href="<?=base_url('lowongan_kerja')?>" class="nav-link">Lowongan Kerja</a></li>
          <li <?php if ($page == "Informasi Magang") echo "class='nav-item active'"; ?> class="nav-item"><a href="<?=base_url('informasi_magang')?>" class="nav-link">Informasi Magang</a></li>
          <li <?php if ($page == "Tips Karir") echo "class='nav-item active'"; ?> class="nav-item"><a href="<?=base_url('tips_karir')?>" class="nav-link">Tips Karir</a></li>
          <li <?php if ($page == "Agenda") echo "class='nav-item active'"; ?> class="nav-item"><a href="<?=base_url('agenda')?>" class="nav-link">Agenda</a></li>
          <?php if (\Config\Services::authentication()->check() === true): ?>
            <li class="nav-item cta"><a href="<?=base_url('/logout')?>" class="nav-link"><span>Logout</span></a></li>
          <?php else : ?>
            <li class="nav-item cta"><a href="<?=base_url('/login')?>" class="nav-link"><span>Login</span></a></li>
          <?php endif; ?>
        </ul>
      </div>
    </div>
</nav>