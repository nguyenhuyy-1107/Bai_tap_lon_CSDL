let selectedRowData = null;

// Hàm bắt sự kiện khi người dùng click chọn 1 hàng trong bảng ở giữa
function rowSelect(rowElement, data, pkField) {
    // Gỡ bỏ class selected của các dòng đã chọn trước đó
    const rows = document.querySelectorAll('#dataTable tbody tr');
    rows.forEach(r => r.classList.remove('selected'));
    
    // Thêm class selected làm nổi bật dòng hiện tại
    rowElement.classList.add('selected');
    selectedRowData = data;
    selectedRowData._pkField = pkField; // Lưu giữ tên cột khóa chính
    
    // Mở khóa kích hoạt cho nút Sửa dữ liệu và Xóa dữ liệu ở bên phải
    document.getElementById('btnEdit').classList.add('active-btn');
    document.getElementById('btnDelete').classList.add('active-btn');
}

// Bật Modal Form Thêm Mới
function openAddModal(pkField) {
    document.getElementById('modalTitle').innerText = "Thêm dữ liệu mới";
    document.getElementById('formAction').value = "add";
    document.getElementById('modalForm').reset();
    
    // Khi thêm mới, ô nhập khóa chính được phép nhập tự do không bị khóa
    const pkInput = document.getElementById('input_' + pkField);
    if(pkInput) pkInput.removeAttribute('readonly');
    
    document.getElementById('dataModal').style.display = 'flex';
}

// Bật Modal Form Sửa (Tự động map dữ liệu từ dòng đang chọn lên form nhập)
function openEditModal() {
    if (!selectedRowData) return;
    
    document.getElementById('modalTitle').innerText = "Sửa thông tin trực tiếp";
    document.getElementById('formAction').value = "edit";
    
    // Lặp qua các cặp key-value để đổ ngược dữ liệu vào các thẻ input tương ứng
    for (let key in selectedRowData) {
        if (key === '_pkField') continue;
        const inputElement = document.getElementById('input_' + key);
        if (inputElement) {
            inputElement.value = selectedRowData[key];
        }
    }
    
    // Đóng băng cột khóa chính (Read-only) không cho phép sửa đổi giá trị ID khi UPDATE dữ liệu
    const pkField = selectedRowData._pkField;
    const pkInput = document.getElementById('input_' + pkField);
    if(pkInput) pkInput.setAttribute('readonly', true);
    
    document.getElementById('dataModal').style.display = 'flex';
}

// Hàm đóng Pop-up Modal dữ liệu
function closeModal() {
    document.getElementById('dataModal').style.display = 'none';
}

// Hàm thực thi việc gửi yêu cầu xóa dòng chọn lên hệ thống dữ liệu
function deleteRecord() {
    if (!selectedRowData) return;
    const pkField = selectedRowData._pkField;
    const pkValue = selectedRowData[pkField];
    
    if (confirm(`Hệ thống sẽ thực hiện xóa trực tiếp bản ghi có mã [ ${pkValue} ] khỏi cơ sở dữ liệu. Bạn chắc chắn muốn tiếp tục?`)) {
        document.getElementById('deleteId').value = pkValue;
        document.getElementById('deleteForm').submit();
    }
}

// Tự động đóng modal nếu người dùng click trượt ra khu vực bên ngoài khung form mẫu
window.onclick = function(event) {
    const modal = document.getElementById('dataModal');
    if (event.target == modal) {
        closeModal();
    }
}