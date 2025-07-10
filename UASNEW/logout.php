<?php
session_start();
session_destroy(); // hapus semua session
header("Location: login.html");
exit;
?>
