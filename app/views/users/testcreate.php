<div class="right">
    <p>Thêm mới người dùng<p>
    <form action="<?php echo BASE_URL; ?>/public/index.php?url=users/testcreate" method="POST">
        <div class="input-container" style="<?php echo  $username_err ? 'margin-bottom: 70px' : 'margin-bottom: 40px'; ?>">
            <div class="form-container">
                <label for="">Tên đăng nhập</label>
                <input id="username" type="text" name="username" value="<?php echo $username; ?>">
            </div>
            <div class="check check-username" ><?php echo $username_err; ?></div>
        </div>
        <div class="input-container" style="<?php echo  $fullname_err ? 'margin-bottom: 70px' : 'margin-bottom: 40px'; ?>">
            <div class="form-container">
                <label for="">Tên người dùng</label>
                <input id="fullname" type="text" name="fullname" value="<?php echo $fullname; ?>">
            </div>
            <span class="check check-fullname"><?php echo $fullname_err; ?></span>
        </div>
        <div class="input-container" style="<?php echo  $password_err ? 'margin-bottom: 70px' : 'margin-bottom: 40px'; ?>">
            <div class="form-container">
                <label for="">Mật khẩu</label>
                <input id="password" type="password" name="password" value="<?php echo $password; ?>">
            </div>
            <span class="check check-password"><?php echo $password_err; ?></span>
        </div>
        <div class="input-container" style="<?php echo  $email_err ? 'margin-bottom: 70px' : 'margin-bottom: 40px'; ?>">
            <div class="form-container">
                <label for="">Email</label>
                <input id="email" type="email" name="email" value="<?php echo $email; ?>">
            </div>
            <span class="check check-email"><?php echo $email_err; ?></span>
        </div>
        <div class="input-container"> 
            <div class="form-container">
                <label for="">Ngày sinh</label>
                <div class="date-container">
                    <input id="datetime" value="<?php echo $birthDate; ?>" onchange="changeDate()" type="date" name="birthDate" style="width: 189px; height: 40px;  padding: 5px;">
                </div>
            </div>
        </div>
        <div class="input-container" style="margin-bottom: 40px">
            <div class="form-container select">
                <label for="">Loại người dùng</label>
                <div class="categoryUser-container">
                    <select name="categoryUser" >
                        <option value="Quản lý" <?php echo ($categoryUser == 'Quản lý') ? 'selected' : ''; ?>>Quản lý</option>
                        <option value="Nhân viên" <?php echo ($categoryUser == 'Nhân viên') ? 'selected' : ''; ?>>Nhân viên</option>
                    </select>
                </div>
            </div>
            <span class="check check-email"><?php echo $categoryUser_err; ?></span>
        </div>
        <div class="input-container" style="margin-bottom: 40px">
            <div class="form-container select">
                <label for="">Trạng thái</label>
                <div class="categoryUser-container">
                    <select name="status">
                        <option value="Đang hoạt động" <?php echo ($status === 'Đang hoạt động') ? 'selected' : ''; ?>>Đang hoạt động</option>
                        <option value="Đã khóa" <?php echo ($status == 'Đã khóa') ? 'selected' : ''; ?>>Đã khóa</option>
                    </select>
                </div>
            </div>
            <span class="check check-email"><?php echo $status_err; ?></span>
        </div>
        <div class="input-container" style="margin-bottom: 40px">
            <div class="form-container select">
                <label for="">Phòng ban</label>
                <div class="categoryUser-container">
                    <select name="department">
                        <option value="Phòng Nhân sự" <?php echo ($department === 'Phòng Nhân sự') ? 'selected' : ''; ?>>Phòng Nhân sự</option>
                        <option value="Phòng Kinh doanh" <?php echo ($department == 'Phòng Kinh doanh') ? 'selected' : ''; ?>>Phòng Kinh doanh</option>
                        <option value="Phòng IT" <?php echo ($department == 'Phòng IT') ? 'selected' : ''; ?>>Phòng IT</option>
                        <option value="Phòng Marketing" <?php echo ($department == 'Phòng Marketing') ? 'selected' : ''; ?>>Phòng Marketing</option>
                        <option value="Phòng Sản xuất" <?php echo ($department == 'Phòng Sản xuất') ? 'selected' : ''; ?>>Phòng Sản xuất</option>
                        <option value="Phòng Kế hoạch" <?php echo ($department == 'Phòng Kế hoạch') ? 'selected' : ''; ?>>Phòng Kế hoạch</option>
                        <option value="Phòng Kỹ thuật" <?php echo ($department == 'Phòng Kỹ thuật') ? 'selected' : ''; ?>>Phòng Kỹ thuật</option>
                        <option value="Phòng Hành chính" <?php echo ($department == 'Phòng Hành chính') ? 'selected' : ''; ?>>Phòng Hành chính</option>
                        <option value="Phòng Kế toán" <?php echo ($department == 'Phòng Kế toán') ? 'selected' : ''; ?>>Phòng Kế toán</option>
                    </select>
                </div>
            </div>
            <span class="check check-email"><?php echo $department_err; ?></span>
        </div>
        <div class="button">
            <button id="btn-continue" class="continue">Tiếp theo</button>
            <button class="clear">Xóa trống</button>
        </div>
    </form>
</div>
<script>
    document.querySelector('.clear').addEventListener('click', (e) => {
        e.preventDefault();
        document.getElementById('username').value = '';
        document.getElementById('fullname').value = '';
        document.getElementById('password').value = '';
        document.getElementById('email').value = '';
    })
    const datetime = document.getElementById('datetime');
    function changeDate(){
        if(datetime.value){
            datetime.style.color = 'black';
        }else{
            datetime.style.color = 'transparent';
        }
    }
    // document.querySelector('form').addEventListener('submit', function(e){
    //     const username = document.getElementById('username');
    //     const fullname = document.getElementById('fullname');
    //     const password = document.getElementById('password');
    //     const email = document.getElementById('email');
    //     console.log(username);
    //     const check_username = document.querySelector('.check-username');
    //     const check_fullname = document.querySelector('.check-fullname');
    //     const check_password = document.querySelector('.check-password');
    //     const check_email = document.querySelector('.check-email');

    //     if(!username.value){
    //         e.preventDefault();
    //         check_username.innerHTML = '※Tên người dùng không được để trống';
    //     }

    //     if(!fullname.value){
    //         e.preventDefault();
    //         check_fullname.innerHTML = '※Tên người dùng không được để trống';
    //     }

    //     if(!password.value){
    //         e.preventDefault();
    //         check_password.innerHTML = '※Mật khẩu không được để trốngtrống';
    //     }

    //     if(!email.value){
    //         e.preventDefault();
    //         check_email.innerHTML = '※Email không được để trống';
    //     }
    // })
</script>