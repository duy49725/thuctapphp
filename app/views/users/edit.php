<div class="right">
    <p>Kiểm tra sửa người dùng<p>
    <form action="<?php echo BASE_URL; ?>/public/index.php?url=users/edit/<?php echo $userId ?>" method="POST">
        <div class="input-container">
            <div class="form-container">
                <label for="">Tên đăng nhập</label>
                <input id="username" type="text" name="username" value="<?php echo $username ?>" disabled style="background-color: #CCCCCC;">
            </div>
            <span class="check check-username"><?php echo $username_err ?></span>
        </div>
        <div class="input-container">
            <div class="form-container">
                <label for="">Tên người dùng</label>
                <input id="fullname" type="text" name="fullname" value="<?php echo $fullname ?>" disabled style="background-color: #CCCCCC;">
            </div>
            <span class="check check-fullname"><?php echo $fullname_err ?></span>
        </div>
        <div class="input-container">
            <div class="form-container">
                <label for="">Mật khẩu</label>
                <input id="password" type="password" name="password" value="<?php echo $password ?>" disabled style="background-color: #CCCCCC;">
            </div>
            <span class="check check-password"><?php echo $password_err ?></span>
        </div>
        <div class="input-container">
            <div class="form-container">
                <label for="">Email</label>
                <input id="email" type="email" name="email" value="<?php echo $email ?>" disabled style="background-color: #CCCCCC;">
            </div>
            <span class="check check-email"><?php echo $email_err ?></span>
        </div>
        <div class="input-container"> 
            <div class="form-container">
                <label for="">Ngày sinh</label>
                <div class="date-container">
                    <input id="datetime" value="<?php echo $birthDate ?>" onchange="changeDate()" type="date" name="birthDate" style="width: 189px; height: 40px;  padding: 5px; color: black; background-color: #CCCCCC;" disabled>
                </div>
            </div>
        </div>
        <div class="input-container">
            <div class="form-container select">
                <label for="">Loại người dùng</label>
                <div class="categoryUser-container">
                    <select name="categoryUser" disabled style="background-color: #CCCCCC;">
                        <option value="Quản lý" <?php echo ($categoryUser === 'Quản lý') ? 'selected' : ''; ?>>Quản lý</option>
                        <option value="Nhân viên" <?php echo ($categoryUser == 'Nhân viên') ? 'selected' : ''; ?>>Nhân viên</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="input-container">
            <div class="form-container select">
                <label for="">Trạng thái</label>
                <div class="categoryUser-container">
                    <select name="status" disabled style="background-color: #CCCCCC;">
                        <option value="Đang hoạt động" <?php echo ($status === 'Đang hoạt động') ? 'selected' : ''; ?>>Đang hoạt động</option>
                        <option value="Đã khóa" <?php echo ($status == 'Đã khóa') ? 'selected' : ''; ?>>Đã khóa</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="input-container">
            <div class="form-container select">
                <label for="">Phòng ban</label>
                <div class="categoryUser-container">
                    <select name="department" disabled style="background-color: #CCCCCC;">
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
        </div>
        <div class="button">
            <button id="btn-continue" class="continue">Lưu</button>
            <button class="clear" type="button" style="padding: 0; width: 220px; height: 50px;">
                <a style="display: block; width: 100%; height: 100%; display: flex; align-items: center; justify-content: center" href="<?php echo BASE_URL; ?>/public/index.php?url=users/testedit/<?php echo $userId; ?>">Quay lại</a>
            </button>
        </div>
        <div class="popup-confirm">
            <div class="popup-container" style="height: 350px">
                <div class="popup-header">
                    <p>Thông báo</p>
                    <img src="./image/Vector.png" alt="" class="exit-btn">
                </div>
                <div class="popup-body" style="display: flex; flex-direction: column; justify-content: center; align-items: center; margin-top: 40px">
                    <p>Bạn có chắc chắn lưu lại thay đổi ?</p>
                    <div>
                        <button class="btn-ok" type="submit" name="adduser">OK</button>
                        <button class="btn-cancel">Cancel</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
<script>
    const datetime = document.getElementById('datetime');
    function changeDate(){
        if(datetime.value){
            datetime.style.color = 'black';
        }else{
            datetime.style.color = 'black';
        }
    }
    const continueBtn = document.getElementById("btn-continue");
    continueBtn.addEventListener('click', function(e) {
        e.preventDefault();
        const modalpopup = document.querySelector('.popup-confirm');
        modalpopup.style.display = 'flex';
    })
    const cancelBtn = document.querySelector('.btn-cancel');
    cancelBtn.addEventListener('click', function(e){
        e.preventDefault();
        const modalpopup = document.querySelector('.popup-confirm');
        modalpopup.style.display = 'none';
    })

    const exitBtn = document.querySelector('.exit-btn');
    exitBtn.addEventListener('click', function(e){
        e.preventDefault();
        const modalpopup = document.querySelector('.popup-confirm');
        modalpopup.style.display = 'none';
    })

    const okBtn = document.querySelector('.btn-ok');
    okBtn.addEventListener('click', function(e){
        const modalpopup = document.querySelector('.popup-confirm');
        modalpopup.style.display = 'none';
    })
</script>