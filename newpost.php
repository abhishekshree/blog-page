<?php require_once("include/db.php"); ?>
<?php require_once("include/sessions.php"); ?>
<?php require_once("include/functions.php"); ?>
<?php confirm_login(); ?>
<?php
if (isset($_POST['Submit'])) {
  $Title = $_POST['Title'];
  $Category = $_POST['Category'];
  $Post = $_POST['post'];
  date_default_timezone_set("Asia/Kolkata");
  $currenttime=time();
  //$datetime = strftime("%Y-%m-%d %H:%M:%S",$currenttime);
  $datetime = strftime("%B-%d-%Y %H:%M:%S %a",$currenttime);
  $datetime;
  $Admin = $_SESSION['User_id'];
  $image = $_FILES["Image"]["name"];
  $Target = "upload/".basename($_FILES["Image"]["name"]);
  if (empty($Title)) {
    $_SESSION['ErrorMessage']="Empty title not accepted !";
    redirect("newpost.php");
}

elseif (strlen($Title)<2) {
  $_SESSION['ErrorMessage']="Too small name for title";
    redirect("newpost.php");
}

else {
  global $connecting_db;
  global $connection;
  $query = "INSERT INTO admin_panel(datetime, title ,category, author,image, post) VALUES('$datetime','$Title','$Category','$Admin','$image','$Post')";
  $execute = mysqli_query($connection,$query)or die(mysqli_error($connection));
  move_uploaded_file($_FILES["Image"]["tmp_name"], $Target);
  if($execute){
    $_SESSION['SuccessMessage']="Post added successfully";
    redirect("newpost.php");
}

else {
  $_SESSION['ErrorMessage']="Something went wrong";
  redirect("newpost.php");
}
}
}

 ?>
<html>

  <head>
    <title>Admin-Dashboard</title>
    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="css/adminstyle.css">
    <script src="js/jquery-3.2.1.min.js"></script>
    <script src="js/bootstrap.min.js"></script>

  </head>

  <body>
    <div class="container-fluid">
      <div class="row">
        <div class="col-sm-2">
          <h2>Add a new post</h2>
          <ul class="nav nav-pills nav-stacked" id="side-menu">
            <li><a href="admin.php">  <span class="glyphicon glyphicon-th"></span>
              Dashboard</a></li>
            <li class="active"><a href="newpost.php"><span class="glyphicon glyphicon-list-alt"></span>&nbsp; New post</a></li>
            <li><a href="cat.php"><span class="glyphicon glyphicon-tags"></span> &nbsp;Categories</a></li>
            <li><a href="manageadmin.php"><span class="glyphicon glyphicon-user"></span>&nbsp; Manage admins</a></li>
            <li><a href="comments.php"><span class="glyphicon glyphicon-comment"></span>&nbsp;Comments
              <?php
              global $connecting_db;
              global $connection;
              $query4 = "SELECT COUNT(*) FROM comments WHERE status = 'OFF'";
              $execute4 = mysqli_query($connection,$query4)or die(mysqli_error($connection));
              $Datarow4 = mysqli_fetch_array($execute4, MYSQLI_ASSOC);
              $result3= array_shift($Datarow4);

               ?>
               <span class="label pull-right label-warning"><?php echo $result3; ?></span>
            </a></li>
            <li><a href="#"><span class="glyphicon glyphicon-equalizer"></span>&nbsp;Live blog</a></li>
            <li><a href="logout.php"><span class="glyphicon glyphicon-log-out"></span>&nbsp;Logout</a></li>
          
          </ul>
        </div>
          <div class="col-sm-10">
            <h1><u>Add new posts</u></h1>
            <div><?php echo Message(); echo SMessage(); ?></div>
            <div>
              <form action="newpost.php" method="post" enctype="multipart/form-data">
                <fieldset>
                  <div class="form-group">
                <label for="Title"><h4>Title:</h4></label>
                <input class="form-control" type="text" name="Title" id="Title" placeholder="Title">
                  </div>
                  <div class="form-group">
                    <label for="categoryinfo"><h4>Category:</h4></label>
                    <select class="form-control" id="categoryinfo" name="Category">
                      <?php
                      global $connecting_db;
                      global $connection;
                      $view ="SELECT * FROM category ORDER BY dateandtime desc";
                      $execute = mysqli_query($connection,$view)or die(mysqli_error($connection));
                       while ($Datarow = mysqli_fetch_array($execute, MYSQLI_ASSOC)) {
                        $id = $Datarow["id"];
                        $name = $Datarow["name"];

                        ?>
                        <option><?php echo $name; ?></option>
                        <?php } ?>
                    </select>
                  </div>
                  <div class="form-group">
                <label for="selectimage"><h4>Select Image:</h4></label>
                <input type="file" class="form-control" name="Image" id="selectimage">
                </div>
                <div class="form-group">
              <label for="postarea"><h4>Post:</h4></label>
              <textarea class="form-control" name="post" id="Postarea"></textarea>
              </div>

                  <input class="btn btn-success btn-block" type="submit" name="Submit" value="Add new Post!">
                </fieldset>
              </form>
            </div>

          </div>
      </div>
    </div>
    <div id="footer">
      <hr width="10" height=100>
      <p>Project made by Abhishek Shree <sup>&copy;</sup><br>
      All rights reserved</p>
    </div>
  </body>
</html>
u
