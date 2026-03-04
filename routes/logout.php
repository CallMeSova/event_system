<?php

//ล้างค่าตัวแปร Session ทั้งหมดw
$_SESSION = array();

session_destroy();

header("Location: /");
exit;
