<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
 
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
 
    <link rel="stylesheet" type="text/css" href="style.css">
    <link rel="stylesheet" href="../assets/css/app-light.css" id="lightTheme">
    <link rel="stylesheet" href="../assets/css/app-dark.css" id="darkTheme">
    <link rel="stylesheet" href="../assets/css/simplebar.css">
    <title>Reset Password | Sistem Informasi Prodi D3 Teknik Informatika Kampus Madiun</title>
    <style>
    @import url('https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap');
 
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
        font-family: 'Poppins', sans-serif;
    }
    
    body {
        width: 100%;
        min-height: 100vh;
        background-image: linear-gradient(rgba(0,0,0,.5), rgba(0,0,0,.5)), url('../assets/assets/images/bg-uns.png');
        background-position: center;
        background-size: cover;
        display: flex;
        justify-content: center;
        align-items: center;
    }
    
    .container {
        width: 400px;
        min-height: 300px;
        background: #FFF;
        border-radius: 30px;
        box-shadow: 0 0 5px rgba(0,0,0,.3);
        padding: 25px 25px;
    }
    
    .container .login-text {
        color: #111;
        font-weight: 500;
        font-size: 1.1rem;
        text-align: center;
        margin-bottom: 20px;
        display: block;
        text-transform: capitalize;
    }
    
    .container .login-email .input-group {
        width: 100%;
        height: 50px;
        margin-bottom: 25px;
    }
    
    .container .login-email .input-group input {
        width: 100%;
        height: 100%;
        border: 2px solid #e7e7e7;
        color: black;
        padding: 15px 20px;
        font-size: 1rem;
        border-radius: 30px;
        background: transparent;
        outline: none;
        transition: .3s;
    }
    
    .container .login-email .input-group input:focus, .container .login-email .input-group input:valid {
        border-color: #a29bfe;
    }
    
    .container .login-email .input-group .btn {
        display: block;
        width: 100%;
        padding: 15px 20px;
        text-align: center;
        border: none;
        background: #a29bfe;
        outline: none;
        border-radius: 30px;
        font-size: 1.2rem;
        color: #FFF;
        cursor: pointer;
        transition: .3s;
    }
    
    .container .login-email .input-group .btn:hover {
        transform: translateY(-5px);
        background: #6c5ce7;
    }
    
    .login-register-text {
        color: #111;
        font-weight: 600;
    }
    
    .login-register-text a {
        text-decoration: none;
        color: #6c5ce7;
    }
    
    .container-logout {
        width: 500px;
        min-height: 200px;
        background: #FFF;
        border-radius: 5px;
        box-shadow: 0 0 5px rgba(0,0,0,.3);
        padding: 40px 30px;
    }

    #btn-login {
       background-color: #167CE9;
    }
    
    .container-logout .login-email .input-group .btn {
        display: block;
        width: 100%;
        padding: 15px 20px;
        text-align: center;
        border: none;
        background: #a29bfe;
        outline: none;
        border-radius: 30px;
        font-size: 1.2rem;
        color: #FFF;
        cursor: pointer;
        transition: .3s;
        margin-top: 20px;
    }
    
    .container-logout .login-email .input-group .btn:hover {
        transform: translateY(-5px);
        background: #6c5ce7;
    }
    
    @media (max-width: 430px) {
        .container {
            width: 300px;
        }
    }
    </style>
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                    <h2 class="card-header text-dark text-center">Reset Password</h2>
            </div>
        </div>
        <p class="text-dark"> Masukkan data-data pada form isian berikut ini untuk keperluan reset password Anda&#128522. </p>
        <form action="<?= url_to('reset-password') ?>" method="post" class="login-email">
        <?= csrf_field() ?>
                <?= view('Myth\Auth\Views\_message_block') ?>
                <div class="input-group">
                    <label for="token" style="color:black"><?=lang('Auth.token')?></label>
                    <input type="text" class="form-control <?php if (session('errors.token')) : ?>is-invalid<?php endif ?>"
                        name="token" placeholder="<?=lang('Auth.token')?>" value="<?= old('token', $token ?? '') ?>">
                    <div class="invalid-feedback">
                        <?= session('errors.token') ?>
                    </div>
                </div>
                <br>
                <div class="input-group">
                    <label for="email" style="color:black"><?=lang('Auth.email')?></label>
                    <input type="email" class="form-control <?php if (session('errors.email')) : ?>is-invalid<?php endif ?>"
                        name="email" aria-describedby="emailHelp" placeholder="Masukkan Email" value="<?= old('email') ?>">
                    <div class="invalid-feedback">
                        <?= session('errors.email') ?>
                    </div>
                </div>
                <br>
                <div class="input-group">
                <label for="password" style="color:black"><?=lang('Auth.newPassword')?></label>
                    <input type="password" class="form-control <?php if (session('errors.password')) : ?>is-invalid<?php endif ?>"
                        name="password" placeholder="Masukkan Password Baru">
                    <div class="invalid-feedback">
                        <?= session('errors.password') ?>
                    </div>
                </div>
                <br>
                <div class="input-group">
                <label for="pass_confirm" style="color:black">Konfirmasi Password Baru</label>
                <input type="password" class="form-control <?php if (session('errors.pass_confirm')) : ?>is-invalid<?php endif ?>"
                        name="pass_confirm" placeholder="Masukkan Konfirmasi Password Baru">
                    <div class="invalid-feedback">
                        <?= session('errors.pass_confirm') ?>
                    </div>
                </div>
            <button type="submit" class="btn btn-primary btn-lg btn-lg mx-2 mt-3"><?=lang('Auth.resetPassword')?></button>
            <a href="<?= url_to('login') ?>" class="btn btn-warning btn-lg mx-2 mt-3">Kembali</a>
        </form>
    </div>
</body>
<script src="../assets/bootstrap.min.js"></script>
<script src="../assets/simplebar.min.js"></script>
</html>
