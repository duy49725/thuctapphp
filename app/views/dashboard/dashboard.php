<?php $i = 0 ?>
<div class="main-table">
    <div class="main-body">
        <?php if(count($letters) > 0): ?>
            <table>
                <thead>
                    <tr>
                        <th>STT</th>
                        <th>Người dùng</th>
                        <th>Loại đơn</th>
                        <th>Ngày lập</th>
                        <th>Trạng thái</th>
                        <th>Mô tả</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($letters as $letter): ?>
                        <tr>
                            <td><?php echo $i = $i + 1; ?></td>
                            <td><?php echo $letter->username ?></td>
                            <td><?php echo $letter->typesOfApplication ?></td>
                            <td><?php echo $letter->created_at ?></td>
                            <td><?php echo $letter->status ?></td>
                            <td><?php echo $letter->title ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <div>No letters found</div>
        <?php endif; ?>
    </div>
</div>