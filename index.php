<?php 
// Khởi chạy file xử lý logic và kết nối database trước khi render giao diện
require_once 'process.php'; 
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hệ Thống Quản Lý Điểm Rèn Luyện Sinh Viên - Nhóm 8</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <?php if($message != ""): ?>
        <div class="alert" id="alertBox"><?php echo $message; ?></div>
        <script>setTimeout(() => { document.getElementById('alertBox').style.display = 'none'; }, 3000);</script>
    <?php endif; ?>

    <div class="sidebar">
        <h3>Danh mục bảng</h3>
        <?php foreach($tables_config as $table_key => $table_val): ?>
            <a href="?table=<?php echo $table_key; ?>" class="<?php echo $current_table === $table_key ? 'active' : ''; ?>">
                📊 Bảng <?php echo $table_val['title']; ?>
            </a>
        <?php endforeach; ?>
    </div>

    <div class="main-content">
        <h2>Dữ liệu thực thể: Bảng <?php echo $config['title']; ?></h2>
        <div class="table-container">
            <table id="dataTable">
                <thead>
                    <tr>
                        <?php foreach($config['fields'] as $field): ?>
                            <th><?php echo $field; ?></th>
                        <?php endforeach; ?>
                    </tr>
                </thead>
                <tbody>
                    <?php if($result && $result->num_rows > 0): ?>
                        <?php while($row = $result->fetch_assoc()): ?>
                            <tr onclick="rowSelect(this, <?php echo htmlspecialchars(json_encode($row)); ?>, '<?php echo $pk_field; ?>')">
                                <?php foreach($config['fields'] as $field): ?>
                                    <td><?php echo htmlspecialchars($row[$field]); ?></td>
                                <?php endforeach; ?>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="<?php echo count($config['fields']); ?>" style="text-align: center; color: #a0aec0; padding: 40px 0;">
                                📭 Hiện tại chưa có bản ghi dữ liệu nào trong bảng này.
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <div class="action-bar">
        <h3>Thao tác trực tiếp</h3>
        <button class="btn btn-add" onclick="openAddModal('<?php echo $pk_field; ?>')">➕ Thêm mới dữ liệu</button>
        <button class="btn btn-edit" id="btnEdit" onclick="openEditModal()">✏️ Sửa dòng chọn</button>
        <button class="btn btn-delete" id="btnDelete" onclick="deleteRecord()">🗑️ Xóa dòng chọn</button>
    </div>

    <div class="modal" id="dataModal">
        <div class="modal-content">
            <div class="modal-header">
                <h2 id="modalTitle">Thêm dữ liệu mới</h2>
                <button class="modal-close" onclick="closeModal()">×</button>
            </div>
            <form id="modalForm" method="POST" action="">
                <input type="hidden" name="action" id="formAction" value="add">
                
                <div class="modal-body">
                    <?php foreach($config['fields'] as $field): ?>
                        <div class="form-group">
                            <label for="input_<?php echo $field; ?>"><?php echo $field; ?></label>
                            
                            <?php // Tự động nhận diện loại dữ liệu cột để gán giao diện nhập cho hợp lý
                            if (strpos(strtolower($field), 'ngay') !== false): ?>
                                <input type="date" name="<?php echo $field; ?>" id="input_<?php echo $field; ?>" required>
                            <?php elseif (strpos(strtolower($field), 'hocki') !== false || strpos(strtolower($field), 'diem') !== false): ?>
                                <input type="number" step="any" name="<?php echo $field; ?>" id="input_<?php echo $field; ?>" required>
                            <?php else: ?>
                                <input type="text" name="<?php echo $field; ?>" id="input_<?php echo $field; ?>" required>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; ?>
                </div>
                
                <div class="modal-footer">
                    <button type="button" class="btn btn-cancel" onclick="closeModal()">Hủy bỏ</button>
                    <button type="submit" class="btn btn-save">Lưu lại</button>
                </div>
            </form>
        </div>
    </div>

    <form id="deleteForm" method="POST" style="display:none;" action="">
        <input type="hidden" name="action" value="delete">
        <input type="hidden" name="id" id="deleteId">
    </form>

    <script src="script.js"></script>
</body>
</html>