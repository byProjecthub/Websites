<?php
declare(strict_types=1);
require_once '../includes/functions.php';
session_start();
unset($_SESSION['client_id'], $_SESSION['client_name'], $_SESSION['client_email']);
session_destroy();
redirect('login.php');