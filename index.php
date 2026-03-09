<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();

const INCLUDE_DIR = __DIR__ .  '/includes';
const ROUTE_DIR = __DIR__ . '/routes';
const TEMPLATES_DIR = __DIR__ . '/templates';
const DATABASES_DIR = __DIR__ . '/databases';

require_once INCLUDE_DIR . '/database.php';
require_once INCLUDE_DIR . '/otp.php';
require_once INCLUDE_DIR . '/router.php';
require_once INCLUDE_DIR . '/view.php';

require_once DATABASES_DIR . '/users.php';
require_once DATABASES_DIR . '/event.php';
require_once DATABASES_DIR . '/registrations.php';

dispath($_SERVER['REQUEST_URI'], $_SERVER['REQUEST_METHOD']);
