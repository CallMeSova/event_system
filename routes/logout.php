<?php

//ล้างค่าตัวแปร Session ทั้งหมด
$_SESSION = array();

session_destroy();

header("Location: /");
exit;
