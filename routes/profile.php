<?php

if(!isset($_SESSION['user_id'])){
    header("Location: /login");
    exit();
}

$user_id = $_SESSION['user_id'];
$user = getProfileUser($user_id);

renderView('profile', ['user' => $user, 'title' => 'Profile']);