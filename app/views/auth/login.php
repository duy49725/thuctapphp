<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/public/css/login.css">
</head>
<body>
    <div class="container">
        <div class="header">
            <h3>Sanshin</h3>
            <p>Hệ thống quản lý đơn</p>
        </div>
        <div class="main">
            <h1>Sanshin IT Solution</h1>
            <form id="form" action="" method="POST">
                <div class="input-container">
                    <label for="">Tên đăng nhập<span id="span_login_identity">*</span></label>
                    <input id="login_identity" type="text" placeholder="Tên đăng nhập" name="username" onkeyup="checkIdentity()">
                </div>
                <div class="input-container">
                    <label class="label-password" for="">Mật khẩu<span id="span_password">*</span></label>
                    <input id="password" type="password" placeholder="Mật khẩu" name="password" onkeyup="checkPassword()">
                </div>
                <div class="button">
                    <button class="login" name="login" type="submit">Login</button>
                    <button class="clear">Clear</button>
                </div>
                <div class="alert-danger-empty">
                    <?php echo $password_err; echo $username_err; ?>
                </div>
            </form>
        </div>
    </div>
</body>
<script>
    document.getElementById('form').addEventListener('submit', (e) => {
        const alert_danger_empty = document.querySelector('.alert-danger-empty');
        const login_identity = document.getElementById('login_identity').value;
        const password = document.getElementById('password').value;
        if(!login_identity){
            e.preventDefault();
            alert_danger_empty.innerHTML = '<div>※Vui lòng nhập tên đăng nhập hoặc email</div>';
        }

        if(!password){
            e.preventDefault();
            alert_danger_empty.innerHTML = '<div>※Vui lòng nhập mật khẩu</div>';
        }

        if(!login_identity && !password){
            e.preventDefault();
            alert_danger_empty.innerHTML = '<div>※Vui lòng nhập mật khẩu và tên đăng nhập hoặc email</div>';
        }
    })

    function checkIdentity(){
        const login_identity = document.getElementById('login_identity').value;
        const span_login_identity = document.getElementById('span_login_identity');
        if(login_identity){
            span_login_identity.style.display = 'none';
        }else{
            span_login_identity.style.display = 'inline';
        }
    }

    function checkPassword(){
        const password = document.querySelector('#password').value;
        console.log(password);
        const span_password = document.getElementById('span_password');
        if(password){
            span_password.style.display = 'none';
        }else{
            span_password.style.display = 'inline';
        }
    }
</script>
</html>