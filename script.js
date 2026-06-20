let selectedRowData = null;

// Chọn hàng hiển thị
function rowSelect(rowElement, data, pkField) {
    const rows = document.querySelectorAll('#dataTable tbody tr');
    rows.forEach(r => r.classList.remove('selected'));
    
    rowElement.classList.add('selected');
    selectedRowData = data;
    selectedRowData._pkField = pkField; 
    
    document.getElementById('btnEdit').classList.add('active-btn');
    document.getElementById('btnDelete').classList.add('active-btn');
}

// Thêm dữ liệu
function openAddModal(pkField) {
    document.getElementById('modalTitle').innerText = "Thêm dữ liệu mới";
    document.getElementById('formAction').value = "add";
    document.getElementById('modalForm').reset();
    
    const pkInput = document.getElementById('input_' + pkField);
    if(pkInput) pkInput.removeAttribute('readonly');
    
    document.getElementById('dataModal').style.display = 'flex';
}

// Sửa dữ liệu
function openEditModal() {
    if (!selectedRowData) return;
    
    document.getElementById('modalTitle').innerText = "Sửa thông tin trực tiếp";
    document.getElementById('formAction').value = "edit";
    
    for (let key in selectedRowData) {
        if (key === '_pkField') continue;
        const inputElement = document.getElementById('input_' + key);
        if (inputElement) {
            inputElement.value = selectedRowData[key];
        }
    }
    
    const pkField = selectedRowData._pkField;
    const pkInput = document.getElementById('input_' + pkField);
    if(pkInput) pkInput.setAttribute('readonly', true);
    
    document.getElementById('dataModal').style.display = 'flex';
}

function closeModal() {
    document.getElementById('dataModal').style.display = 'none';
}

// Xóa dữ liệu
function deleteRecord() {
    if (!selectedRowData) return;
    const pkField = selectedRowData._pkField;
    const pkValue = selectedRowData[pkField];
    
    if (confirm(`Hệ thống sẽ thực hiện xóa trực tiếp bản ghi có mã [ ${pkValue} ] khỏi cơ sở dữ liệu. Bạn chắc chắn muốn tiếp tục?`)) {
        document.getElementById('deleteId').value = pkValue;
        document.getElementById('deleteForm').submit();
    }
}

window.onclick = function(event) {
    const modal = document.getElementById('dataModal');
    if (event.target == modal) {
        closeModal();
    }
}