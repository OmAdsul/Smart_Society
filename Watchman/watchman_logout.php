<?php
session_start();
session_destroy();
header("Location: watchman_login.php");
exit;
