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
  $Admin = "Abhishek";
  $image = $_FILES["Image"]["name"];
  $Target = "upload/".basename($_FILES["Image"]["name"]);
}else {
  global $connecting_db;
  global $connection;
  $deletefromURL = $_GET['delete'];
  $query = "DELETE FROM admin_panel WHERE id='$deletefromURL'";
  $execute = mysqli_query($connection,$query)or die(mysqli_error($connection));
  move_uploaded_file($_FILES["Image"]["tmp_name"], $Target);
  if($execute){
    $_SESSION['SuccessMessage']="Post deleted successfully";
    redirect("admin.php");
}

else {
  $_SESSION['ErrorMessage']="Something went wrong";
  redirect("admin.php");
}
}


 ?>
<html>

  <head>
    <title>Delete post</title>
    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="css/adminstyle.css">
    <script src="js/jquery-3.2.1.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <style>
h4{
color: 868686;
}
    </style>
  </head>

  <body>
    <div class="container-fluid">
      <div class="row">
        <div class="col-sm-2">
          <h2>Update post</h2>
          <ul class="nav nav-pills nav-stacked" id="side-menu">
            <li><a href="admin.php">  <span class="glyphicon glyphicon-th"></span>
              Dashboard</a></li>
            <li class="active"><a href="newpost.php"><span class="glyphicon glyphicon-list-alt"></span>&nbsp; New post</a></li>
            <li><a href="cat.php" ><span class="glyphicon glyphicon-tags"></span> &nbsp;Categories</a></li>
            <li><a href="#"><span class="glyphicon glyphicon-user"></span>&nbsp; Manage admins</a></li>
            <li><a href="#"><span class="glyphicon glyphicon-comment"></span>&nbsp;Comments</a></li>
            <li><a href="#"><span class="glyphicon glyphicon-equalizer"></span>&nbsp;Live blog</a></li>
            <li><a href="#"><span class="glyphicon glyphicon-log-out"></span>&nbsp;Logout</a></li>
          </ul>
        </div>
          <div class="col-sm-10">
            <h1><u>Delete posts</u></h1>
            <div><?php echo Message(); echo SMessage(); ?></div>
            <div>
              <?php
              global $connecting_db;
              global $connection;
              $queryparam = $_GET['delete'];
              $query = "SELECT * FROM admin_panel WHERE id ='$queryparam'";
              $execute = mysqli_query($connection,$query)or die(mysqli_error($connection));
              while ($Datarow = mysqli_fetch_array($execute, MYSQLI_ASSOC)) {
                 $title=$Datarow['title'];
                 $category=$Datarow['category'];
                 $image=$Datarow['image'];
                 $post=$Datarow['post'];
               }
               ?>
            </div>
            <div>
              <form action="deletepost.php?delete=<?php echo $queryparam; ?>" method="post" enctype="multipart/form-data">
                <fieldset>
                  <div class="form-group">
                <label for="Title"><h4>Title:</h4></label>
                <input disabled value="<?php echo $title; ?>" class="form-control" type="text" name="Title" id="Title" placeholder="Title">
                  </div>
                  <div class="form-group">
                    <span class="FieldInfo"><h4>Existing Category:</h4></span>
                    <?php echo $category; ?><br>
                    <label for="categoryinfo"><h4>Category:</h4></label>
                    <select disabled class="form-control" id="categoryinfo" name="Category">

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
                    <span class="FieldInfo"><h4>Existing Image:</h4></span>
                    <img src="upload/<?php echo $image; ?>" width="170px" height="80px"><br>
                <label for="selectimage"><h4>Select Image:</h4></label>
                <input disabled type="file" class="form-control" name="Image" id="selectimage">
                </div>
                <div class="form-group">
              <label for="postarea"><h4>Post:</h4></label>
              <textarea disabled class="form-control" name="post" id="Postarea" rows="5"><?php echo $post; ?></textarea>
              </div>

                  <input class="btn btn-danger btn-block" type="submit" name="Submit" value="Delete Post!">
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
