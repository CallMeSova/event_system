<?php

function renderView($template, array $data = []) {
    extract($data);
    include TEMPLATES_DIR . '/' . $template . '.php';
}
