const imageInput = document.getElementById('imageInput');
const errorMsg = document.getElementById('error-msg');

imageInput.addEventListener('change', function () {
    if (this.files.length > 5) {
        errorMsg.innerText = "คุณสามารถเลือกรูปภาพได้ไม่เกิน 5 รูป";
        this.value = "";
    } else {
        errorMsg.innerText = "";
    }
});

function clearImages() {
    imageInput.value = "";
    errorMsg.innerText = "";
}

const startDate = document.getElementById('startDate');
const endDate = document.getElementById('endDate');
const dateError = document.getElementById('date-error');

startDate.addEventListener('change', function () {
    if (this.value) {
        endDate.disabled = false;
        endDate.min = this.value;
    } else {
        endDate.disabled = true;
        endDate.value = "";
    }
    validateDates();
});

endDate.addEventListener('change', function () {
    validateDates();
});

function validateDates() {
    if (startDate.value && endDate.value) {
        if (endDate.value < startDate.value) {
            dateError.innerText = "วันที่สิ้นสุดห้ามมาก่อนวันที่เริ่มงาน";
            endDate.value = "";
        } else {
            dateError.innerText = "";
        }
    }
}