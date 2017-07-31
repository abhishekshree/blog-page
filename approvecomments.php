<?php require_once("include/db.php"); ?>
<?php require_once("include/sessions.php"); ?>
<?php require_once("include/functions.php"); ?>
<?php
if (isset($_GET["id"])) {
  $id = $_GET["id"];
  global $connecting_db;
  global $connection;
    $Admin = $_SESSION['User_id'];
  $query = "UPDATE comments SET status = 'ON' , approvedby = '$Admin' WHERE id='$id' ";
  $execute = mysqli_query($connection,$query)or die(mysqli_error($connection));
  if ($execute) {
    $_SESSION['SuccessMessage']="Comment approved successfully";
    redirect("comments.php");
  }else {
    $_SESSION['ErrorMessage']="Something went wrong !";
    redirect("comments.php");
  }

}
?>
