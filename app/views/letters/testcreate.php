<div class="right">
    <p>Thêm mới đơn</p>
    <form action="<?php echo BASE_URL; ?>/public/index.php?url=letters/testcreate" method="POST" enctype="multipart/form-data">
        <input type="text" style="display: none" name="userId" value="<?php echo $_SESSION['user_id'] ?>">
        <div class="input-container" style="<?php echo  $title_err ? 'margin-bottom: 70px' : 'margin-bottom: 40px'; ?>">
            <div class="form-container">
                <label for="">Tiêu đề</label>
                <input type="text" name="title" id="title">
            </div>
            <div class="check check-title"><?php echo $title_err; ?></div>
        </div>

        <div class="input-container" style="<?php echo  $title_err ? 'margin-bottom: 70px' : 'margin-bottom: 40px'; ?>">
            <div class="form-container">
                <label for="">Nội dung</label>
                <textarea name="content" id="content" style="width: 480px; height: 94px; margin-left: 67px; border: 1px solid #cccc; border-radius: 4px"></textarea>
            </div>
            <div class="check check-content" style="margin-top: 60px"><?php echo $content_err; ?></div>
        </div>

        <div class="input-container">
            <div class="form-container select">
                <label for="">Người duyệt</label>
                <div class="categoryUser-container">
                    <select name="approver" id="">
                        <?php 
                            foreach($usersDepartment as $userdp){
                                echo "<option value='$userdp->userId'>$userdp->username</option>";
                            }
                        ?>
                    </select>
                </div>
            </div>
        </div>     
        <div class="input-container">
            <div class="form-container select">
                <label for="">Loại đơn</label>
                <div class="categoryUser-container">
                    <select name="typesOfApplication" id="">
                        <option value="Đơn nghỉ phép">Đơn nghỉ phép</option>
                        <option value="Đơn cấp vật tư máy móc">Đơn cấp vật tư máy móc</option>
                        <option value="Đơn thay đổi giờ làm">Đơn thay đổi giờ làm</option>
                        <option value="Đơn xin thanh toán công tác phí">Đơn xin thanh toán công tác phí</option>
                    </select>
                </div>
            </div>
            <div><?php echo $typesOfApplication_err; ?></div>
        </div>

        <div class="input-container" style="<?php echo  $startDate_err ? 'margin-bottom: 70px' : 'margin-bottom: 40px'; ?>">
            <div class="form-container">
                <label for="">Ngày bắt đầu</label>
                <div class="date-container" style="margin-left: -25px">
                    <input class="datetime" type="date" name="startDate" style="width: 189px; height: 40px; padding: 5px; color: transparent;">
                </div>
            </div>
            <div class="check check-title"><?php echo $startDate_err; ?></div>
        </div>
        <div class="input-container" style="<?php echo  $endDate_err ? 'margin-bottom: 70px' : 'margin-bottom: 40px'; ?>">
            <div class="form-container">
                <label for="">Ngày kết thúc</label>
                <div class="date-container" style="margin-left: -29px">
                    <input class="datetime" type="date" name="endDate" style="width: 189px; height: 40px;  padding: 5px; color: transparent;">
                </div>
            </div>
            <div class="check check-title"><?php echo $endDate_err; ?></div>
        </div>
        <div class="input-container" style="<?php echo  $attachment_err ? 'margin-bottom: 70px' : 'margin-bottom: 40px'; ?>">
            <div class="form-container">
                <label for="">Đính kèm</label>
                <div style="margin-left: 62px; border: 1px solid #cccccc; display: flex; flex-direction: row-reverse; justity-content: space-between; align-items: center; padding: 5px; height: 40px; width: 189px; border-radius: 4px">
                    <input id="file" style="display: none" type="file" name="attachment" style="width: 189px; height: 40px;  padding: 5px;">
                    <label for="file" style="cursor: pointer; "><img src="./image/upload.svg" alt=""></label>
                </div>
            </div>
            <div class="check check-title"><?php echo $attachment_err; ?></div>
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
        document.getElementById('title').value = '';
        document.getElementById('content').value = '';
    })
    const datetime = document.querySelectorAll('.datetime');
    datetime.forEach((date) => {
        date.addEventListener('change', (event) => {
            if(event.target.value){
                event.target.style.color = 'black';
            }else{
                event.target.style.color = 'transparent';
            }
        })
    })
</script>