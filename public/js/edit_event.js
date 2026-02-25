const startInput = document.getElementById('start_date');
const endInput = document.getElementById('end_date');

// เมื่อมีการเปลี่ยนค่าในวันจบ
endInput.addEventListener('change', function () {
    if (startInput.value && endInput.value) {
        if (new Date(startInput.value) > new Date(endInput.value)) {
            alert('วันเริ่มห้ามอยู่หลังวันจบ!');
            endInput.value = ''; // ล้างค่าที่ผิดออก
        }
    }
});