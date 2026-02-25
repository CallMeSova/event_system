<?php

/**
 * ไฟล์: databases/users.php
 * รวมฟังก์ชันจัดการข้อมูลผู้ใช้งาน (Users Model)
 */

/**
 * ฟังก์ชันสำหรับเช็คว่าอีเมลนี้ถูกใช้งานไปหรือยัง
 * ใช้ในไฟล์: routes/register.php
 */
function isEmailExists($email) {
    global $conn;
    $stmt = $conn->prepare("SELECT user_id FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->num_rows > 0;
}

/**
 * ฟังก์ชันสำหรับลงทะเบียนผู้ใช้ใหม่
 * ใช้ในไฟล์: routes/register.php
 */
function createUser($full_name, $email, $password, $gender, $birth_date, $phone, $role = 'user') {
    global $conn;
    $sql = "INSERT INTO users (full_name, email, password, gender, birth_date, phone_number, role, created_at) 
            VALUES (?, ?, ?, ?, ?, ?, ?, NOW())";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssssss", $full_name, $email, $password, $gender, $birth_date, $phone, $role);
    return $stmt->execute();
}

/**
 * ฟังก์ชันสำหรับดึงข้อมูลผู้ใช้จาก Email (ใช้ตรวจสอบตอน Login)
 * ใช้ในไฟล์: routes/login.php
 */
function getUserByEmail($email) {
    global $conn; // ใช้การเชื่อมต่อจาก database.php
    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    return $stmt->get_result()->fetch_assoc(); // ส่งข้อมูล User กลับไปเป็น Array
}
