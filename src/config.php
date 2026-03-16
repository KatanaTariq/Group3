<?php

// Automatically detect project base folder
$scriptDir = dirname($_SERVER['SCRIPT_NAME']);
$base = rtrim($scriptDir, '/');


if (!defined('BASE_URL')) {
    define('BASE_URL', $base === '/' ? '' : $base);
}