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
            <li><a href="Blog.php" target="_blank">Blog</a></li>
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
            <li><a href="admin.php">  <span class="glyphicon glyphicon-th"></span>
              Dashboard</a></li>
            <li><a href="newpost.php"><span class="glyphicon glyphicon-list-alt"></span>&nbsp; New post</a></li>
            <li><a href="cat.php"><span class="glyphicon glyphicon-tags"></span> &nbsp;Categories</a></li>
            <li><a href="manageadmin.php"><span class="glyphicon glyphicon-user"></span>&nbsp; Manage admins</a></li>
            <li class="active"><a href="comments.php"><span class="glyphicon glyphicon-comment"></span>&nbsp;Comments
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
          <h1>Un-Approved Comments</h1>
          <div><?php echo Message(); echo SMessage(); ?></div>
          <div class="table-responsive">
            <table class="table table-striped table-hover">
              <tr>
                <th>No.</th>
                <th>Name</th>
                <th>Date</th>
                <th>Comment</th>
                <th>Approve</th>
                <th>Delete comment</th>
                <th>Details</th>
              </tr>
          <?php
          global $connecting_db;
          global $connection;
          $query = "SELECT * FROM comments WHERE status = 'OFF' ORDER BY datetime DESC";
          $execute = mysqli_query($connection,$query)or die(mysqli_error($connection));
          $srno=0;
          while ($Datarow = mysqli_fetch_array($execute, MYSQLI_ASSOC)) {
            $commentid = $Datarow['id'];
            $commentdate = $Datarow['datetime'];
            $name = $Datarow['name'];
            $comment = $Datarow['comment'];
            $adminpanelid = $Datarow['admin_panel_id'];
            $srno++;
           ?>
           <tr>
             <td><?php echo $srno; ?></td>
             <td style="color:#5e5eff;"><?php echo $name; ?></td>
             <td><?php if (strlen($commentdate)>16) {
               $commentdate=substr($commentdate,0,16).'..';
             }
             echo $commentdate; ?></td>
             <td><?php
              echo $comment; ?></td>
             <td><a href="approvecomments.php?id=<?php echo $commentid; ?>"><span class="btn btn-success">Approve</span></a></td>
             <td><a href="deletecomments.php?id=<?php echo $commentid; ?>"><span class="btn btn-danger">Delete</span></a></td>
             <td><a href="fullpost.php?id=<?php echo $adminpanelid; ?>" target="_blank"><span class="btn btn-primary">Live Preview</span></a></td>
           </tr>
<?php } ?>
            </table>
            <h1>Approved Comments</h1>
            <div><?php echo Message(); echo SMessage(); ?></div>

              <table class="table table-striped table-hover">
                <tr>
                  <th>No.</th>
                  <th>Name</th>
                  <th>Date</th>
                  <th>Comment</th>
                  <th>Approved by</th>
                  <th>Revert Approve</th>
                  <th>Delete comment</th>
                  <th>Details</th>
                </tr>
            <?php
            global $connecting_db;
            global $connection;
            $query = "SELECT * FROM comments WHERE status = 'ON' ORDER BY datetime DESC";
            $execute = mysqli_query($connection,$query)or die(mysqli_error($connection));
            $srno=0;$Admin = $_SESSION['User_id'];
            while ($Datarow = mysqli_fetch_array($execute, MYSQLI_ASSOC)) {
              $commentid = $Datarow['id'];
              $commentdate = $Datarow['datetime'];
              $name = $Datarow['name'];
              $comment = $Datarow['comment'];
              $approvedby = $Datarow['approvedby'];
              $adminpanelid = $Datarow['admin_panel_id'];
              $srno++;
             ?>
             <tr>
               <td><?php echo $srno; ?></td>
               <td style="color:#5e5eff;"><?php echo $name; ?></td>
               <td><?php if (strlen($commentdate)>16) {
                 $commentdate=substr($commentdate,0,16).'..';
               }
               echo $commentdate; ?></td>
               <td><?php
                echo $comment; ?></td>
                <td><?php echo $approvedby; ?></td>
               <td><a href="disapprovecomments.php?id=<?php echo $commentid; ?>"><span class="btn btn-warning">Un-Approve</span></a></td>
               <td><a href="deletecomments.php?id=<?php echo $commentid; ?>"><span class="btn btn-danger">Delete</span></a></td>
               <td><a href="fullpost.php?id=<?php echo $adminpanelid; ?>" target="_blank"><span class="btn btn-primary">Live Preview</span></a></td>
             </tr>
  <?php } ?>
              </table>

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
