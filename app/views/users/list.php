<div class="main-table">
    <div class="main-header">
        <form action="<?php echo BASE_URL; ?>/public/index.php?url=users" method="GET">
            <label for="">Mã/Tên user</label>
            <input type="hidden" name="url" value="users">
            <input type="text" placeholder="Value" name="search" value="<?php echo $search; ?>">
            <button type="submit">Tìm kiếm</button>
        </form>
        <div class="right-button">
            <button class="btn-add"><a href="<?php echo BASE_URL ?>/public/index.php?url=users/testcreate">Thêm mới</a></button>
            <?php if($_SESSION['user_categoryUser'] == 'Quản lý' || $_SESSION['user_categoryUser'] == 'Admin'): ?>
                <form action="<?php echo BASE_URL; ?>/public/index.php?url=users/deleteMultiple" method="POST" id="delete-form">
                    <button type="submit" class="btn-deleteAll" id="delete-selected" disabled>Xóa nhiều</button>
                    <div class="popup-confirm" style="display: none;">
                        <div class="popup-container" style="height: 350px;">
                            <div class="popup-header">
                                <p>Thông báo</p>
                                <img src="./image/Vector.png" alt="" class="exit-btn">
                            </div>
                            <div class="popup-body">
                                <p style="margin-left: 10px; margin-top: 60px">Bạn có chắc chắn muốn xóa các người dùng đã chọn?</p>
                                <div style="margin-left: 38px">
                                    <button type="submit" class="btn-ok" style="background-color: #E2005C; border-radius: 4px; width: 220px; height: 50px;">OK</button>
                                    <button class="btn-cancel" style="background-color: #007EC6; border-radius: 4px; width: 220px; height: 50px;" type="button">Cancel</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            <?php endif; ?>
        </div>
    </div>
    <div class="main-body">
        <?php if(count($users) > 0): ?>
            <table>
                <thead>
                    <tr>
                        <th style="text-align: center">
                            <div>
                                <input style="display: none" type="checkbox" name="" id="select-all">
                                <label for="select-all" style="text-align: center; display: flex; justify-content: center; align-items: center;">
                                    <div style="background-color: #ffffff; width: 24px; height: 24px; border-radius: 4px; border: 1px solid #cccccc; display: flex; justify-content: center; align-items: center;">
                                        <img src="./image/checkbox.svg" style="width: 12px; height: 9.4px; display: none" alt="" id="checked-icon">
                                    </div>
                                </label>
                            </div>
                        </th>
                        <th><a style="color: black" href="<?php echo BASE_URL ?>/public/index.php?url=users&sort=userId&order=<?php echo $sort == 'userId' && $order == 'ASC' ? 'DESC' : 'ASC'; ?>&search=<?php echo $search; ?>">Mã người dùng</a></th>
                        <th><a style="color: black" href="<?php echo BASE_URL ?>/public/index.php?url=users&sort=username&order=<?php echo $sort == 'username' && $order == 'ASC' ? 'DESC' : 'ASC'; ?>&search=<?php echo $search; ?>">Tên người dùng</a></th>
                        <th><a style="color: black" href="<?php echo BASE_URL ?>/public/index.php?url=users&sort=created_at&order=<?php echo $sort == 'created_at' && $order == 'ASC' ? 'DESC' : 'ASC'; ?>&search=<?php echo $search; ?>">Ngày lập</a></th>
                        <th><a style="color: black" href="<?php echo BASE_URL ?>/public/index.php?url=users&sort=status&order=<?php echo $sort == 'status' && $order == 'ASC' ? 'DESC' : 'ASC'; ?>&search=<?php echo $search; ?>">Trạng thái</a></th>
                        <th>Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($users as $user) : ?>
                        <tr>
                            <td style="text-align: center">
                                <div>
                                    <input style="display: none" type="checkbox" name="ids[]" form="delete-form" value="<?php echo $user->userId; ?>" class="user-checkbox" id="checkbox-<?php echo $user->userId; ?>">
                                    <label for="checkbox-<?php echo $user->userId; ?>" style="text-align: center; display: flex; justify-content: center; align-items: center;">
                                        <div style="background-color: #ffffff; width: 24px; height: 24px; border-radius: 4px; border: 1px solid #cccccc; display: flex; justify-content: center; align-items: center;">
                                            <img src="./image/checkbox.svg" style="width: 12px; height: 9.4px; display: none" alt="" class="checked-icon-each">
                                        </div>
                                    </label>
                                </div>
                            </td>
                            <td><?php echo $user->userId ?></td>
                            <td><?php echo $user->username ?></td>
                            <td><?php echo $user->created_at ?></td>
                            <td><?php echo $user->status ?></td>
                            <td>
                                <button class="btn-edit"><a href="<?php echo BASE_URL ?>/public/index.php?url=users/testedit/<?php echo $user->userId ?>">Sửa</a></button>
                                <?php if($_SESSION['user_categoryUser'] == 'Quản lý' || $_SESSION['user_categoryUser'] == 'Admin'): ?>   
                                    <button class="btn-delete" data-id="<?php echo $user->userId ?>">Xóa</button>
                                    <form action="<?php echo BASE_URL ?>/public/index.php?url=users/delete/<?php echo $user->userId ?>" method="POST">
                                        <div class="popup-confirm" data-id="<?php echo $user->userId ?>" style="display: none;">
                                            <div class="popup-container" style="height: 350px">
                                                <div class="popup-header">
                                                    <p>Thông báo</p>
                                                    <img src="./image/Vector.png" alt="" class="exit-btn">
                                                </div>
                                                <div class="popup-body">
                                                    <p style="padding-left: 35px;">Bạn có chắc chắn muốn xóa người dùng <?php echo $user->username ?> ?</p>
                                                    <div style="padding-left: 64px;">
                                                        <button class="btn-ok" type="submit">OK</button>
                                                        <button class="btn-cancel" type="button">Cancel</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <div class="pagination">
                <div class="prev">
                    <?php if ($page > 1): ?>
                        <a href="<?php echo BASE_URL; ?>/public/index.php?url=users&page=<?php echo $page - 1; ?>&sort=<?php echo $sort; ?>&order=<?php echo $order; ?>&search=<?php echo $search; ?>">
                            <img src="./image/arrowleft.png" alt=""> Previous
                        </a>
                    <?php endif; ?>
                </div>
                <div class="middle">
                    <?php
                    $pagesToShow = 5; 
                    $halfWindow = floor($pagesToShow / 2); 

                    $startPage = max(1, $page - $halfWindow);
                    $endPage = min($totalPages, $page + $halfWindow);

                    if ($endPage - $startPage + 1 < $pagesToShow) {
                        if ($startPage == 1) {
                            $endPage = min($totalPages, $startPage + $pagesToShow - 1);
                        } else {
                            $startPage = max(1, $endPage - $pagesToShow + 1);
                        }
                    }

                    if ($startPage > 1) {
                        echo "<a href='" . BASE_URL . "/public/index.php?url=users&page=1&sort=$sort&order=$order&search=$search'>1</a>";
                        if ($startPage > 2) {
                            echo "<span>...</span>";
                        }
                    }

                    for ($i = $startPage; $i <= $endPage; $i++) {
                        $activeClass = ($i == $page) ? 'active' : '';
                        echo "<a href='" . BASE_URL . "/public/index.php?url=users&page=$i&sort=$sort&order=$order&search=$search' class='$activeClass'>$i</a>";
                    }

                    if ($endPage < $totalPages) {
                        if ($endPage < $totalPages - 1) {
                            echo "<span>...</span>";
                        }
                        echo "<a href='" . BASE_URL . "/public/index.php?url=users&page=$totalPages&sort=$sort&order=$order&search=$search'>$totalPages</a>";
                    }
                    ?>
                </div>
                <div class="next">
                    <?php if ($page < $totalPages): ?>
                        <a href="<?php echo BASE_URL; ?>/public/index.php?url=users&page=<?php echo $page + 1; ?>&sort=<?php echo $sort; ?>&order=<?php echo $order; ?>&search=<?php echo $search; ?>">
                            Next <img src="./image/arrowright.png" alt="">
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        <?php else : ?>
            <div>No users found</div>
        <?php endif; ?>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const selectAll = document.getElementById('select-all');
    const userCheckboxes = document.querySelectorAll('.user-checkbox');
    const deleteSelected = document.getElementById('delete-selected');
    const deleteForm = document.getElementById('delete-form');
    const checkIcon = document.getElementById('checked-icon');

    if (selectAll) {
        selectAll.addEventListener('change', function(e) {
            const isChecked = e.target.checked;
            checkIcon.style.display = isChecked ? 'inline-block' : 'none';

            userCheckboxes.forEach(checkbox => {
                checkbox.checked = isChecked;
                const row = checkbox.closest('tr');
                const checkIconEach = row.querySelector('.checked-icon-each');
                if (checkIconEach) {
                    checkIconEach.style.display = isChecked ? 'inline-block' : 'none';
                }
            });
            updateDeleteButton();
        });
    }

    userCheckboxes.forEach(checkbox => {
        checkbox.addEventListener('change', function(e) {
            const row = e.target.closest('tr');
            const checkIconEach = row.querySelector('.checked-icon-each');
            if (checkIconEach) {
                checkIconEach.style.display = e.target.checked ? 'inline-block' : 'none';
            }
            updateDeleteButton();

            const allChecked = Array.from(userCheckboxes).every(cb => cb.checked);
            const noneChecked = Array.from(userCheckboxes).every(cb => !cb.checked);
            if (allChecked) {
                selectAll.checked = true;
                checkIcon.style.display = 'inline-block';
            } else if (noneChecked) {
                selectAll.checked = false;
                checkIcon.style.display = 'none';
            }
        });
    });

    function updateDeleteButton() {
        const checkedCount = document.querySelectorAll('.user-checkbox:checked').length;
        deleteSelected.disabled = checkedCount === 0;
    }

    if (deleteSelected && deleteForm) {
        deleteSelected.addEventListener('click', function(e) {
            e.preventDefault();
            const modalPopup = deleteForm.querySelector('.popup-confirm');
            if (modalPopup) {
                modalPopup.style.display = 'flex';
            }
        });

        deleteForm.addEventListener('submit', function(e) {
            const checkedCount = document.querySelectorAll('.user-checkbox:checked').length;
            if (checkedCount === 0) {
                e.preventDefault();
                return;
            }
        });

        const cancelButton = deleteForm.querySelector('.btn-cancel');
        const exitButton = deleteForm.querySelector('.exit-btn');
        const modalPopup = deleteForm.querySelector('.popup-confirm');

        if (cancelButton) {
            cancelButton.addEventListener('click', function() {
                modalPopup.style.display = 'none';
            });
        }
        if (exitButton) {
            exitButton.addEventListener('click', function() {
                modalPopup.style.display = 'none';
            });
        }
    }

    const deleteButtons = document.querySelectorAll('.btn-delete');
    deleteButtons.forEach(btn => {
        btn.addEventListener('click', function() {
            const userId = this.getAttribute('data-id');
            const modalPopup = document.querySelector(`.popup-confirm[data-id="${userId}"]`);
            if (modalPopup) {
                modalPopup.style.display = 'flex';
            } else {
                console.error(`Không tìm thấy popup với data-id="${userId}"`);
            }
        });
    });

    const cancelButtons = document.querySelectorAll('.btn-cancel');
    cancelButtons.forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            const modalPopup = this.closest('.popup-confirm');
            if (modalPopup) {
                modalPopup.style.display = 'none';
            }
        });
    });

    const exitButtons = document.querySelectorAll('.exit-btn');
    exitButtons.forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            const modalPopup = this.closest('.popup-confirm');
            if (modalPopup) {
                modalPopup.style.display = 'none';
            }
        });
    });
});
</script>