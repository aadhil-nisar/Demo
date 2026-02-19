<?php
require_once __DIR__ . '/config/app.php';
logout_user();
flash_set('Logged out successfully.', 'info');
header('Location: index.php');
exit;
