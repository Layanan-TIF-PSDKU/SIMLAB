<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="../assets/css/app-light.css" id="lightTheme">
    <link rel="stylesheet" href="../assets/css/app-dark.css" id="darkTheme">
    <link rel="stylesheet" href="../assets/css/simplebar.css">
    <title>Registrasi | Sistem Informasi Prodi D3 TI Madiun</title>
    
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');
        
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

        .input-group {
            position: relative;
        }

        .toggle-password {
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            font-size: 18px;
            color: #888;
        }

        
        .container {
            width: 400px;
            min-height: 550px;
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
            text-transform: capitalize;
        }
        
        .container .login-email .input-group {
            width: 100%;
            height: 50px;
            margin-bottom: 20px;
        }
        
        .container .login-email .input-group input,
        .container .login-email .input-group select {
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
        
        .container .login-email .input-group input:focus,
        .container .login-email .input-group select:focus {
            border-color: #a29bfe;
        }
        
        .container .login-email .input-group .btn {
            display: block;
            width: 100%;
            padding: 15px 20px;
            text-align: center;
            border: none;
            background: #167CE9;
            outline: none;
            border-radius: 30px;
            font-size: 1.2rem;
            color: #FFF;
            cursor: pointer;
            transition: .3s;
        }
        
        .container .login-email .input-group .btn:hover {
            transform: translateY(-5px);
            background: #125FB7;
        }
        
        .login-register-text {
            color: #111;
            font-weight: 600;
            text-align: center;
        }
        
        .login-register-text a {
            text-decoration: none;
            color: #6c5ce7;
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
        <div class="text-center mt-sm-5 text-black">
            <div>
                <a href="index" class="d-inline-block auth-logo">
                    <img src="../assets/assets/images/logouns.png" alt="" height="100">
                </a>
            </div>
            <p class="mt-3 fs-20 fw-small" style="color:black"><b>Registrasi Akun</b></p>
        </div>
        
        <form method="post" action="<?= base_url('/register') ?>" class="login-email">
            <?= csrf_field() ?>
            <?= view('Myth\\Auth\\Views\\_message_block') ?>
            
            <div class="input-group">
                <input type="text" name="username" class="form-control" placeholder="Username" required>
            </div>
            
            <div class="input-group">
                <input type="email" name="email" class="form-control" placeholder="Email" required>
            </div>
            
            <div class="input-group">
                <input type="password" name="password" class="form-control password-field" placeholder="Password" required>
                <span class="toggle-password"><i class="fa fa-eye"></i></span>
            </div>

            <div class="input-group">
                <input type="password" name="pass_confirm" class="form-control password-field" placeholder="Konfirmasi Password" required>
                <span class="toggle-password"><i class="fa fa-eye"></i></span>
            </div>
            
            <div class="form-group">
                <label for="group_id">Pilih Role</label>
                <select name="group_id" class="form-control" required>
                    <option value="1">Admin</option>
                    <option value="2">Mahasiswa</option>
                    <option value="3">Mitra</option>
                    <option value="3">Dosen</option>
                    <option value="3">Pimpinan</option>
                    <option value="3">Laboran</option>
                </select>
            </div>
            
            <div class="input-group">
                <button type="submit" class="btn">Daftar</button>
            </div>
        </form>
        
        <p class="login-register-text">Sudah punya akun? <a href="<?= base_url('/login') ?>">Login</a></p>
    </div>
</body>
<script src="../assets/bootstrap.min.js"></script>
<script src="../assets/simplebar.min.js"></script>
<script>
    document.querySelectorAll(".toggle-password").forEach(function(element) {
        element.addEventListener("click", function() {
            let passwordField = this.previousElementSibling;
            let icon = this.querySelector("i");

            if (passwordField.type === "password") {
                passwordField.type = "text";
                icon.classList.remove("fa-eye");
                icon.classList.add("fa-eye-slash");
            } else {
                passwordField.type = "password";
                icon.classList.remove("fa-eye-slash");
                icon.classList.add("fa-eye");
            }
        });
    });
</script>
</html>
