<?php

const ALLOW_METHOD = ['GET', 'POST'];
const INDEX_URI = '';
const INDEX_ROUTE = 'home';

function normalizeURI($uri) {
    // แยกเอาแค่ส่วนหน้าเครื่องหมาย ? ออกมา
    $uri = explode('?', $uri)[0];

    $uri = strtolower(trim($uri, '/'));
    return ($uri == INDEX_URI ? INDEX_ROUTE : $uri);
}

function notFound() {
    http_response_code(404);
    renderView('404');
    exit();
}

function getFilePath($uri) {
    return ROUTE_DIR . '/' . normalizeURI($uri) . '.php';
}

function dispath($uri, $method) {
    $uri = normalizeURI($uri);

    $timeout_duration = 3600;
    if (isset($_SESSION['user_id'])) {
        if (isset($_SESSION['last_activity'])) {
            $now_time = time() - $_SESSION['last_activity'];
            if ($now_time > $timeout_duration) {
                session_unset();
                session_destroy();
                echo '<script>
                        alert("ไม่ได้ใช้ระบบเป็นเวลานาน กรุณาเข้าสู่ระบบใหม่อีกครั้ง");
                        window.location.href = "/login";
                    </script>';
                exit();
            }
        }
        $_SESSION['last_activity'] = time();
    }

    $public_page = ['home', 'login', 'register',];
    if (!in_array($uri, $public_page) && !isset($_SESSION['user_id'])) {
        echo "<script>
                alert('กรุณาเข้าสู่ระบบเพื่อใช้งานส่วนนี้');
                window.location.href = '/login';
              </script>";
        exit;
    }

    if (!in_array(strtoupper($method), ALLOW_METHOD)) {
        notFound();
    }

    $filePath = getFilePath($uri);
    if (!file_exists($filePath)) {
        notFound();
    } else {
        include $filePath;
        exit();
    }
}
