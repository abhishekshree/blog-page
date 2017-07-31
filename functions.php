<?php require_once("include/db.php"); ?>
<?php require_once("include/sessions.php"); ?>

<?php
function redirect($new_location) {
  header("Location:$new_location");
  exit;
}


function login_attempt($Username, $Password){
  global $connecting_db;
  global $connection;
  $query = "SELECT * FROM registration WHERE username ='$Username' AND password = '$Password'";
  $execute = mysqli_query($connection,$query)or die(mysqli_error($connection));
  if ($admin=mysqli_fetch_assoc($execute)) {
    return $admin;
  }else {
    return null;
  }
}
function login(){
  if (isset($_SESSION['User_id'])){
    return true;
  }
}
function confirm_login(){
  if(!login()){
    $_SESSION['ErrorMessage']="Login required";
    redirect("login.php");
  }
}
?>
