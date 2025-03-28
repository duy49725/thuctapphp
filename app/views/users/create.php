<div class="right">
    <p>Thêm mới người dùng kiểm tra lại<p>
    <form action="<?php echo BASE_URL; ?>/public/index.php?url=users/create" method="POST">
        <div class="input-container">
            <div class="form-container">
                <label for="">Tên đăng nhập</label>
                <input id="username" value="<?php echo $username ?>" type="text" name="username" disabled style="background-color: #CCCCCC;">
            </div>
            <span class="check check-username"></span>
        </div>
        <div class="input-container">
            <div class="form-container">
                <label for="">Tên người dùng</label>
                <input id="fullname" value="<?php echo $fullname ?>" type="text" name="fullname" disabled style="background-color: #CCCCCC;">
            </div>
            <span class="check check-fullname"></span>
        </div>
        <div class="input-container">
            <div class="form-container">
                <label for="">Mật khẩu</label>
                <input id="password" value="<?php echo $password ?>" type="password" name="password" disabled style="background-color: #CCCCCC;">
            </div>
            <span class="check check-password"></span>
        </div>
        <div class="input-container">
            <div class="form-container">
                <label for="">Email</label>
                <input id="email" value="<?php echo $email ?>" type="email" name="email" disabled style="background-color: #CCCCCC;">
            </div>
            <span class="check check-email"></span>
        </div>
        <div class="input-container"> 
            <div class="form-container">
                <label for="">Ngày sinh</label>
                <div class="date-container" style="background-color: #cccccc">
                    <input id="datetime" value="<?php echo $birthDate ?>"  onchange="changeDate()" type="date" name="birthDate" style="width: 189px; height: 40px;  padding: 5px; background-color: #CCCCCC;" disabled>
                </div>
            </div>
        </div>
        <div class="input-container">
            <div class="form-container select">
                <label for="">Loại người dùng</label>
                <div class="categoryUser-container">
                    <select name="categoryUser" disabled style="background-color: #CCCCCC;">
                        <option value="Quản lý" <?php echo ($categoryUser == 'Quản lý') ? 'selected' : ''; ?> >Quản lý</option>
                        <option value="Nhân viên" <?php echo ($categoryUser == 'Nhân viên') ? 'selected' : '' ?>>Nhân viên</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="input-container">
            <div class="form-container select">
                <label for="">Trạng thái</label>
                <div class="categoryUser-container">
                    <select name="status" disabled style="background-color: #CCCCCC;">
                        <option value="Đang hoạt động" <?php echo ($status == 'Đang hoạt động') ? 'selected' : ''; ?> >Đang hoạt động</option>
                        <option value="Đã khóa" <?php echo ($status == 'Đã khóa') ? 'selected' : '' ?>>Đã khóa</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="input-container">
            <div class="form-container select">
                <label for="">Phòng ban</label>
                <div class="categoryUser-container">
                    <select name="department" disabled style="background-color: #CCCCCC;">
                        <option value="Phòng Nhân sự" <?php echo ($department == 'Phòng Nhân sự') ? 'selected' : ''; ?> >Phòng Nhân sự</option>
                        <option value="Phòng Kinh doanh" <?php echo ($department == 'Phòng Kinh doanh') ? 'selected' : ''; ?> >Phòng Kinh doanh</option>
                        <option value="Phòng IT" <?php echo ($department == 'Phòng IT') ? 'selected' : ''; ?> >Phòng IT</option>
                        <option value="Phòng Marketing" <?php echo ($department == 'Phòng Marketing') ? 'selected' : ''; ?> >Phòng Marketing</option>
                        <option value="Phòng Sản xuất" <?php echo ($department == 'Phòng Sản xuất') ? 'selected' : ''; ?> >Phòng Sản xuất</option>
                        <option value="Phòng Kế hoạch" <?php echo ($department == 'Phòng Kế hoạch') ? 'selected' : ''; ?> >Phòng Kế hoạch</option>
                        <option value="Phòng Kỹ thuật" <?php echo ($department == 'Phòng Kỹ thuật') ? 'selected' : ''; ?> >Phòng Kỹ thuật</option>
                        <option value="Phòng Hành chính" <?php echo ($department == 'Phòng Hành chính') ? 'selected' : ''; ?> >Phòng Hành chính</option>
                        <option value="Phòng Kế toán" <?php echo ($department == 'Phòng Kế toán') ? 'selected' : ''; ?>>Phòng Kế toán</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="button">
            <button id="btn-continue" class="continue">Lưu</button>
            <button class="clear">Xóa trống</button>
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
            datetime.style.color = 'transparent';
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