<?php require_once("include/db.php"); ?>
<?php require_once("include/sessions.php"); ?>
<?php require_once("include/functions.php"); ?>
<?php
if (isset($_GET["id"])) {
  $id = $_GET["id"];
  global $connecting_db;
  global $connection;
  $query = "DELETE FROM category WHERE id='$id' ";
  $execute = mysqli_query($connection,$query)or die(mysqli_error($connection));
  if ($execute) {
    $_SESSION['SuccessMessage']="Category deleted successfully";
    redirect("cat.php");
  }else {
    $_SESSION['ErrorMessage']="Something went wrong !";
    redirect("cat.php");
  }

}
?>
