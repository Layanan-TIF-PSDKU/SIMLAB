<?= $this->include('master_partial/dashboard/header');?>
<?= $this->include('master_partial/dashboard/top_menu');?>
<?= $this->include('master_partial/dashboard/side_menu');?>
<main role="main" class="main-content">
<div class="container-fluid">
        <div class="row justify-content-center">
        <div class="col-12">
              <h2 class="page-title">Role User</h2>
              
                <div class="col-12 mb-4">
                  <div class="card shadow">
                  <blockquote class="blockquote text-center">
                    <p>Silahkan Bisa Memilih Role Terlebih Dahulu</p>
                        <a href="<?= base_url('staf/user/tambah') ?>" class='btn btn-primary center-block'>Staf</a>
                        <a href="<?= base_url('mahasiswa/user/tambah') ?>" class='btn btn-primary center-block'>Mahasiswa</a>
                        <a href="<?= base_url('mitra/user/tambah') ?>" class='btn btn-primary center-block'>Mitra</a>
                </blockquote>
                </div> <!-- /. col -->
</main>
<?= $this->include('master_partial/dashboard/footer');?>