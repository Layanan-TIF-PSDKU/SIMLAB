<?= $this->include('master_partial/dashboard/header'); ?>
<?= $this->include('master_partial/dashboard/top_menu'); ?>
<?= $this->include('master_partial/dashboard/side_menu'); ?>
    <style>
        :root {
        --warna: <?php echo $cms->warna_bg ?>;
        }
    </style>
<main role="main" class="main-content">
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-12">
                <h2 class="mb-2 page-title">Halaman Content Management System</h2>
                <?php
                    if(session()->getFlashData('status')){
                ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <?= session()->getFlashData('status') ?>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <?php
                    }
                    ?>
                <div class="row my-4">
                    <!-- Small table -->
                    <div class="col-md-12">
                        <div class="card shadow">
                            <div class="card-body">
                                <form method="POST" action="<?= base_url('tracer/cms/update/' . $cms->id_cms) ?>" enctype="multipart/form-data">
                                    <em id="pr4" style="display:inline-block; padding:5em;"></em>
                                    <div class="form-group mb-9">
                                        <label for="address-wpalaceholder">Warna</label>
                                        <input type="text" id="address-wpalaceholder" name="warna_bg" class="form-control" onInput="update(this.jscolor, '#pr4')" value="<?= $cms->warna_bg ?>" data-jscolor="{}"/>
                                    </div>
                                    <div class="text-right">
                                        <button class="btn btn-primary" type="submit">Edit</button>
                                        <a href="<?= base_url('tracer/cms'); ?>" class="btn btn-warning text-light">Kembali</a>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <!-- simple table -->
                </div>
                <!-- end section -->
            </div>
            <!-- .col-12 -->
        </div>
        <!-- .row -->
    </div>
    <!-- .container-fluid -->
</main>
<?= $this->include('master_partial/dashboard/footer'); ?>
<script>
	function update(picker, selector) {
		document.querySelector(selector).style.background = picker.toBackground()
	}

	// triggers 'onInput' and 'onChange' on all color pickers when they are ready
	jscolor.trigger('input change');
</script>