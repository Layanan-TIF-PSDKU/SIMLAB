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
            <p class="breadcrumbs"><span class="mr-2"><a href="<?=base_url('landing')?>">Home</a></span> <span>Lowongan Kerja</span></p>
            <h1 class="mb-3 bread">Lowongan Kerja</h1>
            <p><a href="<?=base_url('lowongan_kerja')?>" class="btn btn-secondary px-4 py-3">Lowongan Lainnya</a></p>
          </div>
        </div>
      </div>
</div> 
<section class="ftco-section">
    	<div class="container">
    		<div class="row">
                <div class="col-md-12">
                    <td><strong><?= $lowongan_kerja->nama_perusahaan ?></strong></td><br>
                    <td><strong><?= $lowongan_kerja->posisi_lowongan ?></strong></td><br>
                    <td><strong>Website Perusahaan :</strong> <a href="<?= $lowongan_kerja->link_pt ?>"><?= $lowongan_kerja->link_pt ?></a></td><br>
                    <td>Lowongan ditutup tanggal : <?= $lowongan_kerja->batas_akhir ?></td><br><hr>
                    <td><?= $lowongan_kerja->persyaratan ?></td>
                </div>
    		</div>
    	</div>
</section>
<?php echo $this->include('master_partial/landing/footer');?>  