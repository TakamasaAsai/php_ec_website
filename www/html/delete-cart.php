<?php
session_start();
require_once('functions.php');
$delete_name = isset($_POST['delete_name']) ? h($_POST['delete_name'], ENT_QUOTES, 'utf-8') : '';
if ($delete_name != '') unset($_SESSION['products'][$delete_name]);
header('Location: ./cart.php');
