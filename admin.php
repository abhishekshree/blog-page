<?php require_once("include/db.php"); ?>
<?php require_once("include/sessions.php"); ?>
<?php require_once("include/functions.php"); ?>
<?php confirm_login(); ?>
<html>

  <head>
    <title>Admin-Dashboard</title>
    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="css/adminstyle.css">
    <script src="js/jquery-3.2.1.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
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
          <ul class="nav navbar-nav">
            <li class="active"><a href="#">Home</a></li>
            <li><a href="Blog.php?Page=1" target="_blank">Blog</a></li>
            <li><a href="">About us</a></li>
            <li><a href="">Contact us</a></li>
            <li><a href="">Features</a></li>
          </ul>
          <form action="blog.php" class="navbar-form navbar-right">
            <div class="form-group">
              <input type="text" class="form-control" placeholder="Search" name="search">
            </div>
              <button class="btn btn-default" name="searchbutton">GO</button>
          </form>
        </div>
      </div>
    </nav>
    <div class="container-fluid">
      <div class="row">
        <div class="col-sm-2">
          <br><br>
          <ul class="nav nav-pills nav-stacked" id="side-menu">
            <li class="active"><a href="admin.php">  <span class="glyphicon glyphicon-th"></span>
              Dashboard</a></li>
            <li><a href="newpost.php"><span class="glyphicon glyphicon-list-alt"></span>&nbsp; New post</a></li>
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
          <h1>Admin-Dashboard</h1>
          <div><?php echo Message(); echo SMessage(); ?></div>
          <div class="table-responsive">
            <table class="table table-striped table-hover">
              <tr>
                <th>Number</th>
                <th>Post Title</th>
                <th>Date and time</th>
                <th>Author</th>
                <th>Category</th>
                <th>Banner</th>
                <th>Comments</th>
                <th>Action</th>
                <th>Details</th>
              </tr>
              <?php
              global $connecting_db;
              global $connection;
              $view="SELECT * FROM admin_panel ORDER BY datetime DESC";
              $execute = mysqli_query($connection,$view)or die(mysqli_error($connection));
              $sr = 0;
              while ($Datarow = mysqli_fetch_array($execute, MYSQLI_ASSOC)) {
                 $id=$Datarow['id'];
                 $date=$Datarow['datetime'];
                 $title=$Datarow['title'];
                 $category=$Datarow['category'];
                 $admin=$Datarow['author'];
                 $image=$Datarow['image'];
                 $post=$Datarow['post'];
                 $sr++;
               ?>
               <tr>
                 <td><?php echo $sr ?></td>
                 <td style="color:#5e5eff;"><?php
                 if (strlen($title)>22) {
                   $title=substr($title,0,20).'..';
                 }
                 echo $title;
                 ?></td>
                 <td><?php
                 if (strlen($date)>17) {
                   $date=substr($date,0,17).'..';
                 }
                 echo $date;?></td>
                 <td><?php if (strlen($admin)>9) {
                   $admin=substr($admin,0,9).'..';
                 }
                  echo $admin; ?></td>
                 <td><?php echo $category; ?></td>
                 <td><img src="upload/<?php echo $image; ?>" width="130" height="50px"></td>
                 <td>
                <?php
                global $connecting_db;
                global $connection;
                $query2 = "SELECT COUNT(*) FROM comments WHERE admin_panel_id = '$id' AND status = 'ON'";
                $execute2 = mysqli_query($connection,$query2)or die(mysqli_error($connection));
                $Datarow = mysqli_fetch_array($execute2, MYSQLI_ASSOC);
                $result= array_shift($Datarow);
                $query3 = "SELECT COUNT(*) FROM comments WHERE admin_panel_id = '$id' AND status = 'OFF'";
                $execute3 = mysqli_query($connection,$query3)or die(mysqli_error($connection));
                $Datarow2 = mysqli_fetch_array($execute3, MYSQLI_ASSOC);
                $result2= array_shift($Datarow2);
                if ($result2>0 || $result >0) {


                ?>
                <span class="label pull-right label-success"><?php echo $result; ?></span>
                <span class="label pull-left label-danger"><?php echo $result2; ?></span>
                <?php } ?>
                </td>
                 <td>
                   <a href="editpost.php?Edit=<?php echo $id; ?>"><span class="btn btn-warning">Edit</span></a>
                   <a href="deletepost.php?delete=<?php echo $id; ?>"><span class="btn btn-danger">Delete</span></a></td>
                 <td><a href="fullpost.php?id=<?php echo $id; ?>" target="_blank"><span class="btn btn-primary">Preview</span></a></td>
               </tr>
               <?php } ?>
            </table>
          </div>
          </div>
      </div>
    </div>
    <footer class="footer">
      <div class="container">
        <p class="text-muted">Project made by Abhishek Shree</p>
      </div>
    </footer>


  </body>
</html>
