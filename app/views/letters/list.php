<?php $i = 0 ?>
<div class="main-table">
    <div class="main-header">
        <form action="<?php echo BASE_URL; ?>/public/index.php?url=letters" method="GET">
            <label for="">Tên user/Loại đơn/Nội dung</label>
            <input type="hidden" name="url" value="letters">
            <input type="text" placeholder="Value" name="search" value="<?php echo trim($search); ?>">
            <button type="submit">Tìm kiềm</button>
        </form>
        <div class="right-button">
            <button class="btn-add"><a href="<?php echo BASE_URL ?>/public/index.php?url=letters/testcreate">Thêm mới đơn</a></button>
        </div>
    </div>
    <div class="main-body">
        <?php if(count($letters) > 0): ?>
            <table>
                <thead>
                    <tr>
                        <th>STT</th>
                        <th><a style="color: black" href="<?php echo BASE_URL ?>/public/index.php?url=letters&sort=username&order=<?php echo $sort == 'username' && $order == 'ASC' ? 'DESC' : 'ASC'; ?>&search=<?php echo $search; ?>&page=<?php echo $page; ?>">Người dùng</a></th>
                        <th><a style="color: black" href="<?php echo BASE_URL ?>/public/index.php?url=letters&sort=typesOfApplication&order=<?php echo $sort == 'typesOfApplication' && $order == 'ASC' ? 'DESC' : 'ASC'; ?>&search=<?php echo $search; ?>&page=<?php echo $page; ?>">Loại đơn</a></th>
                        <th><a style="color: black" href="<?php echo BASE_URL ?>/public/index.php?url=letters&sort=created_at&order=<?php echo $sort == 'created_at' && $order == 'ASC' ? 'DESC' : 'ASC'; ?>&search=<?php echo $search; ?>&page=<?php echo $page; ?>">Ngày lập</a></th>
                        <th><a style="color: black" href="<?php echo BASE_URL ?>/public/index.php?url=letters&sort=status&order=<?php echo $sort == 'status' && $order == 'ASC' ? 'DESC' : 'ASC'; ?>&search=<?php echo $search; ?>&page=<?php echo $page; ?>">Trạng thái</a></th>
                        <th><a style="color: black" href="<?php echo BASE_URL ?>/public/index.php?url=letters&sort=approvalDate&order=<?php echo $sort == 'approvalDates' && $order == 'ASC' ? 'DESC' : 'ASC'; ?>&search=<?php echo $search; ?>&page=<?php echo $page; ?>">Ngày duyệt</a></th>
                        <th style="border-right: none">Mô tả</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($letters as $letter): ?>
                        <tr style="<?php echo $letter->status == 'Đã hủy' ? 'background-color: #FFB5B5' : ($letter->status == 'Chờ duyệt' ? 'background-color: #90FF98' : 'background-color: white'); ?>">
                            <td><a style="color: black; width: 100%; height: 100%; display: inline-block;" href="<?= BASE_URL ?>/public/index.php?url=letters/approvalLetter/<?= $letter->letterId ?>/<?= $letter->userId ?>"><?php echo $i = $i + 1; ?></a></td>
                            <td><a style="color: black; width: 100%; height: 100%; display: inline-block;" href="<?= BASE_URL ?>/public/index.php?url=letters/approvalLetter/<?= $letter->letterId ?>/<?= $letter->userId ?>"><?php echo $letter->username ?></a></td>
                            <td><a style="color: black; width: 100%; height: 100%; display: inline-block;" href="<?= BASE_URL ?>/public/index.php?url=letters/approvalLetter/<?= $letter->letterId ?>/<?= $letter->userId ?>"><?php echo $letter->typesOfApplication ?></a></td>
                            <td><a style="color: black; width: 100%; height: 100%; display: inline-block;" href="<?= BASE_URL ?>/public/index.php?url=letters/approvalLetter/<?= $letter->letterId ?>/<?= $letter->userId ?>"><?php echo $letter->created_at ?></a></td>
                            <td><a style="color: black; width: 100%; height: 100%; display: inline-block;" href="<?= BASE_URL ?>/public/index.php?url=letters/approvalLetter/<?= $letter->letterId ?>/<?= $letter->userId ?>"><?php echo $letter->status ?></a></td>
                            <td><a style="color: black; width: 100%; height: 100%; display: inline-block;" href="<?= BASE_URL ?>/public/index.php?url=letters/approvalLetter/<?= $letter->letterId ?>/<?= $letter->userId ?>"><?php echo $letter->approvalDate ?></a></td>
                            <td style="border-right: none;"><a style="color: black; width: 100%; height: 100%; display: inline-block;" href="<?= BASE_URL ?>/public/index.php?url=letters/approvalLetter/<?= $letter->letterId ?>/<?= $letter->userId ?>"><?php echo $letter->title ?></a></td>
                            
                            <td>
                                <?php 
                                    if ($_SESSION['user_categoryUser'] == 'Admin' || (($_SESSION['user_categoryUser'] == 'Quản lý')) && $letter->approver === $_SESSION['user_id']): ?>
                                        <div style="display: flex; justify-content:end; align-items: center; gap: 10px;">
                                            <?php if ($letter->status == "Chờ duyệt"): ?>
                                                <button data-id="<?= $letter->letterId ?>" 
                                                        style="border: 2px solid black; background-color: #14ae5c; color: white; width: 75px; height: 25px; border-radius: 4px; border: none; margin: 0; text-align: center; line-height: 25px; text-decoration: none; display: inline-block;"
                                                        class="btn-approval" type="button">
                                                    Duyệt
                                                </button>
                                                <button data-id="<?= $letter->letterId ?>" 
                                                        style="background-color: #ec221f; color: white; width: 75px; height: 25px; border-radius: 4px; border: none; margin: 0;" 
                                                        class="btn-cancel" type="button">
                                                    Hủy
                                                </button>
                                                <form action="<?= BASE_URL ?>/public/index.php?url=letters/cancelLetter/<?= $letter->letterId ?>/<?= $letter->userId ?>" method="POST">
                                                    <div class="popup-confirm popup-cancel" data-id="<?= $letter->letterId ?>" style="display: none; width: 100%; height: 100%; background-color: rgba(0, 0, 0, 0.4)">
                                                        <div class="popup-container">
                                                            <div class="popup-header">
                                                                <p>Thông báo</p>
                                                                <img src="./image/Vector.png" alt="" class="exit-btn">
                                                            </div>
                                                            <div class="popup-body" style="display: flex; justify-content: center; align-items: center; flex-direction: column">
                                                                <p style="align-self: start; margin-left: 35px; font-size: 24px; font-weight: 400">Lý do hủy đơn ?</p>
                                                                <input style="width: 540px; height: 76px; margin-top: 10px; border-radius: 4px; border: 1px solid #cccccc; font-size: 25px; padding: 10px" 
                                                                    type="text" name="reason">
                                                                <div>
                                                                    <button class="btn-ok" type="submit">OK</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </form>
                                                <form action="<?= BASE_URL ?>/public/index.php?url=letters/approvalLetter/<?= $letter->letterId ?>/<?= $letter->userId ?>" method="POST">
                                                    <div class="popup-confirm popup-approval" data-id="<?= $letter->letterId ?>" style="display: none; width: 100%; height: 100%; background-color: rgba(0, 0, 0, 0.4)">
                                                        <div class="popup-container" style="height: 350px">
                                                            <div class="popup-header">
                                                                <p>Thông báo</p>
                                                                <img src="./image/Vector.png" alt="" class="exit-btn">
                                                            </div>
                                                            <div class="popup-body" style="display: flex; justify-content: center; align-items: center; flex-direction: column">
                                                                <p style="align-self: start; margin-left: 35px; font-size: 24px; font-weight: 400">Bạn có chắc muốn duyệt đơn này ?</p>
                                                                <div style="margin-top: 60px">
                                                                    <button style="width: 220px; height: 50px; border-radius: 4px; color: white; background-color: #007EC6; border: none;" class="btn-ok" type="submit">OK</button>
                                                                    <button style="width: 220px; height: 50px; border-radius: 4px; color: white; background-color: #E2005C; border: none;" class="btn-cancel">Cancel</button>
                                                                </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </form>
                                            <?php endif; ?>
                                        </div>
                                    <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <div class="pagination">
                <div class="prev">
                    <?php if($page > 1): ?>
                        <a style="display:flex; align-items: center" href="<?php echo BASE_URL; ?>/public/index.php?url=letters&page=<?php echo $page - 1; ?>&sort=<?php echo $sort; ?>&order=<?php echo $order; ?>&search=<?php echo $search; ?>">
                            <img src="./image/arrowleft.svg" alt="" style="margin-top: 2px; width: 16px; height: 16px; opacity: 0.5"> Previous
                        </a>
                    <?php endif; ?>
                </div>
                <div class="middle">
                    <?php 
                        $pagesToShow = 5;
                        $halfWindow = floor($pagesToShow / 2);
                        $startPage = max(1, $page - $halfWindow);
                        $endPage = min($totalPages, $page + $halfWindow);
                        if($endPage - $startPage + 1 < $pagesToShow){
                            if($startPage == 1){
                                $endPage = min($totalPages, $startPage + $pagesToShow - 1);
                            }else{
                                $startPage = max(1, $endPage - $pagesToShow + 1);
                            }
                        }

                        if($startPage > 1){
                            echo "<a href='" . BASE_URL . "/public/index.php?url=letters&page=1&sort=$sort&order=$order&search=$search'>1</a>";
                            if($startPage > 2){
                                echo "<span>...</span>";
                            }
                        }

                        for($i = $startPage; $i <= $endPage; $i++){
                            $activeClass = ($i == $page) ? 'active' : '';
                            echo "<a href='" . BASE_URL . "/public/index.php?url=letters&page=$i&sort=$sort&order=$order&search=$search' class='$activeClass'>$i</a>";
                        }

                        if($endPage < $totalPages){
                            if($endPage < $totalPages - 1){
                                echo "<span>...</span>";
                            }
                            echo "<a href='" . BASE_URL . "/public/index.php?url=letters&page=$totalPages&sort=$sort&order=$order&search=$search'>$totalPages</a>";
                        }
                    ?>
                </div>
                <div class="next">
                    <?php if($page < $totalPages): ?>
                        <a style="display:flex; align-items: center" href="<?php echo BASE_URL; ?>/public/index.php?url=letters&page=<?php echo $page + 1; ?>&sort=<?php echo $sort; ?>&search=<?php echo $search; ?>">
                            Next <img src="./image/arrowright.svg" alt="" style="margin-top: 2px; width: 16px; height: 16px; opacity: 0.5">
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        <?php else: ?>
            <div>No letters found</div>
        <?php endif; ?>
    </div>
</div>

<script>
    const approvalButtons = document.querySelectorAll('.btn-approval');
    approvalButtons.forEach(btn => {
        btn.addEventListener('click', function() {
            const letterId = this.getAttribute('data-id');
            const modalPopup = document.querySelector(`.popup-confirm[data-id="${letterId}"].popup-approval`);
            if (modalPopup) {
                modalPopup.style.display = 'flex';
            } else {
                console.error(`Không tìm thấy popup với data-id="${letterId}"`);
            }
        });
    });

    const cancelButtons = document.querySelectorAll('.btn-cancel');
    cancelButtons.forEach(btn => {
        btn.addEventListener('click', function() {
            const letterId = this.getAttribute('data-id');
            const modalPopup = document.querySelector(`.popup-confirm[data-id="${letterId}"].popup-cancel`);
            if (modalPopup) {
                modalPopup.style.display = 'flex';
            } else {
                console.error(`Không tìm thấy popup với data-id="${letterId}"`);
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
</script>