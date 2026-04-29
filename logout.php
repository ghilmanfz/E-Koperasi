<?php
session_start();
$_SESSION = [];
$_SESSION['flash'] = ['type' => 'success', 'msg' => 'Anda berhasil logout.'];
session_regenerate_id(true);
header('Location: login.php');
exit;
?>