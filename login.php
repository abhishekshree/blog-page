<?php require_once("include/db.php"); ?>
<?php require_once("include/sessions.php"); ?>
<?php require_once("include/functions.php"); ?>
<?php
if (isset($_POST['Submit'])) {
  $username = $_POST['Username'];
  $password = $_POST['Password'];
  if (empty($username) || empty($password)) {
    $_SESSION['ErrorMessage']="All fields must be filled";
    redirect("login.php");
}

else {
$found_account = login_attempt($username, $password);
if ($found_account) {
    $_SESSION['User_id']=$found_account['username'];
    $_SESSION['SuccessMessage']="Welcome {$_SESSION['User_id']}";
    redirect("admin.php");
}else {
    $_SESSION['ErrorMessage']="Invalid username or password!";
    redirect("login.php");
    }
  }
}

 ?>
<html>

  <head>
    <title>Login Page</title>
    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="css/adminstyle.css">
    <script src="js/jquery-3.2.1.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <style>
    body{
      background-color: #ffffff;
    }
    </style>
  </head>

  <body>

      <nav class="navbar navbar-inverse" role="navigation">
        <div class="container" >
          <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#collapse">
              <span class="sr-only">Toggle Navigation</span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
            </button>
            <h2 class="navbar-brand" style="margin-top:-5px;">BlogS</h2>
          </div>
          <div class="collapse navbar-collapse" id="collapse">

          </div>
        </div>
      </nav>
    <div class="container-fluid">
      <div class="row">

          <div class=" col-sm-offset-4 col-sm-4">
            <div><?php echo Message(); echo SMessage(); ?></div>
            <br><br>
            <h2 class="jumbotron"> Welcome back ! <h2>
            <div>
              <form action="login.php" method="post">
                <fieldset>
                  <div class="form-group">
                <label for="usernamename"><h4>Username:</h4></label>
                <div class="input-group input-group-lg">
                <span class="input-group-addon">
                  <span class="glyphicon glyphicon-envelope text-primary"></span>
                </span>
                <input class="form-control" type="text" name="Username" id="Username" placeholder="Username">
              </div>
                  </div>
                  <div class="form-group">
                <label for="Password"><h4>Password:</h4></label>
                <div class="input-group input-group-lg">
                  <span class="input-group-addon">
                    <span class="glyphicon glyphicon-lock text-primary"></span>
                  </span>
                <input class="form-control" type="password" name="Password" id="Password" placeholder="Password">
              </div>
                  </div>
                  <input class="btn btn-info btn-block" type="submit" name="Submit" value=" Login">
                </fieldset>
              </form>
            </div>

          </div>
      </div>
    </div>
  </body>
</html>
