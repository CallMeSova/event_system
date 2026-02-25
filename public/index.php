<?php

session_start();

const INCLUDE_DIR = __DIR__ .  '/../includes';
const ROUTE_DIR = __DIR__ . '/../routes';
const TEMPLATES_DIR = __DIR__ . '/../templates';
const DATABASES_DIR = __DIR__ . '/../databases';

require_once INCLUDE_DIR . '/database.php';
require_once INCLUDE_DIR . '/otp.php';
require_once INCLUDE_DIR . '/router.php';
require_once INCLUDE_DIR . '/view.php';

dispath($_SERVER['REQUEST_URI'], $_SERVER['REQUEST_METHOD']);
