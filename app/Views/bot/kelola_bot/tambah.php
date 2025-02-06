<?php echo $this->include('bot/bot_partial/dashboard/header'); ?>
<?php echo $this->include('bot/bot_partial/dashboard/top_menu'); ?>
<?php echo $this->include('master_partial/dashboard/side_menu'); ?>
<style>
    .tag-container {
      margin-bottom: 10px;
    }
    .tag-container input[type="text"] {
      margin-right: 5px;
    }
    .remove {
      margin-left: 5px;
      cursor: pointer;
    }
  </style>
<main role="main" class="main-content">
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-12">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h2 class="page-title">Kelola Chatbot</h2>
                    </div>
                </div>
                <div class="col-md-12">
                <div class="card shadow mb-4">
                  <div class="card-header">
                    <strong class="card-title">Tambah Respons Chatbot Telegram</strong>
                  </div>
                  <div class="card-body">
                    <form method="POST" action="<?=base_url("bot/kelola_bot/simpan")?>">
                      <div class="form-group row">
                        <label class="col-sm-12" name= "pesan" for="exampleFormControlTextarea1">Pesan</label>
                        <div class="col-sm-12">
                          <textarea class="form-control" placeholder="Masukkan Pesan" name= "pesan" id="exampleFormControlTextarea1" rows="2"></textarea>
                               <!-- Error Validation -->

                        </div>
                      </div>
                      <div id="formContainer">
                      <!-- Kontainer untuk menampilkan elemen form -->
                      </div>
                      <button type="button" onclick="addTagContainer()" class="btn btn-outline-primary">Tambah Tag</button>
                      <br></br>
                      <div class="form-group mb-2">
                        <button type="submit" class="btn btn-primary">Submit</button>
                      </div>
                    </form>
                  </div>
                </div>
                </div>
                <!-- end section -->
            </div>
            <!-- .col-12 -->
        </div>
        <!-- .row -->
    </div>
    <!-- .container-fluid -->
</main>
<script>
    var formContainer = document.getElementById("formContainer");

    function addTagContainer() {
      var tagContainer = document.createElement("div");
      tagContainer.className = "form-group";

      var tagInput = document.createElement("input");
      tagInput.type = "text";
      tagInput.className = "form-control"
      tagInput.name = "tags[]";
      tagInput.placeholder = "Masukkan tag";
      tagContainer.appendChild(tagInput);

      var removeButton = document.createElement("span");
      removeButton.className = "remove btn btn-danger";
      removeButton.innerHTML = '<i class="fe fe-trash-2"></i>';
      removeButton.addEventListener("click", function() {
        formContainer.removeChild(tagContainer);
      });
      tagContainer.appendChild(removeButton);

      formContainer.appendChild(tagContainer);
    }
  </script>
<?php echo $this->include('bot/bot_partial/dashboard/footer'); ?>