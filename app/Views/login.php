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
    <title>Sistem Informasi Prodi D3 Teknik Informatika Kampus Madiun</title>
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
        min-height: 520px;
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
                    <div class="text-center mt-sm-5 text-black">
                            <div>
                                <a href="index" class="d-inline-block auth-logo">
                                    <img src="../assets/assets/images/logouns.png" alt="" height="100">
                                </a>
                            </div>
                            <p class="mt-3 fs-20 fw-small" style="color:black"><b>Sistem Informasi Prodi D3 Teknik Informatika Kampus Madiun</b></p>
                    </div>
            </div>
        </div>
        <form method="post" action="<?= url_to('login') ?>" class="login-email">
        <?= csrf_field() ?>
                <?= view('Myth\Auth\Views\_message_block') ?>
                <?php if ($config->validFields === ['email']): ?>
                <div class="input-group">
                    <input type="email"
                        class="form-control <?php if (session('errors.login')) : ?>is-invalid<?php endif ?>"
                        name="login" placeholder="<?=lang('Auth.email')?>">
                    <div class="invalid-feedback">
                        <?= session('errors.login') ?>
                    </div>
                </div>
                <?php else: ?>
                <div class="input-group">
                    <input type="text"
                        class="form-control <?php if (session('errors.login')) : ?>is-invalid<?php endif ?>"
                        name="login" placeholder="<?=lang('Auth.emailOrUsername')?>">
                    <div class="invalid-feedback">
                        <?= session('errors.login') ?>
                    </div>
                </div>
                <?php endif; ?>
                <div class="input-group">
                    <input type="password" name="password"
                        class="form-control  <?php if (session('errors.password')) : ?>is-invalid<?php endif ?>"
                        placeholder="<?=lang('Auth.password')?>">
                    <div class="invalid-feedback">
                        <?= session('errors.password') ?>
                    </div>
                </div>
            <div class="input-group">
                <?php if ($config->activeResetter): ?>
                <p><a href="<?= url_to('forgot') ?>">Lupa Password ?</a></p>
                <?php endif; ?>
                <button name="submit" class="btn" id="btn-login">Login</button>
            </div>
        </form>
    </div>
</body>
<script src="../assets/bootstrap.min.js"></script>
<script src="../assets/simplebar.min.js"></script>
</html>