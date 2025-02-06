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
            <p class="breadcrumbs"><span class="mr-2"><a href="<?=base_url('landing')?>">Home</a></span> <span>Tips Karir</span></p>
            <h1 class="mb-3 bread">Tips Karir</h1>
            <p><a href="<?=base_url('tips_karir')?>" class="btn btn-secondary px-4 py-3">Tips Karir Lainnya</a></p>
          </div>
        </div>
      </div>
</div> 
<section class="ftco-section">
    	<div class="container">
    		<div class="row">
                <div class="col-md-12">
                    <td><h1><strong><?= $tips_karir->judul ?></strong></h1></td><br><hr>
                    <td><?= $tips_karir->deskripsi ?></td>
                </div>
    		</div>
    	</div>
</section>
<?php echo $this->include('master_partial/landing/footer');?>  