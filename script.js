let currentTable = 'hoc_sinh';
let currentMode = 'view';
let currentHeaders = [];
let currentRows = [];

// ==================== HIỂN THỊ BẢNG TỪ DATABASE ====================
async function loadTable(tableName = currentTable) {
    currentTable = tableName;

    try {
        const response = await fetch(`getData.php?table=${tableName}`);
        const result = await response.json();

        if (!result.success) {
            alert(result.message);
            return;
        }

        currentHeaders = result.headers;
        currentRows = result.rows;

    } catch (error) {
        console.error("Lỗi kết nối API:", error);
        alert("Không thể kết nối tới Server/Database!");
        return;
    }

    document.getElementById('tableTitle').textContent = 'Bảng ' + currentTable.toUpperCase();

    let html = '<table>';

    // Xây dựng Header tiêu đề
    html += '<tr>';
    currentHeaders.forEach(header => {
        html += `<th>${header}</th>`;
    });

    if (currentMode === 'delete') {
        html += '<th>Thao tác</th>';
    }
    html += '</tr>';

    // Xây dựng các hàng dữ liệu
    currentRows.forEach((row) => {
        html += '<tr>';
        row.forEach(cell => {
            if (currentMode === 'edit') {
                html += `<td contenteditable="true">${cell}</td>`;
            } else {
                html += `<td>${cell}</td>`;
            }
        });

        // Nếu ở chế độ xóa, truyền giá trị của cột đầu tiên (Khóa chính) vào hàm xóa
        if (currentMode === 'delete') {
            html += `
                <td>
                    <button onclick="deleteRow('${row[0]}')" 
                            style="padding:8px 12px; background:#ef4444; color:white; border:none; border-radius:6px; cursor:pointer;">
                        Xóa
                    </button>
                </td>
            `;
        }
        html += '</tr>';
    });

    html += '</table>';

    if (currentMode === 'edit') {
        html += `
            <br>
            <button onclick="saveEdit()"
                    style="padding:12px 20px; background:#10b981; color:white; border:none; border-radius:8px; font-size:16px; cursor:pointer;">
                💾 Lưu thay đổi
            </button>
        `;
    }

    document.getElementById('tableContainer').innerHTML = html;
}

// ==================== THÊM DỮ LIỆU VÀO DATABASE ====================
async function addRecord() {
    currentMode = 'view';
    const newRowData = {};

    for (let i = 0; i < currentHeaders.length; i++) {
        // Chuyển tên cột thành chữ thường để khớp với tên trường trong MySQL
        const columnName = currentHeaders[i].toLowerCase(); 
        const value = prompt(`Nhập ${currentHeaders[i]}:`);

        if (value === null) return; 
        newRowData[columnName] = value.trim();
    }

    try {
        const response = await fetch('insert.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ table: currentTable, data: newRowData })
        });
        const result = await response.json();
        
        if (result.success) {
            alert('Đã thêm dữ liệu thành công vào MySQL!');
            loadTable(); 
        } else {
            alert('Lỗi: ' + result.message);
        }
    } catch (error) {
        alert('Không thể kết nối đến server để thêm dữ liệu!');
    }
}

// ==================== CHẾ ĐỘ XÓA DỮ LIỆU ====================
function deleteRecord() {
    currentMode = 'delete';
    loadTable();
}

async function deleteRow(id) {
    if (confirm(`Bạn có chắc chắn muốn xóa bản ghi có mã "${id}" không?`)) {
        try {
            const response = await fetch(`delete.php?table=${currentTable}&id=${id}`);
            const result = await response.json();

            if (result.success) {
                alert('Đã xóa dữ liệu thành công!');
                loadTable(); 
            } else {
                alert('Lỗi: ' + result.message);
            }
        } catch (error) {
            alert('Không thể kết nối đến server để xóa!');
        }
    }
}

// ==================== CHẾ ĐỘ SỬA DỮ LIỆU ====================
function editRecord() {
    currentMode = 'edit';
    loadTable();
}

function saveEdit() {
    // Tạm thời hiển thị thông báo, tính năng update cập nhật động MySQL 
    // cần viết cấu lệnh logic đồng bộ mảng phức tạp hơn.
    alert('Tính năng lưu chỉnh sửa trực tiếp đang được xử lý nâng cấp hệ thống!');
    currentMode = 'view';
    loadTable();
}

// ==================== KHỞI ĐỘNG TRANG ====================
window.onload = function () {
    loadTable('hoc_sinh');
};