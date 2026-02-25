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
