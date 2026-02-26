document.getElementById('registerForm').addEventListener('submit', function (event) {
    const password = document.getElementById('password').value;
    const confirmPassword = document.getElementById('confirm_password').value;

    if (password !== confirmPassword) {
        // 1. หยุดการส่งฟอร์ม
        event.preventDefault();

        // 2. แจ้งเตือนผู้ใช้
        alert('❌ รหัสผ่านทั้งสองช่องไม่ตรงกันครับ ลองเช็คดูอีกทีนะ!');

        // 3. (Optional) โฟกัสไปที่ช่องยืนยันรหัสเพื่อให้เขาแก้
        document.getElementById('confirm_password').focus();
    }
});