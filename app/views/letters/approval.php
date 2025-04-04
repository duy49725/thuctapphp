<div class="right">
    <p>Duyệt đơn</p>
    <form action="<?php echo BASE_URL; ?>/public/index.php?url=letters/approvalLetter/<?php echo $letterId; ?>/<?php echo $userId; ?>" method="POST">
        <input type="text" style="display: none" name="userId" value="<?php echo $_SESSION['user_id'] ?>">
        <div class="input-container">
            <div class="form-container">
                <label for="">Tiêu đề</label>
                <input type="text" name="title" id="title" value="<?php echo $title ?>" disabled style="background-color: #CCCCCC;">
            </div>
            <span class="check check-title"></span>
        </div>

        <div class="input-container">
            <div class="form-container">
                <label for="">Nội dung</label>
                <textarea name="content" id="content" style="width: 480px; height: 94px; margin-left: 67px; border: 1px solid #cccc; border-radius: 4px; background-color: #CCCCCC;" disabled><?php echo $content ?></textarea>
            </div>
            <span class="check check-content"></span>
        </div>

        <div class="input-container">
            <div class="form-container select">
                <label for="">Người duyệt</label>
                <div class="categoryUser-container">
                    <select name="approver" id="" disabled style="background-color: #CCCCCC;">
                        <?php 
                            foreach($usersDepartment as $userdp){
                                echo "<option value='$userdp->userId' " . ($approver == $userdp->userId ? "selected" : "") . ">$userdp->username</option>";
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
                    <select name="typesOfApplication" id="" disabled style="background-color: #cccccc;">
                        <option value="Đơn nghỉ phép" <?php echo $typesOfApplication == "Đơn nghỉ phép" ? "selected" : '' ?>>Đơn nghỉ phép</option>
                        <option value="Đơn cấp vật tư máy móc" <?php echo $typesOfApplication == "Đơn cấp vật tư máy móc" ? "selected" : '' ?>>Đơn cấp vật tư máy móc</option>
                        <option value="Đơn thay đổi giờ làm" <?php echo $typesOfApplication == "Đơn thay đổi giờ làm" ? "selected" : '' ?>>Đơn thay đổi giờ làm</option>
                        <option value="Đơn xin thanh toán công tác phí" <?php echo $typesOfApplication == "Đơn xin thanh toán công tác phí" ? "selected" : '' ?>>Đơn xin thanh toán công tác phí</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="input-container">
            <div class="form-container">
                <label for="">Ngày bắt đầu</label>
                <div class="date-container" style="margin-left: -25px">
                    <input class="datetime" value="<?php echo $startDate ?>" type="date" type="date" name="startDate" style="width: 189px; height: 40px; padding: 5px; background-color: #CCCCCC;" disabled>
                </div>
            </div>
        </div>
        <div class="input-container">
            <div class="form-container">
                <label for="">Ngày kết thúc</label>
                <div class="date-container" style="margin-left: -29px">
                    <input class="datetime" value="<?php echo $endDate ?>" type="date" type="date" name="endDate" style="width: 189px; height: 40px;  padding: 5px; background-color: #CCCCCC;" disabled>
                </div>
            </div>
        </div>
        <div class="input-container">
            <div class="form-container">
                <label for="">Đính kèm</label>
                <?php
                  echo $attachment ? "<p style='margin-left: 62px; margin-bottom: 26px; color: #ec221f; cursor: pointer;' onclick='showImage()'>$attachment</p>"
                  : "<div style='margin-left: 62px; border: 1px solid #cccccc; display: flex; flex-direction: row-reverse; justify-content: space-between; align-items: center; padding: 5px; height: 40px; width: 189px; border-radius: 4px'>
                       <input id='file' style='display: none' type='file' name='attachment' disabled>
                       <label for='file' style='cursor: pointer;'><img src='./image/upload.svg' alt=''></label>
                    </div>";
                ?>
            </div>
            <div id="image_container" style="z-index: 100; position: fixed; left: 0; top: 0; background-color: rgba(0,0,0,0.4); width: 100%; height: 100%; display: flex; justify-content: center; align-items: center; display: none">
                <img src="./uploads/<?php echo $attachment; ?>" alt="">
                <img src="./image/Vector.png" alt="" id="close-image" style="cursor: pointer; top: 20px; position: absolute; right: 20px; width: 20px; height: 20px">
            </div>
        </div>
        <?php if ($_SESSION['user_categoryUser'] == 'Admin' || (($_SESSION['user_categoryUser'] == 'Quản lý')) && $approver === $_SESSION['user_id']): ?>
            <div class="button">
                <button id="btn-continue" type="submit" class="continue">Duyệt</button>
                <button id="btn-cancel-letter" class="btn-cancel" type="button">Hủy</button>
            </div>
        <?php endif; ?>
        <div class="popup-confirm popup-approval">
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
    <form action="<?= BASE_URL ?>/public/index.php?url=letters/cancelLetter/<?php echo $letterId; ?>/<?php echo $userId; ?>" method="POST">
        <div class="popup-confirm popup-cancel" style="display: none; width: 100%; height: 100%; background-color: rgba(0, 0, 0, 0.4)">
            <div class="popup-container" style="height: 400px">
                <div class="popup-header">
                    <p>Thông báo</p>
                    <img src="./image/Vector.png" alt="" class="exit-btn">
                </div>
                <div class="popup-body" style="display: flex; justify-content: center; align-items: center; flex-direction: column;">
                    <p style="align-self: start; margin-left: 35px; font-size: 24px; font-weight: 400">Lý do hủy đơn ?</p>
                    <input style="width: 540px; height: 76px; margin-top: 10px; border-radius: 4px; border: 1px solid #cccccc; font-size: 25px; padding: 10px; position: initial;" type="text" name="reason">
                    <div>
                        <button class="btn-ok" type="submit">OK</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>


<script>
    const cancelButton = document.getElementById('btn-cancel-letter');
    if (cancelButton) {
        cancelButton.addEventListener('click', function() {
            const modalPopup = document.querySelector('.popup-confirm.popup-cancel');
            if (modalPopup) {
                modalPopup.style.display = 'flex';
            }
        });
    }

    
    const imageContainer = document.getElementById('image_container');
    const showImage = () => {
        imageContainer.style.display = 'flex';
    }
    document.getElementById('close-image').addEventListener('click', () => {
        imageContainer.style.display = 'none';
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
    const continueBtn = document.getElementById("btn-continue");
    continueBtn.addEventListener('click', function(e) {
        e.preventDefault();
        const modalpopup = document.querySelector('.popup-confirm.popup-approval');
        modalpopup.style.display = 'flex';
    })
    const cancelBtn = document.querySelector('.popup-approval .btn-cancel');
    cancelBtn.addEventListener('click', function(e){
        e.preventDefault();
        const modalpopup = document.querySelector('.popup-confirm.popup-approval');
        modalpopup.style.display = 'none';
    })

    const exitBtn = document.querySelector('.popup-approval .exit-btn');
    exitBtn.addEventListener('click', function(e){
        e.preventDefault();
        const modalpopup = document.querySelector('.popup-confirm.popup-approval');
        modalpopup.style.display = 'none';
    })

    const exitBtn2 = document.querySelector('.popup-cancel .exit-btn');
    exitBtn2.addEventListener('click', function(e){
        e.preventDefault();
        const modalpopup = document.querySelector('.popup-confirm.popup-cancel');
        modalpopup.style.display = 'none';
    })

    const okBtn = document.querySelector('.popup-approval .btn-ok');
    okBtn.addEventListener('click', function(e){
        const modalpopup = document.querySelector('.popup-confirm.popup-approval');
        modalpopup.style.display = 'none';
    })
</script>