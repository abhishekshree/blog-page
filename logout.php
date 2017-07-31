<?php require_once("include/functions.php"); ?>
<?php require_once("include/sessions.php"); ?>

<?php
$_SESSION['User_id']=null;
session_destroy();
redirect("login.php");
?>