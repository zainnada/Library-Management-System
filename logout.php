<?php
session_start();
session_unset();
session_destroy();
// حذف الكوكيز
setcookie("admin", "", time() - 3600, "/"); // تعيين تاريخ انتهاء صلاحية في الماضي لحذف الكوكيز
header("Location: login.php");
exit();
?>
