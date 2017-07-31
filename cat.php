<?php require_once("include/db.php"); ?>
<?php require_once("include/sessions.php"); ?>
<?php require_once("include/functions.php"); ?>

<?php confirm_login(); ?>
<?php
if (isset($_POST['Submit'])) {
  $category = $_POST['Category'];
  date_default_timezone_set("Asia/Kolkata");
  $currenttime=time();
  //$datetime = strftime("%Y-%m-%d %H:%M:%S",$currenttime);
  $datetime = strftime("%B-%d-%Y %H:%M:%S %a",$currenttime);
  $datetime;
    $Admin = $_SESSION['User_id'];
  if (empty($category)) {
    $_SESSION['ErrorMessage']="All fields must be filled";
    redirect("admin.php");
}

elseif (strlen($category)>99) {
  $_SESSION['ErrorMessage']="Too long name for category";
    redirect("cat.php");
}

else {
  global $connecting_db;
  global $connection;
  $query = "INSERT INTO category(dateandtime, name ,creatorname) VALUES('$datetime','$category','$Admin')";
  $execute = mysqli_query($connection,$query)or die(mysqli_error($connection));
  if($execute){
    $_SESSION['SuccessMessage']="Category added successfully";
    redirect("cat.php");
}

else {
  $_SESSION['ErrorMessage']="Something went wrong";
  redirect("cat.php");
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
          <h2>Category</h2>
          <ul class="nav nav-pills nav-stacked" id="side-menu">
            <li><a href="admin.php">  <span class="glyphicon glyphicon-th"></span>
              Dashboard</a></li>
            <li><a href="admin.php">  <span class="glyphicon glyphicon-th"></span>
              Dashboard</a></li>
            <li><a href="newpost.php"><span class="glyphicon glyphicon-list-alt"></span>&nbsp; New post</a></li>
            <li class="active"><a href="cat.php"><span class="glyphicon glyphicon-tags"></span> &nbsp;Categories</a></li>
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
            <h1><u>Manage Categories</u></h1>
            <div><?php echo Message(); echo SMessage(); ?></div>
            <div>
              <form action="cat.php" method="post">
                <fieldset>
                  <div class="form-group">
                <label for="categoryname"><h4>Name:</h4></label>
                <input class="form-control" type="text" name="Category" id="categoryname" placeholder="Name">
                  </div>
                  <input class="btn btn-success btn-block" type="submit" name="Submit" value="Add new Category!">
                </fieldset>
              </form>
            </div>
            <div class="table-responsive">
            <table class="table table-striped table-hover">
              <tr>
                <th>S.no.</th>
                <th>Date and time</th>
                <th>Name</th>
                <th>Author name</th>
                <th>Action</th>
              </tr>
              <?php
              global $connecting_db;
              global $connection;
              $view ="SELECT * FROM category ORDER BY dateandtime desc";
              $execute = mysqli_query($connection,$view)or die(mysqli_error($connection));
              $SrNo = 0;
              while ($Datarow = mysqli_fetch_array($execute, MYSQLI_ASSOC)) {
                $id = $Datarow["id"];
                $dt = $Datarow["dateandtime"];
                $name = $Datarow["name"];
                $cr = $Datarow["creatorname"];
                $SrNo ++;
                ?>
               <tr>
                 <td><?php echo $SrNo; ?></td>
                 <td><?php echo $dt; ?></td>
                 <td><?php echo $name; ?></td>
                 <td><?php echo $cr; ?></td>
                 <td>
                   <a href="deletecategory.php?id=<?php echo $id; ?>"><span class="btn btn-danger">Delete</span></a>
                 </td>
               </tr>
               <?php } ?>
            </table>
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
